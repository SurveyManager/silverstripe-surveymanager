<?php
class SurveyUser extends DataObject {

    private static $db = array (
        'UserID' => 'Int',
        'UserEmail' => 'Varchar(254)',
        'Role' => "Enum('Admin,Surveyor','Surveyor')",
        'Access' => "Boolean"
    );

	private static $indexes = array(
		'UniqueUserSurvey' => array(
			'type' => 'unique',
			'value' => '"SurveyID,UserID"'
		),
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

    public function addMember($email) {
		$m = DataObject::get_one('Member',"Email ='".$email."'");
		if ($m->ID) {
		} else {
			$m = new Member();
			$m->Email = $email;
			$m->changePassword(sha1(time().rand(0,100000)));
			$m->write();
		}
		return $m;
	}

   	protected function onbeforeWrite() {
		parent::onBeforeWrite();
		// remove all survey orphans user
		$l=SurveyUser::get()->filter(array('SurveyID' => 0));foreach($l as $item) { $item->delete(); }

		$email=Convert::raw2sql($this->UserEmail);
		$m = DataObject::get_one('Member',"Email ='".$email."'");
		if ($m->ID) {
			$this->UserID=$m->ID;
		} else {
			$this->UserID=$this->addMember($email)->ID;
		}
	}

}
?>
