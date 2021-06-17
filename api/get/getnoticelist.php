<?php
//   getnoticelist : 获取公告列表 API
header('Content-Type:text/json;charset=utf-8');

include '../../conn/conn.php';

/*
 * 请求 JSON 格式
 *  {
 *      'page'         : 页码
 *  }
 *
 * 响应 JSON 格式
 *
 * code :
 *      200 : 获取成功
 *      501 : 无法连接数据库
 *
 * pagenum  :  分页当前页码
 * pagesnum : 分页总页数
 *
 * noticelist :
 *      [
 *          { 'id':1 , 'title':''  , 'publisher_id':'' , 'publisher_time':'' }
 *          { 'id':2 , 'title':''  , 'publisher_id':'' , 'publisher_time':'' }
 *          { 'id':3 , 'title':''  , 'publisher_id':'' , 'publisher_time':'' }
 *      ]
 *
 * */
$result = array(
    'code'=> 200 ,
    'message'=> 'ok',
    'data' => array(
        'pagenum' => 0,
        'pagesnum' => 0,
        'noticelist' => array(

        )

    )
);

$sql = "select id , title , content , publisher_id , publish_time from notice order by id desc ";
$sql_len = "select count(*) `rows` from notice";

$page = 1;
if ( !empty( $_POST ) ){
    if ( !empty( $_POST['page'] ) ){
        $page = addslashes($_POST['page']);
    }
//    echo "page = $page<br>";
}

$sql = $sql." limit ". ($page-1)*5 ." , 5 " ;
//echo $sql;
$result['data']['pagenum'] = $page;

if( $mysqli ){

        $re = $mysqli->query($sql);
        if ( $re ){
            $result['code'] = 200;

            while($row = $re->fetch_assoc()) {
            $result['data']['noticelist'][
                        count($result['data']['noticelist'])
                    ] = $row;
            }
        }else{
            $result['code'] = 502;
        }

//        获取行数
        $re = $mysqli->query($sql_len);
        if ( $re ){

            $row = $re->fetch_assoc();

            $result['data']['pagesnum'] = intval($row['rows']/5) + ($row['rows']%5 != 0) ;

        }else{
            $result['code'] = 502;
        }





}else{
    $result['code'] = 501;
}






echo json_encode($result);
?>

