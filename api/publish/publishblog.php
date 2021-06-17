<?php
// publishblog : 发布博客 API


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
 * code 定义:
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

    )
);

//print_r( $_SESSION );

if ( empty( $_SESSION ) or empty( $_SESSION['userid'] )  ){
//    检查是否已登录
    $result['code'] = 405;
}else if ( !empty( $_POST ) ){

    if ( !( $_SESSION['authority'] & 4 )   ){
        //    检查是否有发布博客的权限
        $result['code'] = 406;
    }else{

        if ( $_POST['title'] != '' ){

            $title = addslashes( $_POST['title'] ) ;
            $content   = addslashes( $_POST['content'] );
            $id   = $_SESSION['userid'];

            if( $mysqli ){

                $sql = "insert into blog_content (`title`, `content` , `publisher_id` , `publish_time`  ) values ( '$title', '$content', '$id' , NOW() )";

//                echo $sql;

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
        }else{
            $result['code'] = 407;
        }
    }
}


echo json_encode($result);
?>