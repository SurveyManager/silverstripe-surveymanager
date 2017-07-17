<?php
class QuestionOption extends DataObject {

    private static $db = array (
        'Option' => 'Varchar(255)'
    );

    private static $has_one = array (
        'SurveyQuestion' => 'SurveyQuestion'
    );
    
    private static $summary_fields = array(
		"Option"
	);

    public function getCMSFields() {
		$fields = FieldList::create(
            TextField::create('Option')
        );
        return $fields;
    }
}
?>
