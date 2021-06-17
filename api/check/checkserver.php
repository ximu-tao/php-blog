<?php
// checkserver 检查服务器是否正常工作
header('Content-Type:text/json;charset=utf-8');


include '../../conn/conn.php';


$result = array(
    'code' => 200,
    'message' => 'ok',
    'data' => array(
        'status' => 0
    )
);


if ($mysqli) {

    $user_test_sql = "select 1 from user limit 1";
    $notice_test_sql = "select 1 from notice limit 1";
    $blog_content_test_sql = "select 1 from blog_content limit 1";

    $re = $mysqli->query($user_test_sql);
    if ( !$re) {
        $result['data']['status'] += 2;
    }

    $re = $mysqli->query($notice_test_sql);
    if ( !$re) {
        $result['data']['status'] += 4;
    }

    $re = $mysqli->query($blog_content_test_sql);
    if ( !$re) {
        $result['data']['status'] += 8;
    }

} else {
    $result['data']['status'] += 1;
}

mysqli_close($mysqli);


echo json_encode($result);;

?>
