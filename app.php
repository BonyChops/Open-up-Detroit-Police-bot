<?php
include_once __DIR__ .'/vendor/autoload.php';
require "vendor/autoload.php";
$config = json_decode(file_get_contents(__DIR__.'/config.json'), true);

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($config['consumer_key'], $config['consumer_secret'], $config['token'], $config['token_secret']);

$connor = "開けろ！デトロイト市警だ！";
$result = mb_str_shuffle($connor);

echo $result;

$statues = $connection->post("statuses/update", ["status" => $result]);

function str_to_array($string, $encoding = 'UTF-8') {
    return array_map(
        function($index) use($string, $encoding) {
            return mb_substr($string, $index, 1, $encoding);
        },
        range(0, mb_strlen($string, $encoding) - 1)
    );
}

function mb_str_shuffle($string, $encoding = 'UTF-8') {
    $array = str_to_array($string);
    shuffle($array);
    return implode('', $array);
}
