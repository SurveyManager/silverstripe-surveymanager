<?php
class SurveyResult extends DataObject {

    private static $db = array (
        'SurveyHash' => 'Varchar(50)',
        'QuestionHash' => 'Varchar(128)',
        'QuestionID' => 'Int',
        'OptionID' => 'Int',
        'UserID' => 'Int',
        'ResultTS' => 'Int',
        'OptionText' => 'Text'
    );

    private static $has_one = array (
        'Survey' => 'Survey'
    );
    
	private static $indexes = array(
		'SurveyHash' => array(
			'type' => 'index',
			'value' => '"SurveyHash"'
		),
		'QuestionHash' => array(
			'type' => 'index',
			'value' => '"QuestionHash"'
		),
		'QuestionID' => array(
			'type' => 'index',
			'value' => '"QuestionID"'
		),
		'OptionID' => array(
			'type' => 'index',
			'value' => '"OptionID"'
		),
	);
	// TODO maybe `UserID` must be index to? But for what? It's just for log



    public function getCMSFields() {
		$fields = parent::getCMSFields();
        /*$fields->addFieldToTab('Root.SurveyQuestion', GridField::create(
            'Surveys',
            'List of surveys',
            $this->Surveys(),
            GridFieldConfig_RecordEditor::create()
        ));*/

        return $fields;
    }
}
?>
