<?php

// TODO

$user = 'Testeuser';

if(isset($_POST['user'])){
    if(strtolower($_POST['user']) == strtolower($user)){
        $data = ['status' => 200, 'user' => false];
    } else {
        $data = ['status' => 200, 'user' => true];
    }
} else {
    $data = errorMessage(810);
}

?>