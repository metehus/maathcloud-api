<?php

$json = json_decode(file_get_contents('php://input'));

if(isset($json->user_key)){

    $sql = "SELECT * FROM `clouds` WHERE user_key = '".$json->user_key."'";
    //$sql = "SELECT * FROM clouds WHERE user_id = ".$json->user_id;
    $result = $conn->query($sql);

    if ($result) {
        if($result->num_rows > 0){

            $clouds = array();
            while($row = $result->fetch_assoc()) {
                $services = array();

                $Ssql = "SELECT * FROM `services` WHERE cloud = '".$row['cloud_id']."'";
                $Sresult = $conn->query($Ssql);

                if($Sresult->num_rows > 0){
                    while($Srow = $Sresult->fetch_assoc()) {
                        array_push($services, ['id' => $Srow['service_id'], 'name' => $Srow['name'], 'status' => $Srow['status'], 'key' => $Srow['service_key']]);
                    }
                }
                if(endsWith($row['link'], '/')){
                    $url1 = $row['link'];
                } else {
                    $url1 = $row['link'].'/';
                }

                $size = file_get_contents($url1."/get/size");

                $size = json_decode($size, true);

                $cookie = json_decode($row['cookie']);
                array_push($clouds, ["id" => $row['cloud_id'], "name" => $row['name'], "size" => intval($row['size']), "used" => $size["size"], "link" => $row['link'], "key" => $row['cloud_key'], "cookie" => $cookie, "services" => $services]);
            }
            $data = ['status' => 200, "clouds" => $clouds];
        } else {
            $data = errorMessage(816);
        }
    } else {
        $data = errorMessage(814);
    }

} else {
    $data = errorMessage(815);
}

