<?php
include_once __DIR__ .'/vendor/autoload.php';
require "vendor/autoload.php";
$config = json_decode(file_get_contents(__DIR__.'/config.json'), true);

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($config['consumer_key'], $config['consumer_secret'], $config['token'], $config['token_secret']);

$connor = "開けろ！デトロイト市警だ！";
$len = mb_strlen($connor);
$sploded = array();
while($len-- > 0) { $sploded[] = mb_substr($string, $len, 1); }
shuffle($sploded);
$result = join('', $sploded);

echo $result;

$statues = $connection->post("statuses/update", ["status" => $result]);