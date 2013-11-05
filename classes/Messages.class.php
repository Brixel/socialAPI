<?php
require_once 'User.class.php';
class Messages{
	
	function __construct(){
		$this->db = new Database();
		$this->user = new User();
	}

	function getMessages(){
		$sql = "SELECT * FROM `messages`";
		$param = array();
		$results = $this->db->doQuery($sql, $param);
		return $results;
	}

	function getMessageByID($messageID){
		$sql = "SELECT * FROM `messages` WHERE `id` = :messageID";
		$param = array("messageID" => $messageID);
		$results = $this->db->doQuery($sql, $param);
		if(empty($results)){
			return array("No results found", "No data found for this query");
		}else{
			$output = array();
			foreach ($results as $result) {
				$user = $this->user->find_by_id($result['user_id']);
				$result['user'] = $user;
				array_push($output, $result);
			}
			return $output;
		}
		
	}

	function postMessage($userid, $content, $title){
		$sql = "INSERT INTO `messages` (`user_id`, `content`, `title`, `postdate`) VALUES (:userid, :content, :title, NOW())";
		$param = array(":userid" => $userid, ":content" => $content, ":title" => $title);
		$result = $this->db->execQuery($sql, $param);
		if($result){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
}
?>