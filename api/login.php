<?php
// login : 登录 API
header('Content-Type:text/json;charset=utf-8');

include '../conn/conn.php';



/*
 * code 定义:
 *      200 : 登录成功
 *      401 : 用户名不符合格式要求
 *      403 : 找不到该用户
 *      501 : 无法连接数据库
 *      503 : 查询到了多于1个用户
 *      407 : 缺少请求参数
 * */
$result = array(
    'code'=> 400 ,
    'message'=> 'ok',
    'data' => array(
    )
);

if ( !empty( $_POST ) ){
    session_start();

    $uname = addslashes($_POST['uname']);
    $upw   = addslashes($_POST['upw']);


    if( $mysqli ){

        $sql = "select id , authority from user where name='$uname' and  pw = '$upw'";

        $re = $mysqli->query($sql);
        if ( $re ){

            if ( mysqli_num_rows( $re ) === 1  ){
                $result['code'] = 200;
                $row = mysqli_fetch_assoc($re);
                $_SESSION['userid'] = $row['id'];
                $_SESSION['authority'] = $row['authority'];

//                echo $_SESSION['userid'];
//                echo $_SESSION['userauthority'];
            }else{
                $result['code'] = 503;
            }
        }else{
            $result['code'] = 502;
        }

    }else{
        $result['code'] = 501;
    }

    mysqli_close($mysqli);

}else{
    $result['code'] = 407;
}

echo json_encode($result); ;

?>