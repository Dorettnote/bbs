<?php

$redis = new Redis();
$redis->connect("redis", 6379);
$session_id_cookie_key = "session_id";
$session_id = isset($_COOKIE[$session_id_cookie_key]) ? ($_COOKIE[$session_id_cookie_key]) : null;
if ($session_id === null) {
	    $session_id = bin2hex(random_bytes(25));
	        setcookie($session_id_cookie_key, $session_id, 0, '/');
}
$redis_session_key = "session-" . $session_id; 
$session_values = $redis->exists($redis_session_key)
	    ? json_decode($redis->get($redis_session_key), true)
	        : []; 
$dbh = new PDO('mysql:host=mysql;dbname=2020techc_db', '2020techc_username', '2020techc_password');
$select_sth = $dbh->prepare('SELECT id, login_id, password FROM users WHERE id = :id LIMIT 1');
$select_sth->execute([
	    ':id' => $session_values["login_user_id"],
    ]);
$login_user = $select_sth->fetch();
?>

<html>
<head>
  <title>ログイン 完了</title>
</head>
<body>
  <h1>ログイン 完了</h1>
  <p>
    ログインid: <?= htmlspecialchars($_COOKIE["login_id"]) ?> でログインできました。<br>
    <a href="/bbs/read.php">掲示板へ</a>
  </p>
</body>
