<?php
class User {
	private $db;
	function __construct(){
        $this->db = new Database();
		
	}
	
	function create( $name, $birthdate, $email, $location){ 
		$sql = "INSERT INTO users (name, birthdate, email, location, created_at ) VALUES ( :name, DATE(:birthdate), :email, :location, NOW() ) ";
		$param = array(":name" => $name, ":birthdate" => $birthdate, ":email" => $email, ":location" => $location);
		if($lastID = $this->db->execQuery($sql, $param)){
			if(is_numeric($lastID)){
				$_SESSION['user']['userid'] = $lastID;
				return $lastID;
			}else{
				return false;
			}
		}
	}

	function update( $user_id, $email, $password, $first_name, $last_name){ 
		$sql = "UPDATE users SET email = :email, password = :password, first_name = :first_name, last_name = :last_name WHERE id = :userid LIMIT 1";
		$param = array(':email' => $email, ':password' => $password, ':first_name' => $first_name, ':last_name' => $last_name, ':userid' => $user_id);
		return $this->db->doQuery($sql, $param);
	}

	function find_by_id( $id ){
		$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
		$param = array(":id" => $id);
		foreach($this->db->doQuery($sql, $param) as $user){
			$_SESSION['user']['userid'] = $user['id'];
			return $user;
		}
	}
}
