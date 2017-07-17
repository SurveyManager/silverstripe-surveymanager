<?php
class Survey extends DataObject {

    private static $db = array (
        'Title' => 'Varchar(255)',
        'Description' => 'Text',
        'PIN' => 'Varchar(16)',
        'Type' => "Enum('all,user','all')"
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
        /*$fields->addFieldToTab('Root', GridField::create(
            'Surveys',
            'List of surveys',
            $this->Surveys(),
            GridFieldConfig_RecordEditor::create()
        ));*/

        return $fields;
    }
}
?>
