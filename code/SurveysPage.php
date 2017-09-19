<?php
class SurveysPage extends Page {
  private static $db = array ( // $db - add custom fields
    'APIkey' => 'Varchar(255)'
  );

  private static $has_many = array (
    'Surveys' => 'Survey'
  );

  public function getCMSFields() {
    $fields = parent::getCMSFields();
    if($this->ID > 0) {
      $fields->addFieldToTab('Root.Main', ReadonlyField::create('APIkey'),'Content');
    }
    $fields->addFieldToTab('Root.Surveys', GridField::create(
      'Surveys',
      'List of surveys',
      $this->Surveys(),
      GridFieldConfig_RecordEditor::create()
    ));
    return $fields;
  }
  protected function onbeforeWrite() {
    parent::onBeforeWrite();
    // TODO must be unique
    if ($this->APIkey=='' || !$this->APIkey) {
      $this->APIkey = sha1(time().rand(0,99999999)).md5(rand(5,999999999999));
    }
  }
}

class SurveysPage_Controller extends Page_Controller {
  private $API = false;

  private static $url_handlers = array(
    'API/auth'      => 'APIauth',
    'API/questions' => 'APIsurveyQuestions',
    'API/save'      => 'APIsaveResult'
  );
  private static $allowed_actions = array (
    'APIauth',
    'APIsurveyQuestions',
    'APIsaveResult',
    'show',
    'saveajax'
  );
  public function index(SS_HTTPRequest $request)  {
    $member = Member::currentUser();
    // JOIN
    $sqlQuery = new SQLSelect();
    $sqlQuery ->selectField('Survey.*')
              ->setFrom('Survey')
              ->addInnerJoin('SurveyUser',' Survey.ID = SurveyUser.SurveyID ')
              ->addWhere(array(
                  'SurveyUser.UserID' => $member->ID,
                  'SurveyUser.Role' => 'Admin',
                  'SurveyUser.Access' => 1
                ));

    $result = $sqlQuery->execute();

    $list = ArrayList::create();
    foreach($result as $row) {
        $list->push($row);
    }
    // echo('<pre>');print_r($list);echo('</pre>');
    return array(
      'Surveys' => $list
    );

  }

