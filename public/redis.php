$redis = new Redis();



$redis->connect("redis",6379);


$redis->set("key1","value1");


$redis = $redis->get("key1");


$redis->del("key1");
