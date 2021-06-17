<?php
// 返回数据库中是否已有该用户名
header('Content-Type:text/json;charset=utf-8');


include '../../conn/conn.php';

/*
 * code 定义:
 *      200 : 可使用的用户名
 *      401 : 用户名不符合格式要求
 *      402 : 用户名重复
 *      403 : 找不到该用户
 *      501 : 无法连接数据库
 *
 * */
$result = array(
    'code' => 400 ,
    'message'=> 'ok',
    'data' => array(
        'name' => '',

    )
);

if ( !empty( $_POST ) ){

    $uname = addslashes($_POST['uname']);
//    $uname = 'tao';
    $result['data']['name'] = $uname;
    if(
    preg_match('/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',$uname)
    ){

        if( $mysqli ){

            $sql = "select 1 from user where name='$uname'";

            $re = $mysqli->query($sql);
            if ( $re ){

//                if ( mysqli_num_rows( $re ) === 0 ){
                if (  $re->num_rows === 0 ){
                    $result['code'] = 200;
                    $row = mysqli_fetch_assoc($re);

                }else{
                    $result['code'] = 402;
                }
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

echo json_encode($result); ;

?>
