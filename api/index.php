<?php
include 'db.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/users','getUsers');
$app->get('/users/phone/:phone_number','getUserByPhone');
$app->get('/points/phone/:phone_number','getPointsByPhone');
$app->get('/total_points/phone/:phone_number','getTotalPointsByPhone');
$app->get('/sub_totals/phone/:phone_number','getSubTotalsByPhone');
$app->post('/points', 'insertPoints');
$app->post('/updates', 'insertUpdate');
//$app->get('/points/phone/store/:phone_number/:store_id','getPointsByPhoneStore');
//$app->get('/user/email/:email','getUserByEmail');
$app->get('/updates','getUserUpdates');
$app->delete('/updates/delete/:update_id','deleteUpdate');
$app->get('/users/search/:query','getUserSearch');

$app->run();

function getUsers() {
	$sql = "SELECT email,phone,name,points,profile_pic FROM users ORDER BY user_id";
	try {
		$db = getDB();
		$stmt = $db->query($sql);  
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getUserByPhone($phone_number) {  
	//echo '{"phone": ' . json_encode($phone_number) . '}'; return;
	$sql = "SELECT email,phone,name,points,profile_pic FROM users WHERE phone=:phone_number";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("phone_number", $phone_number);
		$stmt->execute(); 
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
}

function getPointsByPhone($phone_number) {
	$sql = "SELECT B.* FROM users A, user_points B WHERE A.user_id=B.user_id AND A.phone=:phone_number";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("phone_number", $phone_number);
		$stmt->execute();		
		$user_points = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"user_points": ' . json_encode($user_points) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getTotalPointsByPhone($phone_number) {
	$sql = "SELECT SUM(B.points) as total FROM users A, user_points B WHERE A.user_id=B.user_id AND A.phone=:phone_number GROUP BY B.user_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("phone_number", $phone_number);
		$stmt->execute();		
		$user_points = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"total_points": ' . json_encode($user_points) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getSubTotalsByPhone($phone_number) {
	$sql = "SELECT B.store_id as store,  SUM(B.points) as subtotal FROM users A, user_points B WHERE A.user_id=B.user_id AND A.phone=:phone_number GROUP BY B.user_id, B.store_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("phone_number", $phone_number);
		$stmt->execute();		
		$user_points = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"total_points": ' . json_encode($user_points) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getPointsById($id) {
	$sql = "SELECT B.* FROM user_points B WHERE B.user_points_id=:id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();		
		$user_points = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"user_points": ' . json_encode($user_points) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function insertPoints() {
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	//read wait time before update
	$sql = "INSERT INTO user_points (store_id, user_id, reward_type, points) VALUES (:store_id, :user_id, :reward_type, :points)";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("store_id", $update->store_id);
		$stmt->bindParam("user_id", $update->user_id);
		$stmt->bindParam("reward_type", $update->reward_type);
		$stmt->bindParam("points", $update->points);
		$stmt->execute();
		$update->id = $db->lastInsertId();
		$db = null;
		$update_id= $update->id;
		getPointsById($update_id);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function getUserUpdates() {
	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk  ORDER BY B.update_id DESC";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql); 
		$stmt->execute();		
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getUserUpdate($update_id) {
	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk AND B.update_id=:update_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
        $stmt->bindParam("update_id", $update_id);		
		$stmt->execute();		
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function insertUpdate() {
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	$sql = "INSERT INTO updates (user_update, user_id_fk, created, ip) VALUES (:user_update, :user_id, :created, :ip)";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("user_update", $update->user_update);
		$stmt->bindParam("user_id", $update->user_id);
		$time=time();
		$stmt->bindParam("created", $time);
		$ip=$_SERVER['REMOTE_ADDR'];
		$stmt->bindParam("ip", $ip);
		$stmt->execute();
		$update->id = $db->lastInsertId();
		$db = null;
		$update_id= $update->id;
		getUserUpdate($update_id);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteUpdate($update_id) {
   
	$sql = "DELETE FROM updates WHERE update_id=:update_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("update_id", $update_id);
		$stmt->execute();
		$db = null;
		echo true;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
}

function getUserSearch($query) {
	$sql = "SELECT user_id,username,name,profile_pic FROM users WHERE UPPER(name) LIKE :query ORDER BY user_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
?>