<?php
session_start();
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_errors', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	

	/*public function redirectUser(){
		switch ($_SESSION['user_role']){
			case 1:
				header('Location: home.php');
				exit();
			case 2:
				header('Location: home.php');
			    exit();
			case 3:
				header('Location: home.php');
				exit();
			default:
		}
	}*/
   public function login_guest(){
	extract($_POST);
   
	$qry = $this->conn->query("SELECT * FROM users WHERE username = '$username' and password = md5('$password')");
	if($qry->num_rows > 0){
		foreach($qry->fetch_array() as $k => $v){
			$this->settings->set_userdata($k,$v);
		}
		$this->settings->set_userdata('user_level',3);
		$resp['status'] = 'success';	
	} else{
		$resp['status'] = 'incorrect';
	}
	if($this->conn->error){
		$resp['status'] = 'failed';
		$resp['_error'] = $this->conn->error;
	}
	return json_encode($resp);
   }
   
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login_guest':
		echo $auth->login_guest();
		break;
	default:
		echo $auth->index();
		break;
}


