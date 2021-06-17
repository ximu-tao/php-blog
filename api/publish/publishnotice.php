<?php
// publishnotice : 发布公告 API


header('Content-Type:text/json;charset=utf-8');
session_start();

include '../../conn/conn.php';

/*
 *  请求 JSON 格式
 * {
 *      'title' : '',
 *      'content' : ''
 * }
 *
 * 响应 JSON 格式
 * code :
 *      200 : 发布成功
 *      405 : 未登录
 *      406 : 无权限
 *      501 : 无法连接数据库
 *
 * */
$result = array(
    'code'=> 400 ,
    'message'=> 'ok',
    'data' => array(
        'userid' => 0
    )
);
if ( empty( $_SESSION ) or empty( $_SESSION['userid'] )  ){
//    检查是否已登录
    $result['code'] = 405;
}else if ( !empty( $_POST ) ){

    if ( !( $_SESSION['authority'] & 32 )   ){
        echo $_SESSION['authority'];
        //    检查是否有发布公告的权限
        $result['code'] = 406;
    }else{

        $title = addslashes( $_POST['title'] ) ;
        $content   = addslashes( $_POST['content'] );
        $id   = $_SESSION['userid'];
        $result['data']['userid'] = $id;

        if( $mysqli ){

            $sql = "insert into notice (`title`, `content` , `publisher_id` , `publish_time` ) values ( '$title', '$content', '$id' , NOW() )";
//            echo $sql;
            $re = $mysqli->query($sql);
            if ( $re ){
                $result['code'] = 200;
            }else{
                $result['code'] = 502;
            }

        }else{
            $result['code'] = 501;
        }

        mysqli_close($mysqli);
    }
}


echo json_encode($result);
?>