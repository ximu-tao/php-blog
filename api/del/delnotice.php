<?php
//  delnotice : 删除公告 API

header('Content-Type:text/json;charset=utf-8');

include '../../conn/conn.php';

/*
 * 请求 JSON 格式
 *  {
 *      'id'         : 博客id
 *  }
 *
 * 响应 JSON 格式
 * data :
 *          {
 *              'id':0,
 *              'userid':0
 *          }
 *
 * */
$result = array(
    'code' => 200,
    'message' => 'ok',
    'data' => array(
        'id' => 0,
        'userid' => 0
    )
);
session_start();
//print_r(  $_SESSION ) ;

if (!empty($_SESSION) and !empty($_SESSION['authority'])) {
    $authority = $_SESSION['authority'];
    if (!empty($_POST) and !empty($_POST['id'])) {
        $id = addslashes($_POST['id']);

        if (($_SESSION['authority'] & 64)) {
            $sql = "delete from notice where id=$id";

            if ($mysqli) {

                $re = $mysqli->query($sql);

                if ($re) {

                    if (mysqli_affected_rows($mysqli) > 0) {
                        $result['code'] = 200;

                    } else {
                        $result['code'] = 504;
                    }

                } else {
                    $result['code'] = 502;
                }

            } else {
                $result['code'] = 501;
            }
        } else {
            $result['code'] = 406;
        }
    }else {
        $result['code'] = 407;
    }

}else{
    $result['code'] = 405;
}


$result['data']['id'] = $id;
$result['data']['userid'] = $_SESSION['userid'];

echo json_encode($result);


?>