class Survey extends DataObject {

    private static $db = array (
        'Title' => 'Varchar',
        'Description' => 'Text',
    );
    
    private static $has_one = array (
        'SurveysPage' => 'SurveysPage'
    );

    /*private static $has_many = array (
        'SurveyQuestions' => 'SurveyQuestion'
    );*/

    public function getCMSFields() {
        $fields = FieldList::create(
            TextField::create('Title'),
            TextareaField::create('Description'),
        );
        return $fields;
    }
}