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
    echo $request;
    return "res1";
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
      $this->_return($this->API->questionSave($this->getRequest()->postVar('token'), $this->getRequest()->postVar('d')));
    }


  }
  ?>
