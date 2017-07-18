<?php
class SurveyAPI extends DataObject  {
	private static $db = array (
        'token' => 'Varchar(128)',
        'UserID' => 'Int',
        'SurveyID' => 'Int'
    );
    
    private static $indexes = array(
        'UniqueToken' => array(
            'type' => 'unique', 
            'value' => '"token"'
        ),
        'UserID' => array(
			'type' => 'index',
			'value' => '"UserID"'
        ),
        'SurveyID' => array(
			'type' => 'index',
			'value' => '"SurveyID"'
        ),
    );
    
    private $survey = false;
    private $user = false;
    
    private function flushTockens () {
		// TODO remove old tokens
	}

	function APIauth($email,$pin) {
		/*
			1.      check is PIN connect to one of the Survey
			2.      check is user exists
			2.1.    if user exists:
			2.1.1.  if Survey.type is 'user' - check user connected to this survey
			2.1.2.  if Survey.type is 'all' - add user to survey
			2.2.    if user does not exists
			2.2.1.  if Survey.type is 'user' - error
			2.2.2.  if Survey.type is 'add' - create user and add it to survey
			.... later
		*/
		$pin=Convert::raw2sql($pin);
		$this->survey = Survey::get()->filter(array('PIN' => $pin))->first();
		var_dump($email,$pin,$this->survey);
		
	}
	
	function APIcheck($token) {
		
	}
}
?>
