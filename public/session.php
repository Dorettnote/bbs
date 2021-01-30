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

$session_values["username"] = "muto";
$redis->set($redis_session_key, json_encode($session_values));


$result = $session_values["username"]; 

