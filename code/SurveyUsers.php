<?php
class SurveyUser extends DataObject {

    private static $db = array (
        'UserID' => 'Int',
        'UserEmail' => 'Varchar(254)',
        'Role' => "Enum('Admin,Surveyor','Surveyor')",
        'Access' => "Boolean"
    );

    private static $has_one = array (
        'Survey' => 'Survey'
    );
    
    private static $summary_fields = array(
		"UserEmail", "Role", "Access"
	);


    public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', ReadonlyField::create('UserID'),'Content');
        return $fields;
    }
    
   	protected function onbeforeWrite() {
		parent::onBeforeWrite();
		$emailAddress=Convert::raw2sql($this->UserEmail);
		$m = DataObject::get_one('Member',"Email ='".$emailAddress."'");
		if ($m->ID) {
			$this->UserID=$m->ID;
		} else {
			$m = new Member();
			$m->Email = $emailAddress;
			$m->changePassword(sha1(time().rand(0,100000)));
			$m->write();
			$this->UserID=$m->ID;
		}
	}

}
?>
