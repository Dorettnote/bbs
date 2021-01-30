<?php

$redis = new Redis();

$redis->connect("redis", 6379);


$session_id_cookie_key = "session_id";

$session_id = isset($_COOKIE[$session_id_cookie_key]) ? ($_COOKIE[$session_id_cookie_key]) : null;
if ($session_id === null) {

	$session_id = bin2hex(random_bytes(25));

	setcookie($session_id_cookie_key, $session_id);
}
$redis_session_key = "session-" . $session_id; 

$session_values = $redis->exists($redis_session_key)
	    ? json_decode($redis->get($redis_session_key), true) 
	        : []; 


$count_key = "access_count";

$count = isset($session_values[$count_key]) ? $session_values[$count_key] : 0;


$count++;

$session_values[$count_key] = $count;
$redis->set($redis_session_key, json_encode($session_values));

printf("このセッションでの %d回目 のアクセスです！", $count);
?>
