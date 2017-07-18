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
    private $API_answer = array(
							"ok"=>false,
							"d"=>array(),
							"e"=>array()
						);
    
    private function _flushTokens ($userID=false,$surveyID=false) {
		// remove old tokens
		$flush_done=false;
		if ((int)$userID>0) {
			$l=SurveyAPI::get()->filter(array('UserID' => (int)$userID));
			foreach($l as $item) { 
				$item->delete();
			}
			
			$flush_done=true;
		}
		if ((int)$surveyID>0) {
			$l=SurveyAPI::get()->filter(array('SurveyID' => (int)$surveyID));
			foreach($l as $item) { 
				$item->delete();
			}
			$flush_done=true;
		}
		
		if (!$flush_done) {
			// TODO clear old tokens by date
		}
	}

	function APIauth($email,$pin) {
		$out=$this->API_answer;
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
		$email=Convert::raw2sql($email);
		$this->survey = Survey::get()->filter(array('PIN' => $pin))->first();
		$this->user = DataObject::get_one('Member',"Email ='".$email."'");
		$create_token=false;
		if ($this->survey) {
			// Survey exists
			if ($this->survey->Type=='user' && $this->user) {
				// Survey restricted to users and some user exist
				$check=SurveyUser::get()->filter(array('UserID' => $this->user->ID, 'SurveyID' => $this->survey->ID))->first();
				if ($check) { 
					// user in SurveyUsers list
					$create_token=true; 
				} else {
					// oops... not in list
					$out['e'][]='survey_access_denied';
				}
			} else if ($this->survey->Type=='all' && $this->user) {
				// Survey for everyone and user exists
				$check=SurveyUser::get()->filter(array('UserID' => $this->user->ID, 'SurveyID' => $this->survey->ID))->first();
				if ($check) {
					// user in SurveyUsers list
					$create_token=true; 
				} else {
					// add user to SurvetUsers list
					if ($this->_addUserToSurvey($email)) {
						// Success =)
						$create_token=true; 
					} else {
						$out['e'][]='surveyor_create_error';
					}
				}
			} else if ($this->survey->Type=='all') {
				// Survey for all, but this user does not exists
				$this->user = new SurveyUser();
				$this->user = $this->user->addMember($email);
				$this->user = DataObject::get_one('Member',"Email ='".$email."'");
				if ($this->user) {
					// add user to SurvetUsers list
					if ($this->_addUserToSurvey($email)) {
						$create_token=true; 
					} else {
						$out['e'][]='surveyor_create_error';
					}					
				} else {
					$out['e'][]='member_create_error';
				}
			} else {
				$out['e'][]='access_denied';
			}
		} else {
			$out['e'][]='survey_does_not_exists';
		}
		if ($create_token) {
			$this->_flushTokens($this->user->ID);
			$this->token=$this->_genToken();
			$this->UserID=$this->user->ID;
			$this->SurveyID=$this->survey->ID;
			$this->write();
			$out['ok']=true;
			$out['d']=array("tokenID"=>$this->token);
		}
		return $this->_return($out);
	}
	private function _addUserToSurvey($email) {
		$u = new SurveyUser();
		$u->SurveyID=$this->survey->ID;
		$u->UserEmail=$email;
		$u->Role='Surveyor';
		$u->Access=true;
		$u->write();
		return $u->ID;
	}
	function APIcheck($token) {
		// TODO for security reason it's better to sign data using key/salt
		
	}
	
	private function _genToken ($limit = 64) {
		// alsmost http://guruquest.net/question/how-to-generate-random-unique-ids-like-youtube-or-tinyurl-in-php/
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabsdefghigklmnopqrstuvwxyz1234567890';
			$characters_length=strlen($characters)-1;
		$randstring = '';
		for ($i = 0; $i < $limit; $i++) {
			$randstring .= $characters[rand(0, $characters_length)];
		}
		return $randstring;
	}
	
	private function _return ($out) {
		return $out;
	}
}
?>
