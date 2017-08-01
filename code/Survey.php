<?php
class Survey extends DataObject {

    private static $db = array (
        'Title' => 'Varchar(255)',
        'Description' => 'Text',
        'PIN' => 'Varchar(16)',
        'Type' => "Enum('all,user','all')"
    );
	private static $indexes = array(
		'UniquePIN' => array(
			'type' => 'unique', 
			'value' => '"PIN"'
		),
	);


    private static $has_one = array (
        'SurveysPage' => 'SurveysPage'
    );

    private static $has_many = array (
        'SurveyQuestions' => 'SurveyQuestion',
        'SurveyUsers' => 'SurveyUser',
        'SurveyResult' => 'SurveyResult'
    );

    public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeFieldFromTab("Root","SurveyResult");
        return $fields;
    }

    public function Link() {
        return $this->SurveysPage()->Link('show/'.$this->ID);
    }
}
?>
