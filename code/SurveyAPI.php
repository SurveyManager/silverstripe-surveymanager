<?php
// TODO docs
class SurveyAPI extends DataObject  {
	private static $db = array (
		'token' 	=> 'Varchar(128)',
		'UserID' 	=> 'Int',
		'SurveyID' 	=> 'Int'
	);
    
    private static $indexes = array(
		'UniqueToken'	=> array(
			'type' 	=> 'unique', 
			'value' => '"token"'
		),
		'UserID' 		=> array(
			'type' 	=> 'index',
			'value' => '"UserID"'
		),
		'SurveyID' 		=> array(
			'type' 	=> 'index',
			'value' => '"SurveyID"'
		),
    );
    
    //private $token_ttl = 7*24*60*60;	// 7 days TODO
    private $survey = false;
    private $user = false;
    private $API_data = false;
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
				$check=SurveyUser::get()->filter(array('UserID' => $this->user->ID, 'Access'=>true, 'SurveyID' => $this->survey->ID))->first();
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
			$out['d']=array("tokenID"=>$this->token,"email"=>$email,"PIN"=>$pin);
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
	
	private function _APIsignCheck($data) {
		// TODO for security reason APIkey user for sign the data
		// 1. sort fields by name
		// 2. concat and hash (sha1 or old md5) it with APIkey
		// 3. compare with data['sign']
		return true;
	}
	private function _APIcheck($token) {
		if (preg_match ('/[a-zA-Z0-9]/', $token)) {
			$token=Convert::raw2sql($token);
			$this->API_data=SurveyAPI::get()->filter(array('token' => $token))->first();
			if ($this->API_data) {
				$this->survey = Survey::get()->filter(array('ID' => $this->API_data->SurveyID))->first();
				if ($this->survey) {
					$this->user = DataObject::get_one('Member',"ID ='".$this->API_data->UserID."'");
					$q=DataObject::get_by_id("SurveysPage",$this->survey->SurveysPageID);
					$this->APIkey=$q->APIkey;
					return true;
				}
			}
		} 
		return false;
	}
	
	function questionSave ($token, $data) {
		$out=$this->API_answer;
		if ($this->_APIcheck($token)) {
			if ($this->_APIsignCheck($data)) {
				if ($data['SH']!='' && $data['QH']!='' && $data['qid']>0) {
					$data['QH']=Convert::raw2sql($data['QH']);
					$tmp = SurveyResult::get()->filter(array('QuestionHash' => $data['QH']))->first();
					if ($tmp->ID>0) {
						$out['ok']=true;
						$out['d']=array("QH"=>$tmp->QuestionHash, "s"=>'ok');
					} else {
						$r = new SurveyResult();
						$r->SurveyHash=$data['SH'];
						$r->QuestionHash=$data['QH'];
						$r->QuestionID=(int)$data['qid'];
						$r->OptionID=(int)$data['oid'];
						$r->UserID=$this->API_data->UserID;
						$r->OptionText=$data['t'];
						$r->SurveyID=$this->API_data->SurveyID;
						$r->ResultTS=(int)$data['ts'];
						$id = $r->write();
						if ($id>0) {
							$out['ok']=true;
							$out['d'][]=array("QH"=>$r->QuestionHash, "s"=>'new');
						} else {
							$out['e'][]='save_error';
						}
					}
				} else {
					$out['e'][]='wrong_data';
				}
			} else {
				$out['e'][]='wrong_sign';
			}
		} else {
			$out['e'][]='access_denied';
		}
		return $this->_return($out);
	}
	
	function surveyQuestions ($token) {
		$out=$this->API_answer;
		if ($this->_APIcheck($token)) {
			$out['ok']=true;
			$out['d']=array("survey"=>array(
					"title"=>$this->survey->Title,
					"Description"=>$this->survey->Description,
					"PIN"=>$this->survey->PIN
				), "questions"=>array());
			$out['d']['APIkey']=$this->APIkey;
			$q=SurveyQuestion::get()->filter(array('SurveyID' => $this->API_data->SurveyID));
			foreach($q as $item) { 
				$q_item=array(
					"id"=>$item->ID,
					"title"=>$item->Title,
					"description"=>$item->Description,
					"type"=>$item->Type,
					"other"=>$item->Other,
					"options"=>array()
				);
				$o=QuestionOption::get()->filter(array("SurveyQuestionID" => $item->ID));
				foreach($o as $option) { 
					$q_item['options'][$option->ID]=array("id"=>$option->ID, "title"=>$option->Option);
				}
				$out['d']['questions'][$item->ID]=$q_item;
			}
		} else {
			$out['e'][]='access_denied';
		}
		return $this->_return($out);
	}
	
	private function _genToken ($limit = 64) {
		// don't remember where is it from, but tnx =)
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabsdefghigklmnopqrstuvwxyz1234567890';
		$_max=strlen($characters)-1;
		mt_srand((double)microtime()*1000000);
		$_r="";
		while ($limit>0) {
				$_r.=$characters{mt_rand(0,$_max)};
				$limit--;
		}
		return $_r;
	}
	
	private function _return ($out) {
		return $out;
	}
}
?>
