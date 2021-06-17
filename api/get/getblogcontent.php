<?php
//  getblogcontent : 获取博客内容



header('Content-Type:text/json;charset=utf-8');

include '../../conn/conn.php';

/*
 * 请求 JSON 格式
 *  {
 *      'id'         : 公告id
 *  }
 *
 * 响应 JSON 格式
 *
 * code :
 *      200 : 获取成功
 *      501 : 无法连接数据库

 * data :
 *          {
 *              'id':1 ,
 *              'title':''  ,
 *              'content' : '',
 *              'publisher_id':'' ,
 *              'publisher_time':''
 * }
 *
 * */
$result = array(
    'code'=> 200 ,
    'message'=> 'ok',
    'data' => array(
    )
);

if (  !empty( $_POST ) and !empty( $_POST['id'] )   ){
    $id = addslashes($_POST['id']);
    $sql = "select id , title , content , publisher_id , publish_time from blog_content where id=$id";

    if( $mysqli ){
//        echo $sql;
        $re = $mysqli->query($sql);
        if ( $re ){
            $result['code'] = 200;

            $row = $re->fetch_assoc();
            $result['data'] = $row;

        }else{
            $result['code'] = 502;
        }


        mysqli_close( $mysqli );
    }else{
        $result['code'] = 501;
    }

}else{
    $result['code'] = 407;
}



echo json_encode($result);
?>
