<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login(){
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$username,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			foreach($result->fetch_array() as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			header('Location: '.base_url.'admin/login.php');
			exit;
		}
	}
	function login_customer(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from customer_list where email = ? and `password` = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$email,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			foreach($res as $k => $v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('login_type',2);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Email or Password';
		}
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

    public function getLocationList() {
	// API endpoint URL
	$url = DASH_API . '/v1/employee/location-list';
	
  
	
	// $accessToken = $this->session->userdata('access_token');
	$accessToken = $this->settings->userdata('token');
		// print_r($accessToken); die;
			// Headers
	$headers = array(
		'Accept: application/json',
		'Authorization: Bearer ' . $accessToken
	);
  
	// Set up HTTP headers
	$header_str = implode("\r\n", $headers);
  
	// Set up stream context options
	$options = array(
		'http' => array(
			'method' => 'GET',
			'header' => $header_str
		)
	);
  
	// Create stream context
	$context = stream_context_create($options);
  
	// Send HTTP request and get response
	$response = file_get_contents($url, false, $context);
  
	$decoded_response = json_decode($response, true); // true for associative array
  
	// Return API response
	return $decoded_response['resource']['data'];
  }

	public function logout_customer(){
		if($this->settings->sess_des()){
			redirect('?');
		}
	}
	public function auth_inventory(){
		try {
			// Get parameters from the request
			$id = isset($_GET['platform_user_id']) ? $_GET['platform_user_id'] : null;
			$token = isset($_GET['token']) ? $_GET['token'] : null;
			$loc_id = isset($_GET['loc_id']) ? $_GET['loc_id'] : null;
			$role_id = isset($_GET['role_id']) ? $_GET['role_id'] : null;
			
			// Make sure we have required parameters
			if(!$id || !$token) {
				// Redirect to login page if missing required parameters
				header('Location: '.base_url.'admin/login.php');
				exit;
			}

			// Fetch employee data from roster API
			$url = 'http://roster.demo.reverely.ai//api/employee?id='.$id;
			$options = array(
				'http' => array(
					'method' => 'GET',
					'timeout' => 30
				)
			);
			$context = stream_context_create($options);
			
			$response = file_get_contents($url, false, $context);
			if($response === FALSE) {
				throw new Exception('Error fetching employee data');
			}
			
			$decoded_response1 = json_decode($response, true);
			if(!isset($decoded_response1['data']) || !isset($decoded_response1['data']['name'])) {
				throw new Exception('Invalid employee data response');
			}
			
			$username = $decoded_response1['data']['name'];

			// Set session data
			$this->settings->set_userdata('token', $token);
			$this->settings->set_userdata('loc_id', $loc_id);
			$this->settings->set_userdata('role_id', $role_id);
			$this->settings->set_userdata('username', $username);
			$this->settings->set_userdata('login_type', 1);
			$this->settings->set_userdata('type', 1);
			
			if(isset($decoded_response1['data']['image_url'])) {
				$this->settings->set_userdata('avatar1', $decoded_response1['data']['image_url']);
			}
			
			// Try to fetch locations, but continue even if it fails
			try {
				$this->getLocationData($token);
			} catch(Exception $e) {
				// Just log the error but continue
				error_log('Failed to get location data: ' . $e->getMessage());
			}
			
			// Redirect to admin dashboard
			header('Location: '.base_url.'admin/index.php');
			exit;
			
		} catch(Exception $e) {
			// Log the error
			error_log('Auth inventory error: ' . $e->getMessage());
			
			// Clear any partially set session data
			if(isset($_SESSION['userdata'])) {
				unset($_SESSION['userdata']);
			}
			
			// Redirect to login page with error
			header('Location: '.base_url.'admin/login.php?error=auth_failed');
			exit;
		}
	}

	private function getLocationData($token) {
		$url = DASH_API . '/v1/employee/location-list';
		
		$headers = array(
			'Accept: application/json',
			'Authorization: Bearer ' . $token
		);
		
		$header_str = implode("\r\n", $headers);
		$options = array(
			'http' => array(
				'method' => 'GET',
				'header' => $header_str,
				'timeout' => 30
			)
		);
		
		$context = stream_context_create($options);
		$response = file_get_contents($url, false, $context);
		
		if($response === FALSE) {
			throw new Exception('Error fetching location data');
		}
		
		$decoded_response = json_decode($response, true);
		
		if(isset($decoded_response['resource']) && isset($decoded_response['resource']['data'])) {
			$locations = $decoded_response['resource']['data'];
			$this->settings->set_userdata('locations', $locations);
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'login_customer':
		echo $auth->login_customer();
		break;
	case 'logout_customer':
		echo $auth->logout_customer();
		break;
	case 'auth_inventory':
		$auth->auth_inventory();
		break;
	default:
		echo $auth->index();
		break;
}