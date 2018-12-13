<?php

// TODO

$token = 'd1bf6566ffc14b49dcc50022ea48ab83';

if(isset($_POST['token'])){
    if($_POST['token'] == $token){
        $data = ['status' => 200, 'token' => true];
    } else {
        $data = ['status' => 200, 'token' => false];
    }
} else {
    $data = errorMessage(805);
}

?>