<?php
session_start();
error_reporting(E_ALL || E_NOTICE);
ini_set("display_errors", true);

require_once("slim/Slim.php");
require_once("slim/Http/Response.php");
require_once("classes/Database.class.php");
require_once("classes/User.class.php");
require_once("classes/Messages.class.php");

/*
Defining variables and constants
*/
CONST MESSAGE_POST_SUCCESS = "S200";
CONST MESSAGE_POST_FAILURE = "S500";
CONST POST_MISSING_CONTENT = "S501";
CONST POST_MISSING_TITLE = "S502";
CONST POST_MISSING_USERID = "S503";

$app = new \Slim(array(
    'mode' => 'development',
    'debug' => true,
));


#$res = new \Slim\Http\Response();

$app->get('/', function() use ($app){
	echo "Hello world";
});


$app->get('/user/:userid', function($userid) use($app){
	$user = new User();
	$userdata = $user->find_by_id($userid);
	echo json_encode($userdata);
	
});

$app->get('/messages/', function() use($app){
	$messages = new Messages();
	$messageData = $messages->getMessages();
	echo json_encode($messageData);

});

$app->get('/message/', function() use ($app){
	echo json_encode(array("Missing parameter", "Please give a ID-parameter (NUMBER)"));
});

$app->get('/message/:messageid', function($messageid) use($app){
	$messages = new Messages();
	if(!is_numeric($messageid)){
		$app->response()->status(501);
	};
	$messageData = $messages->getMessageByID($messageid);
	echo json_encode($messageData);
});

$app->post('/message/new', function() use($app){
	$message = new Messages();
	$user = new User();
	$userid = $app->request()->post('userID');
	$content = $app->request()->post('content');
	$title = $app->request()->post('title');
	// TODO: Need some decent HTTP-errors for the following conditions
	if($userid == ""){		
		echo json_encode(POST_MISSING_USERID);
		exit();
	}elseif($content == ""){
		echo json_encode(POST_MISSING_CONTENT);
		exit();
	}elseif($title == ""){
		echo json_encode(POST_MISSING_TITLE);
		exit();
	}
	$result = $message->postMessage($userid, $content, $title);
	if($result){
		$app->response()->status(200);
		echo json_encode(array("meta" => MESSAGE_POST_SUCCESS, "messageBody" => array("user" => $user->find_by_id($userid), "title" => $title, "message" => $content)));
	}else{
		$app->response()->status(500);
		echo json_encode(MESSAGE_POST_FAILURE);
	}

	
});

$app->run();
?>