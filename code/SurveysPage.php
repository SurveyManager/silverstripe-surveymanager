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
  public function saveajax(SS_HTTPRequest $request) {
    if( $request->isAjax() ) {
      $d = $request->postVar('saveData');
      // print_r( $sdata['surveyID'] );
      // echo"m1. ";
      $sur = Survey::get()->byID($d['surveyID']);
      $sur->Title = $d['surveyTitle'];
      $sur->Description = $d['surveyDescription'];
      $res['SurveyID'] = $sur->write();

      foreach ($d['questions'] as $Q) {
        if( is_numeric( $qID = $Q['questionID'] ) ){
          $quest = SurveyQuestion::get()->byID($Q['questionID']);
        } else {
          echo'm2. ';
          $quest = SurveyQuestion::create();
          $quest->SurveyID = $d['surveyID'];
          $qID = $quest->write();
        }
        $quest->Title = $Q['questionTitle'];
        $quest->Description = $Q['questionDescription'];
        // $quest->Type = $Q['questionsType'];
        // $quest->Other = $Q[''];
        foreach ($Q['options'] as $Op) {
          $opID = intval($Op['optionID']);
          if($opID < 0) QuestionOption::get()->byID($opID)->delete();
            else {
              if($opID > 0) $option = QuestionOption::get()->byID($opID);
              if($opID == 0) {
                $option = QuestionOption::create();
                $option->SurveyQuestionID = $qID;
              }
              $option->Option = $Op['optionText'];
              $optIDs[] = $option->write();
            }
          }
          $res['QuestID'][$quest->write()] = $optIDs; $optIDs = array();
        }
      }
      print_r( $res );
  }
  // Create survey pages by request /show/$ID
  // Show list of Questions and Answers
  public function show(SS_HTTPRequest $request) {
    $survey = Survey::get()->byID($request->param('ID'));
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
