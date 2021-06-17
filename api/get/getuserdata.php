<?php
// getuserdata : 获取用户公开资料 API
header('Content-Type:text/json;charset=utf-8');
session_start();

include '../../conn/conn.php';

/*
 * code 定义:
 *      200 : 登录成功
 *      401 : 用户名不符合格式要求
 *      403 : 找不到该用户
 *      501 : 无法连接数据库
 * */
$result = array(
    'code'=> 400 ,
    'message'=> 'ok',
    'data' => array(
    )
);

//print_r( $_SESSION );
if ( !empty( $_SESSION ) and !empty( $_SESSION['userid'] ) ) {

    $id = $_SESSION['userid'];

    if (!empty($_POST) and !empty($_POST['id'])) {
        $id = $_POST['id'];
    }

    if ($mysqli) {

        $sql = "select id , name  , authority , avatar from user where id=$id";

        $re = $mysqli->query($sql);
        if ($re) {

            if (mysqli_num_rows($re) === 1) {
                $result['code'] = 200;
                $row = mysqli_fetch_assoc($re);

                $_SESSION['userid'] = $row['id'];
                $_SESSION['authority'] = $row['authority'];

                $result['data'] = $row;

            } else {
                $result['code'] = 504;
            }
        } else {
            $result['code'] = 502;
        }

    } else {
        $result['code'] = 501;
    }

    mysqli_close($mysqli);
}else{
    $result['code'] = 405;
}


echo json_encode($result); ;

?>