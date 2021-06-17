<?php
// getbloglist : 获取博客列表 API , 可指定查询条件
header('Content-Type:text/json;charset=utf-8');

include '../../conn/conn.php';

// 每页显示的博客数量
$quantity = 10;

/*
 * 请求 JSON 格式
 *  {
 *      'find' : 要查询的标题或内容
 *      'publisher_id' : 指定发布人ID
 *      'publish_time' : 指定发布时间
 *      'page'         : 页码
 *
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
 * find     : 如果请求中有此字段
 * publisher_id  : 如果请求中有此字段
 * publish_time  : 如果请求中有此字段

 *  }
 * bloglist :
 *      [
 *          {
 *    "id": "15",
 *   "title": "...",
 *   "content": ".......",
 *   "publisher_id": "1",
 *   "name": "taoli",
 *   "publish_time": "2021-06-11 21:22:00",
 *   "avatar": null
 *          }
 *
 * ]
 *
 * */



$result = array(
    'code'=> 200 ,
    'message'=> 'ok',
    'data' => array(
        'pagenum' => 0,
        'pagesnum' => 0,
        'bloglist' => array(

        )

    )
);

$sql = "select b.id id , title ,  content , publisher_id , u.name , publish_time , u.avatar from blog_content b left join user u on u.id = b.publisher_id where 1=1 ";
$sql_len = "select count(*) `rows` from blog_content where 1=1";

$page = 1;
if ( !empty( $_POST ) ){
    if ( !empty( $_POST['find'] ) ){
        $find = addslashes( urldecode($_POST['find']) );
        $result['data']['find'] = $find;

        $s = " and ( title like '%$find%' or content like '%$find%') ";

        $sql = $sql.$s ;
        $sql_len = $sql_len.$s;

        $result['data']['find'] = $find;
    }

    if ( !empty( $_POST['publisher_id'] ) ){
        $publisher_id = addslashes($_POST['publisher_id']);
        $result['data']['publisher_id'] = $publisher_id;

        $s = " and publisher_id = '$publisher_id' " ;

        $sql = $sql.$s;
        $sql_len = $sql_len.$s;

        $result['data']['publisher_id'] = $publisher_id;
    }

    if ( !empty( $_POST['publish_time'] ) ){
        $publish_time = addslashes( $_POST['publish_time'] );
        $result['data']['publish_time'] = $publish_time;

        $s = " and TO_DAYS(publish_time) = TO_DAYS('$publish_time') ";

        $sql = $sql.$s ;
        $sql_len = $sql_len.$s ;

        $result['data']['publish_time'] = $publish_time;
    }


    if ( !empty( $_POST['page'] ) ){
        $page = addslashes($_POST['page']);
    }

//    echo "page = $page<br>";

}

$sql = $sql." order by b.id desc ";

$sql = $sql." limit ". ($page-1)*$quantity ." , $quantity " ;

$result['data']['pagenum'] = $page;


if( $mysqli ){

        $re = $mysqli->query($sql);
//        echo  $sql;
//    $result['data']['sql'] = $sql;
        if ( $re ){
            $result['code'] = 200;

            while($row = $re->fetch_assoc()) {
//                print_r( $row );
//                echo "<br/>";
            $result['data']['bloglist'][
                        count($result['data']['bloglist'])
                    ] = $row;
            }
        }else{
            $result['code'] = 502;
        }

        $re = $mysqli->query($sql_len);
//    $result['data']['sql_len'] = $sql_len;
        if ( $re ){

            $row = $re->fetch_assoc();

            $result['data']['pagesnum'] = intval($row['rows']/$quantity) + ($row['rows']%$quantity != 0) ;

        }else{
            $result['code'] = 502;
        }





}else{
    $result['code'] = 501;
}






echo json_encode($result);

?>