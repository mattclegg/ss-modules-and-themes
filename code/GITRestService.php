<?php 

class  GITRestService extends RestfulService {
	
	protected $baseURL='http://github.com/api/v2/json';
	// Yes, its using v2 (for now)
	
	
	protected $authUsername=false;	
	protected $jsonUsername, $jsonPassword;
	
	function __construct($base=null,$expiry=3600){
		if(!$base)$base=$this->baseURL;
		parent::__construct($base,$expiry);
	}
	
	function set_username_password($user,$password){
		self::$jsonUsername=$user;
        self::$jsonPassword=md5($password);
	}
	
	public function request($subURL = '', $method = "POST", $data = null, $headers = null, $curlOptions = array()) {
		
		$parameters = array(
		    'user_auth' => array(
		        'user_name' => $this->jsonUsername,
		        'password' => $this->jsonPassword,
		        ),
		    );
		$json = json_encode($parameters);
		$data = array(
		    'method' => 'login',
		    'input_type' => 'JSON',
		    'response_type' => 'JSON',
		    'rest_data' => $json,
		);
		
		
		parent::request($subURL = '', "POST", $data, $headers = null, $curlOptions = array());
		
	}
	
	function get_user_info($user_email){
		
		return $this->request("user/email/{$user_email}");
		
	}
	
	function get_user_repos($user_git_user){
		
		return $this->request("repos/show/{$user_git_user}");
	}
	
	
}