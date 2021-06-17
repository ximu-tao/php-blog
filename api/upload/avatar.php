<?php
// avatar : 上传头像 API

$result = array(
    'code'=> 400 ,
    'message'=> 'ok',
    'data' => array(
        'newname' => ''
    )
);

if ( !empty( $_FILES['avatar'] ) ){
    $avatarinfo = $_FILES['avatar'];
    if ($avatarinfo["error"] == 0) {


        $typeArr = explode("/", $avatarinfo["type"]);
        if($typeArr[0]== "image") {

            if (0 < $avatarinfo['size'] && $avatarinfo['size'] < 1000000) {
                $newname = $avatarinfo['name'].time();

//                echo $avatarinfo['tmp_name'] , "<br>";
//                echo file_exists( $avatarinfo['tmp_name'] ) , "<br>";

//                print_r( opendir('../../'));
//                echo realpath( '../../upload/avatar/' ) , "<br>";


                if ( move_uploaded_file(
                    $avatarinfo['tmp_name'],
                    '../../upload/avatar/'.$newname
                ) ){
                    $result['code'] = 200;
                    $result['data']['newname'] = $newname;
                }else{

                    $result['code'] = 409;
                }

                $result['data']['newname'] = $newname;
            } else {
                $result['code'] = 408;
            }
        }else {
            $result['code'] = 410;
        }

    }else {
        $result['code'] = 409;

    }

}else {
    $result['code'] = 407;
}

echo json_encode($result);
?>