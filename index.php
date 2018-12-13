<?php
header('Access-Control-Allow-Origin: *');
include('/resources/headers.php');
include('/resources/mysql.php');

if(isset($_GET['request']) && isset($_GET['method'])){
    $request = $_GET['request'];
    $method = $_GET['method'];
} else {
    $request = '';
    $method = '';
}


if ($conn->connect_error) {
    $data = errorMessage(814);
} else {

    if($request == 'get'){
        if($method == 'clouds' || $method == 'cloud' || $method == 'services' || $method == 'image' || $method == 'files'){
            include('/requests/'.$request.'/'.$method.'.php');
        } else {
            $data = errorMessage(801);
        }
    } elseif($request == 'auth'){
        if($method == 'login' || $method == 'register' || $method == 'token' || $method == 'user' || $method == 'passwordRecovery' || $method == 'email'){
            include('/requests/'.$request.'/'.$method.'.php');
        } else {
            $data = errorMessage(802);
        }
    } elseif($request == 'function'){
        if($method == 'post' || $method == 'like' || $method == 'newService' || $method == 'upload'){
            include('/requests/'.$request.'/'.$method.'.php');
        } else {
            $data = errorMessage(803);
        }
    } else {
        $data = errorMessage(804);
    }
}

echo json_encode($data);
$conn->close();
?>