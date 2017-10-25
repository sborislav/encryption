<?php
$start_time = microtime(true);
register_shutdown_function('my_shutdown');
function my_shutdown()
{
    global $start_time;
    echo "Затраченное время: ".(microtime(true) - $start_time)." Секунд.";
}

include "coder/core.php";
include "coder/plugin.php";
include "coder/server.php";

use coder\plugin;
use coder\server;

$plugin = new plugin();

$plugin->licenceCheck(['124.65.87.12', '04-7D-7B-97-0C-9F', 'windows10']);

$web = $plugin->request();
echo "Данные передаются по открытому каналу \"web\"(переменная)<br>";
echo "Сообщение закодировано ключом KEY: $web <br>";

/*
 * Перехват сообщения
 */
//include 'coder/hacker.php';

// $hacker = new \coder\hacker();
// Перебор числового ключа
// $key =  $hacker->load($web,100000 ,true);



// Перебор символьного ключа
// $key =  $hacker->load($web,3 ,false) .'<br>';
// echo $key .'<br>';
// exit;
/*
 * Конец перехвата сообщения
 */

$server = new server();
$web = $server->request($web);
echo "Сообщение закодировано ключом KEY + KEY2: $web <br>";

$web = $plugin->response($web);
echo "Сообщение закодировано только ключом KEY2:  $web <br>";

$web = $server->request($web);
echo "Сообщение раскодировано web-приложением, ответ от сервера закодирован ключом KEY2.1:  $web <br>";

$web = $plugin->response($web);
echo "Сообщение закодировано ключом KEY2.1 + KEY:  $web <br>";

$web = $server->request($web);
echo "Сообщение закодировано только ключом KEY:  $web <br>";

$code = $plugin->response($web);
echo "Сообщение раскодировано:  $code <br>";

echo $plugin->finish($code).'<br>';
