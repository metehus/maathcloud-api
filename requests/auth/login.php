<?php

$json = json_decode(file_get_contents('php://input'));

if(isset($json->user) && isset($json->password)){
    $sql = "SELECT * FROM `user` WHERE user = '".$json->user."'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {


            $Psql = "SELECT * FROM `user` WHERE user = '".$json->user."' AND password = '".md5($json->password)."'";
            $Presult = $conn->query($Psql);

            if ($Presult) {
                if ($Presult->num_rows > 0) {
                    while($Crow = $Presult->fetch_assoc()) {
                        $data = ['status' => 200, 'token' => md5($json->user . md5($json->password)), "user_key" => $Crow['user_key']];
                    }
                } else {
                    $data = errorMessage(809);
                }
            } else {
                $data = errorMessage(800);
            }


        } else {
            $data = errorMessage(811);
        }
    } else {
        $data = errorMessage(800);
    }
} else {
    $data = errorMessage(812);
}

?>