<?php

header('Content-Type:text/json;charset=utf-8');
session_start();

$result = array(
    'code'=> 200 ,
    'message'=> 'ok',
    'data' => array(
    )
);

unset($_SESSION['userid']);
unset($_SESSION['authority']);

echo json_encode($result);
?>