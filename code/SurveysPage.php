<?php
class SurveysPage extends Page {

    private static $has_many = array (
        'Surveys' => 'Survey'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Surveys', GridField::create(
            'Surveys',
            'Surveys made',
            $this->Surveys(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}

class SurveysPage_Controller extends Page_Controller {

}
?>