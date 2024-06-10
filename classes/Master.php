<?php
session_start();
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
	 global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			
		}
	}
	function save_vendor(){
		extract($_POST);
		$data = "";
		$save= null;
		$sql = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM vendors where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Vendor already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `vendors` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `vendors` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Vendor successfully saved.");
			else
				$this->settings->set_flashdata('success',"Vendor successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_vendor(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `vendors` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Vendor successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	
	function save_item(){
		$save = null;
		$sql = "";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `items` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Item already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `items` set {$data} ";
			$save = $this->conn->query($sql);
			$id= $this->conn->insert_id;
		}else{
			$sql = "UPDATE `items` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$upload_path = "uploads/product_".$id;
			if(!is_dir(base_app.$upload_path))
				mkdir(base_app.$upload_path);
			if(isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0){
				foreach($_FILES['img']['tmp_name'] as $k => $v){
					if(!empty($_FILES['img']['tmp_name'][$k])){
						move_uploaded_file($_FILES['img']['tmp_name'][$k],base_app.$upload_path.'/'.$_FILES['img']['name'][$k]);
					}
				}
			}
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Item successfully saved.");
			else
				$this->settings->set_flashdata('success',"Item successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_item(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `items` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Item successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_group(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `user_groups` where `id` = '{$id}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Group already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `user_groups` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `user_groups` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New group successfully saved.");
			else
				$this->settings->set_flashdata('success',"Group successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_group(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `user_groups` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Group successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
 
	}
     function save_users(){
		$save = null;
		$sql = "";
		extract($_POST);
		//Validate password
		$password_pattern= '/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=])[a-zA-Z0-9!@#$%^&*()-_+=]{8,}$/';
		if (!preg_match($password_pattern, $password)) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Password must contain at least 1 symbol, 1 number, 1 uppercase letter, and be at least 8 characters long.';
			return json_encode($resp);
		}
		//hash password
		$_POST['password']= md5($password);

		$data ="";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){
				if(!empty($data)) $data .= ",";
				$data .= "{$k}= '{$v}'";
			}
		}
		//Insert or update data
		if(empty($id)){
			$sql = "INSERT INTO users SET {$data}";
			$save = $this->conn->query($sql);
		}
		else{
			$sql = "UPDATE `users` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		//check if the operation was successful
	    if($save){
			$resp['status'] = 'success';
			if(empty($id))
			   $this->settings->set_flashdata('success','Account successfully created.');
			else
			   $this->settings->set_flashdata('success','Account successfully updated.');
			foreach($_POST as $k => $v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('id',$id);
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	 }
	 function delete_user(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `users` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"User successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
 
	}
	function add_to_cart(){
		// Extracting user_id from session settings
		$user_id = $this->settings->userdata('id');
		
		// Sanitize price input
		$_POST['price'] = str_replace(",", "", $_POST['price']);
	
		// Prepare data for insertion
		$data = [];
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){
				$data[$k] = $this->conn->real_escape_string($v);
			}
		}
		$data['user_id'] = $user_id;
	
		// Prepare the check query
		$item_id = $this->conn->real_escape_string($_POST['item_id']);
		$check_query = "SELECT * FROM `cart` WHERE `item_id` = '{$item_id}' AND `user_id` = '{$user_id}'";
		$check = $this->conn->query($check_query)->num_rows;
	
		// Check for any errors
		if($this->capture_err()) {
			error_log("Error: " . $this->capture_err());
			return $this->capture_err();
		}
	
		// Determine if we need to update or insert
		if($check > 0){
			$quantity = intval($_POST['quantity']);
			$sql = "UPDATE `cart` SET `quantity` = `quantity` + ? WHERE `item_id` = ? AND `user_id` = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("iss", $quantity, $item_id, $user_id);
		} else {
			$columns = implode(", ", array_keys($data));
			$placeholders = implode(", ", array_fill(0, count($data), "?"));
			$sql = "INSERT INTO `cart` ($columns) VALUES ($placeholders)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));
		}
	
		// Execute the query
		$save = $stmt->execute();
	
		// Check for any errors
		if($this->capture_err()) {
			error_log("Error: " . $this->capture_err());
			return $this->capture_err();
		}
	
		// Prepare the response
		if($save){
			$cart_count_query = "SELECT SUM(`quantity`) AS item FROM `cart` WHERE `user_id` = '{$user_id}'";
			$cart_count_result = $this->conn->query($cart_count_query)->fetch_assoc()['item'];
			$resp['status'] = 'success';
			$resp['cart_count'] = $cart_count_result;
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]"; 
			error_log("SQL Error: " . $resp['err']);
		}
	
		return json_encode($resp);
	}
	
	function update_cart_qty(){
		extract($_POST);
		
		$save = $this->conn->query("UPDATE `cart` set quantity = '{$quantity}' where id = '{$id}'");
		if($this->capture_err())
			return $this->capture_err();
		if($save){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
		
	}
	function empty_cart(){
		$sql = "";
		$delete = $this->conn->query("DELETE FROM `cart` where user_id = ".$this->settings->userdata('id'));
		if($this->capture_err())
			return $this->capture_err();
		if($delete){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_cart(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `cart` where id = '{$id}'");
		if($this->capture_err())
			return $this->capture_err();
		if($delete){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_order(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `orders` where id = '{$id}'");
		$delete2 = $this->conn->query("DELETE FROM `order_list` where order_id = '{$id}'");
		$delete3 = $this->conn->query("DELETE FROM `sales` where order_id = '{$id}'");
		if($this->capture_err())
			return $this->capture_err();
		if($delete){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Order successfully deleted");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function place_order() {
		extract($_POST);
		$user_id = $this->settings->userdata('id');
	
		// Ensure request is set and has a valid value
		if (!isset($request) || $request === null) {
			$request = ''; // or set to a default value that is acceptable
		}
	
		// Start a transaction
		$this->conn->begin_transaction();
		try {
			// Prepare data for order_list table and calculate total amount
			$cart = $this->conn->query("SELECT c.*, i.name, i.price, i.id as item_id FROM `cart` c INNER JOIN `items` i ON i.id = c.item_id WHERE c.user_id = '{$user_id}' ");
			if ($cart === false) {
				throw new Exception("Query to fetch cart items failed: " . $this->conn->error);
			}
	
			$total_amount = 0; // Initialize total amount
			while ($row = $cart->fetch_assoc()) {
				$total = $row['price'] * $row['quantity'];
				$total_amount += $total; // Accumulate total amount
			}
	
			// Insert into orders table
			$stmt = $this->conn->prepare("INSERT INTO `orders` (user_id, total_amount, confirm, request, department) VALUES (?, ?, ?, ?, ?)");
			if ($stmt === false) {
				throw new Exception("Prepare statement for orders table failed: " . $this->conn->error);
			}
	
			$stmt->bind_param("idiss", $user_id, $total_amount, $confirm, $request, $department);
			if (!$stmt->execute()) {
				throw new Exception("Execute statement for orders table failed: " . $stmt->error);
			}
			$order_id = $stmt->insert_id;
	
			// Insert into order_list table
			$stmt = $this->conn->prepare("INSERT INTO `order_list` (order_id, item_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
			if ($stmt === false) {
				throw new Exception("Prepare statement for order_list table failed: " . $this->conn->error);
			}
	
			$cart->data_seek(0); // Reset pointer to the beginning
			while ($row = $cart->fetch_assoc()) {
				$total = $row['price'] * $row['quantity'];
				$stmt->bind_param("iiidd", $order_id, $row['item_id'], $row['quantity'], $row['price'], $total);
				if (!$stmt->execute()) {
					throw new Exception("Execute statement for order_list table failed: " . $stmt->error);
				}
			}
	
			// Clear the cart
			$delete_cart = $this->conn->query("DELETE FROM `cart` WHERE user_id = '{$user_id}'");
			if ($delete_cart === false) {
				throw new Exception("Delete from cart table failed: " . $this->conn->error);
			}
	
			// Insert into sales table
			$stmt = $this->conn->prepare("INSERT INTO `sales` (order_id, total_amount) VALUES (?, ?)");
			if ($stmt === false) {
				throw new Exception("Prepare statement for sales table failed: " . $this->conn->error);
			}
	
			$stmt->bind_param("id", $order_id, $total_amount);
			if (!$stmt->execute()) {
				throw new Exception("Execute statement for sales table failed: " . $stmt->error);
			}
	
			// Commit the transaction
			$this->conn->commit();
	
			// Return success response
			$resp['status'] = 'success';
		} catch (Exception $e) {
			// Rollback the transaction on error
			$this->conn->rollback();
			$resp['status'] = 'failed';
			$resp['err_sql'] = $e->getMessage() . " - " . $this->conn->error; // Return the exception and the SQL error message
		}
	
		return json_encode($resp);
	}
	
	
	
	
	
	
	function update_order_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` SET `status` = '$status' WHERE id = '{$id}' ");
		if($update){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Order status successfully updated.");

		}else{
			$resp['status'] = 'success';
			$resp['err'] =$this->conn->error;
		}
		return json_encode($resp);
	}
	 function confirm() {
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` SET `confirm` = '1' WHERE id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Order request status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		// Add debugging output
		$resp['query'] = "UPDATE `orders` SET `confirm` = '1' WHERE id = '{$id}' ";
		$resp['update_result'] = $update;
		return json_encode($resp);
	}
	
}
	


$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_vendor':
		echo $Master->save_vendor();
	break;
	case 'delete_vendor':
		echo $Master->delete_vendor();
	break;
	case 'save_item':
		echo $Master->save_item();
	break;
	case 'delete_item':
		echo $Master->delete_item();
	break;
	
	case 'save_group':
		echo $Master->save_group();
	break;
	case 'delete_group':
		echo $Master->delete_group();
	break;
	case 'save_users':
		echo $Master->save_users();
	break;
	case 'delete_user':
		echo $Master->delete_user();
	break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
	break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
	break;
	case 'delete_cart':
		echo $Master->delete_cart();
	break;
	case 'empty_cart':
		echo $Master->empty_cart();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'place_order':
		echo $Master->place_order();
	break;
	case 'update_order_status':
		echo $Master->update_order_status();
	break;
	case 'confirm':
		echo $Master->confirm();
	break;
	
	case 'delete_order':
		echo $Master->delete_order();
	break;
	default:
		// echo $sysset->index();
		break;
}