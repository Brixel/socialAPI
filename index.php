<?php
error_reporting(E_ALL || E_NOTICE);
ini_set("display_errors", true);

require_once("slim/Slim.php");
require_once("classes/Database.class.php");
require_once("classes/User.class.php");
require_once("classes/Messages.class.php");

$app = new Slim(array(
	'mode' => "development"
	));

$app->get('/', function() use ($app){
	echo "Hello world";
});


$app->get('/user/:userid', function($userid) use($app){
	$user = new User();
	$userdata = $user->find_by_id($userid);
	echo json_encode($userdata);
	
});

$app->get('/messages', function() use($app){
	$messages = new Messages();
	$messageData = $messages->getMessages();
	echo json_encode($messageData);

});

$app->get('/message/:messageid', function($messageid) use($app){
	$messages = new Messages();
	$messageData = $messages->getMessageByID($messageid);
	echo json_encode($messageData);
});

$app->post('/message/new', function() use($app){
	$message = new Messages();
	$userid = $app->request()->post('userID');
	$content = $app->request()->post('content');
	$title = $app->request()->post('title');
	// TODO: Need some decent HTTP-errors for the following conditions
	if($userid == ""){		
		echo "No userID given";
		exit();
	}elseif($content == ""){
		echo "No content set";
		exit();
	}elseif($title == ""){
		echo "No title given";
		exit();
	}
	$result = $message->postMessage($userid, $content, $title);
	echo $result;
});

$app->run();
?>