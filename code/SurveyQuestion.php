<?php
class SurveyQuestion extends DataObject {

    private static $db = array (
        'Title' => 'Varchar(255)',
        'Description' => 'Text',
        'Type2' => 'Varchar',
        'Type' => "Enum('text,one,multi','one')",
        'Other' => "Boolean"
    );

    private static $has_one = array (
        'Survey' => 'Survey'
    );

    private static $has_many = array (
        'QuestionOptions' => 'QuestionOption'
    );

    public static function getQuestionPlugins() {
		$plugins = array();
		// Todo catch "plugins" not so hardcoded
		$plugins['text']  = "Text";
		$plugins['one']   = "Select one";
		$plugins['multi'] = "Select multiply";
		return $plugins;
	}

    public function getCMSFields() {
		$fields = parent::getCMSFields();
		$questions_plugins = self::getQuestionPlugins();
		$fields->addFieldToTab('Root.Main', DropdownField::create('Type2', 'Question type', $questions_plugins)->setEmptyString('Select a question type...'));
        return $fields;
    }
}
?>
