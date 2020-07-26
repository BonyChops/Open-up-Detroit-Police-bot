<?php
include_once __DIR__ . '/vendor/autoload.php';
require "vendor/autoload.php";
$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);
$data = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
checkExist($data);

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($config['consumer_key'], $config['consumer_secret'], $config['token'], $config['token_secret']);

$connor = "開けろ！デトロイト市警だ！";
$result = mb_str_shuffle($connor, $data);
exec("ffmpeg -f concat -safe 0 -i ".__DIR__."/cache/lists.txt"." -c copy ".__DIR__."/cache/output.mp4 -y");


$media = $connection->upload('media/upload', ['media' => __DIR__.'/cache/output.mp4']);
$parameters = [
    'status' => $result,
    'media_ids' => $media->media_id_string
];
$statues = $connection->post('statuses/update', $parameters);

echo $result;

function str_to_array($string, $encoding = 'UTF-8')
{
    return array_map(
        function ($index) use ($string, $encoding) {
            return mb_substr($string, $index, 1, $encoding);
        },
        range(0, mb_strlen($string, $encoding) - 1)
    );
}

function mb_str_shuffle($string, $data, $encoding = 'UTF-8')
{
    $dir = __DIR__.'/'.$data['video_dir'];
    $array = str_to_array($string);
    var_dump($array);
    array_shuffle($array);
    var_dump($array);
    $fileLists = "";
    $fileLists = $fileLists . 'file ' .$dir.'/'.$data["op"] . "\n";
    foreach ($array as $key => $value){
        $fileLists = $fileLists . 'file ' .$dir.'/'.$data[$key] . "\n";
    };
    $fileLists = $fileLists . 'file ' .$dir.'/'.$data["ed"] . "\n";
    file_put_contents(__DIR__."/cache/lists.txt", $fileLists);
    return implode('', $array);
}

function array_shuffle(&$array) {
    $keys = array_keys($array);
    shuffle($keys);

    $res = array();
    for ($i = 0, $_l = count($keys); $i < $_l; $i++) {
        $res[$keys[$i]] = $array[$keys[$i]];
    }

    $array = $res;
    return true;
}

function checkExist($data){
    $dir = __DIR__.'/'.$data['video_dir'];
    foreach($data as $key => $value){
        if($key != 'video_dir'){
            $fname = $dir.'/'.$value;
            if(!file_exists($fname)){
                print("Error: File not exists ($fname)\n");
                exit();
            }
        }
    }
}