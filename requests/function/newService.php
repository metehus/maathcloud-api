<?php

require('./resources/uuid.php');

$json = json_decode(file_get_contents('php://input'));

if(isset($json->user_key) && isset($json->cloud_id) && isset($json->name)){

    $Csql = "SELECT * FROM `clouds` WHERE user_key = '".$json->user_key."' AND cloud_id = '".$json->cloud_id."'";
    $Cresult = $conn->query($Csql);
    //var_dump($Cresult);
    if($Cresult){
        if($Cresult->num_rows > 0){
            while($Crow = $Cresult->fetch_assoc()) {

                if(endsWith($Crow['link'], '/')){
                    $url1 = $Crow['link'];
                } else {
                    $url1 = $Crow['link'].'/';
                }

                $url = $url1."function/newService/";
                //echo $url;

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
                curl_setopt($ch, CURLOPT_POSTFIELDS,
                "text=asdasdas");

                                                                                                                                    
                $rresult = curl_exec($ch);

                $req = json_decode($rresult);
                //var_dump($rresult);
                if(isset($req->status)){
                    if($req->status == 200){

                        $sid = $req->service_id;
                        $skey = UUID::v4();
                        $sql = "INSERT INTO services (user_key, name, status, service_id, service_key, cloud) VALUES ('".$json->user_key."', '".$json->name."', 'active', '".$sid."', '".$skey."', '".$json->cloud_id."')";

                        if ($conn->query($sql)) {
                            $data = ['status' => 200, 'service_id' => $sid];
                        } else {
                            $data = ['error' => $conn->error];
                        }
                    } else {
                        $data = errorMessage(800);
                    }
                } else {
                    $data = errorMessage(800);
                }
                
            }
        } else {
            $data = ['status' => 814, 'error' => $conn->error];
        }
    } else {
        $data = errorMessage(816);
    }

} else {
    $data = errorMessage(807);
}

?>