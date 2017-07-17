<?php
class SurveyResult extends DataObject {

    private static $db = array (
        'SurveyHash' => 'Varchar(50)',
        'QuestionHash' => 'Varchar(50)',
        'QuestionID' => 'Int',
        'OptionID' => 'Int',
        'OptionText' => 'Text'
    );

    private static $has_one = array (
        'Survey' => 'Survey'
    );


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
