<?php
// signup : 账号注册 API
header('Content-Type:text/json;charset=utf-8');

include '../conn/conn.php';

/*
 * 响应 JSON 格式
 *
 * code :
 *      200 : 注册成功
 *      401 : 用户名不符合格式要求
 *      402 : 用户名重复
 *      501 : 无法连接数据库
 *      502 : 无法插入数据库
 *
 * */
$result = array(
    'code' => 400,
    'message'=> 'ok',
    'data' => array(

    )
);

if ( !empty( $_POST ) ){
    $uname = addslashes($_POST['uname']);
    $upw   = addslashes($_POST['upw']);
    $avatar   = addslashes($_POST['avatar']);

    if(
        preg_match('/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',$uname)
    ) {

        if( $mysqli ){

            $sql = "insert into user (`name`, `pw` , `avatar`) values ('$uname', '$upw' , '$avatar')";
//            echo $sql;
            $re = $mysqli->query($sql);
            if ( $re ){
                $result['code'] = 200;

                session_start();

                $sql = "select id , authority from user where name='$uname' and  pw = '$upw'";

                $re = $mysqli->query($sql);

                $row = mysqli_fetch_assoc($re);
                $_SESSION['userid'] = $row['id'];
                $_SESSION['authority'] = $row['authority'];

            }else{
                $result['code'] = 502;
            }

        }else{
            $result['code'] = 501;
        }

        mysqli_close($mysqli);
    }else{
        $result['code'] = 401;
    }
}

echo json_encode($result);

//session_start();

?>