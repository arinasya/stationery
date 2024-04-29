<?php
session_start();
(require_once '../config.php');
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
	public function setUserRole($user_role){
		switch($user_role){
			case 'it':
				$_SESSION['user_role'] = 1;
			break;
			case 'admin':
				$_SESSION['user_role'] = 2;
			break;
			case 'guest':
				$_SESSION['user_role'] = 3;
			break;
			default:

		}
	}

	public function redirectUser(){
		switch ($_SESSION['user_role']){
			case 1:
				header('location : home.php');
				exit();
			case 2:
				header('location : home.php');
			    exit();
			case 3:
				header('location: home.php');
				exit();
			default:
		}
	}

	public function login(){
        extract($_POST);

        $qry = $this->conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password' ");

        if($qry->num_rows > 0){
            foreach($qry->fetch_array() as $k => $v){
                if(!is_numeric($k) && $k != 'password'){
                    $this->settings->set_userdata($k,$v);
                }
            }
            $this->settings->set_userdata('user_level',1);
            $this->setUserRole('it');
            $this->redirectUser();
        } else {
            return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * FROM users WHERE username = '$username' AND password = '$password' "));
        }
    }
	public function logout(){
		if($this->settings->sess_des()){
			redirect('it/login.php');
		}
	}
	function login_user(){
		extract($_POST);
		if($qry->num_rows > 0){
            foreach($qry->fetch_array() as $k => $v){
                if(!is_numeric($k) && $k != 'password'){
                    $this->settings->set_userdata($k,$v);
                }
            }
            $this->settings->set_userdata('user_level',2);
            $this->setUserRole('admin');
            $this->redirectUser();
        } else {
            return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * FROM users WHERE username = '$username' AND password = md5('$password') "));
        }
}

	
	function login_guest(){
		extract($_POST);
		if($qry->num_rows > 0){
            foreach($qry->fetch_array() as $k => $v){
                if(!is_numeric($k) && $k != 'password'){
                    $this->settings->set_userdata($k,$v);
                }
            }
            $this->settings->set_userdata('user_level',3);
            $this->setUserRole('guest');
            $this->redirectUser();
        } else {
            return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * FROM users WHERE username = '$username' AND password = md5('$password') "));
        }
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'login_user':
		echo $auth->login_user();
		break;
	case 'login_guest':
		echo $auth->login_guest();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo $auth->index();
		break;
}

echo $_SESSION['user_role'];
