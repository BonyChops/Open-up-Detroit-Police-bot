<?php
include_once __DIR__ .'/vendor/autoload.php';
require "vendor/autoload.php";
$config = json_decode(file_get_contents(__DIR__.'/config.json'), true);

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($config['consumer_key'], $config['consumer_secret'], $config['token'], $config['token_secret']);

$connor = "開けろ！デトロイト市警だ！";
$result = str_shuffle($connor);

$statues = $connection->post("statuses/update", ["status" => $result]);