  public function saveajax(SS_HTTPRequest $request) {
    $member = Member::currentUser();
    $res['Member'] = $member->ID;
    if(!$member) {
      $res['Errors'][] = 'Auth error';
      return json_encode($res);
    }
    // Saving method - all data (Not using)
    if( $request->isAjax() && $d = $request->postVar('saveData') ) {
      $sur = Survey::get()->byID($d['surveyID']);
      $sur->Title = $d['surveyTitle'];
      $sur->Description = $d['surveyDescription'];
      $res['SurveyID'] = $sur->write();

      foreach ($d['questions'] as $Q) {
        $qID = intval($Q['questionID']);

        // Delete question
        if($qID < 0) {
          $res['Question Deleted'][] = SurveyQuestion::get()->byID( ($qID*(-1)) )->delete();
        }
        // New Question
        elseif ( $qID = 0 ) {
          $quest = SurveyQuestion::create();
          $quest->SurveyID = $d['surveyID'];
          $quest->Title = $Q['questionTitle'];
          $quest->Description = $Q['questionDescription'];
          $qID = $quest->write();
          $res['Question Created'][] = $qID;

          // Create one Option

        }
        // Edit question
        elseif( $qID > 0 ) {
          $quest = SurveyQuestion::get()->byID($Q['questionID']);
          $quest->Title = $Q['questionTitle'];
          $quest->Description = $Q['questionDescription'];

          foreach ($Q['options'] as $Op) {
            $opID = intval($Op['optionID']);
            if    ($opID < 0) {QuestionOption::get()->byID( ($opID*(-1)) )->delete();}
            elseif($opID > 0) {
              $option = QuestionOption::get()->byID($opID);
              $option->Option = $Op['optionText'];
            }
            elseif($opID == 0) {
                  $option = QuestionOption::create();
                  $option->SurveyQuestionID = $qID;
                  $option->Option = $Op['optionText'];
                  $optIDs[] = $option->write();
            }
          }
        }

          // $res['QuestID'][$quest->write()] = $optIDs; $optIDs = array();
      }
      print_r( $res );
    }

    // Saving method - one field
    elseif ($request->isAjax() && $data = $request->postVar('saveOne')) {
      $res['InputData'] = $data; // Output income data for checking
      // Objects: Survey, Question, Option
      switch ($data['object']) {
        case 'Survey':
          // $res['SwitchObject'] = 'Survey';
          $Object = Survey::get()->byID($data['id']);break;
        case 'Question':
          // $res['SwitchObject'] = 'Question';
          $Object = SurveyQuestion::get()->byID($data['id']);break;
        case 'Option':
          // $res['SwitchObject'] = 'Option';
          $Object = QuestionOption::get()->byID($data['id']);
          $Object->Option = $data['val'];break;
        default:
          $res['Errors'][] =" Wrong type of object (Expect: Survey, Question, Option) ";
          break;
      }

      // Types: Title, Txt, Select
      switch ($data['type']) {
        case 'Title':
          // $res['SwitchType'] = 'Title';
          $Object->Title = $data['val'];break;
        case 'Txt':
          // $res['SwitchType'] = 'Txt';
          $Object->Description = $data['val'];break;
        case 'Select':
          // $res['SwitchType'] = 'Select';
          $Object->Type = $data['val'];break;

        default:
          $res['Errors'][] =" Wrong type of data (Expect: Title, Txt, Select) ";
          break;
      }
      if( !$res['Errors'] ) $res['SaveingRes'] = $Object->write();
    }
    // Add new Object
    elseif( $request->isAjax() && $data = $request->postVar('newOne') ){

      $res['InputData'] = $data;
      switch ($data['object']) { // Question, Option
        case 'Option':
          $option = QuestionOption::create();
          $option->SurveyQuestionID = $data['parentID'];
          $newOptionID = $option->write();
          break;
        case 'Question':
          $question = SurveyQuestion::create();
          $question->SurveyID = $data['parentID'];
          $newQuestionID = $question->write();

          $option = QuestionOption::create();
          $option->SurveyQuestionID = $newQuestionID;
          $newOptionID = $option->write();
          break;
        case 'Survey':
          $survey = Survey::create();
          $survey->Title = 'New Survey';
          $survey->SurveysPageID = 6;
          $survey->PIN = rand(100,999);
          $newSurveyID = $survey->write();

          $SurveyUser = SurveyUser::create();
          $SurveyUser->UserEmail = $member->Email;
          $SurveyUser->Role = 'Admin';
          $SurveyUser->Access = 1;
          $SurveyUser->SurveyID = $newSurveyID;
          $SurveyUser->write();

          $question = SurveyQuestion::create();
          $question->SurveyID = $newSurveyID;
          $newQuestionID = $question->write();

          $option = QuestionOption::create();
          $option->SurveyQuestionID = $newQuestionID;
          $newOptionID = $option->write();
          break;

        default:
          # code...
          break;
      }
      $res['newSurveyID'] = $newSurveyID;
      $res['newQuestionID'] = $newQuestionID;
      $res['newOptionID'] = $newOptionID;
      // return json_encode($res);
    }
    // Detete Object
    elseif ( $request->isAjax() && $data = $request->postVar('delOne') ) {
      $res['InputData-del'] = $data; // Output income data for checking
      // Objects: Survey, Question, Option
      switch ($data['object']) {
        case 'Survey':
          $Object = Survey::get()->byID($data['id']);break;
        case 'Question':
          $Object = SurveyQuestion::get()->byID($data['id']);break;
        case 'Option':
          $Object = QuestionOption::get()->byID($data['id']);break;
        default:
          $res['Errors'][] =" Wrong type of object (Expect: Survey, Question, Option) ";break;
      }
      if( !$res['Errors'] ) $res['DeleteRes'] = $Object->delete();
      // print_r($res);
    }

    return json_encode($res);
  }
  // Create survey pages by request /show/$ID
  // Show list of Questions and Answers
  public function show(SS_HTTPRequest $request) {
    $surveyID = $request->param('ID');
    $survey = Survey::get()->byID($surveyID);
    if(!$survey) return $this->httpError(404,'That region could not be found');
    $Questions = $survey->SurveyQuestions();

    return array (
      'Survey' => $survey,
      'Questions' => $Questions
    );
  }




  function _return($out) {
    print json_encode($out,JSON_UNESCAPED_UNICODE);
    die();
  }
  private function _initAPI() {
    if ($this->API===false) $this->API=new SurveyAPI();
  }
  public function APIauth () {
    $this->_initAPI();
    $this->_return(
      $this->API->APIauth(
        $this->getRequest()->postVar('email'),
        $this->getRequest()->postVar('pin')
      ));
    }
    public function APIsurveyQuestions() {
      $this->_initAPI();
      $this->_return($this->API->surveyQuestions($this->getRequest()->postVar('token')));
    }
    public function APIsaveResult() {
      $this->_initAPI();
      $this->_return(
        $this->API->questionSave(
          $this->getRequest()->postVar('token'),
          $this->getRequest()->postVar('d')
        )
      );
    }


  }
  ?>
