<?php

$json = json_decode(file_get_contents('php://input'));


if(isset($json->user_key)){
    if(isset($json->cloud_id)){
        if(isset($json->service_id)){
        $sql = "SELECT * FROM `clouds` WHERE user_key = '".$json->user_key."'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {


                $Fsql = "SELECT * FROM `files` WHERE service_id = '".$json->service_id."' AND cloud_id = '".$json->cloud_id."'";
                $Fresult = $conn->query($Fsql);

                if ($Fresult) {
                    if ($Fresult->num_rows > 0) {

                        while($Crow = $result->fetch_assoc()) {
                            $urlr = $Crow['link'];
                            if(endsWith($urlr, '/')){
                                $url = $urlr;
                            } else {
                                $url = $urlr.'/';
                            }

                            $urlr = $Crow['link'];
                            if (endsWith($urlr, '/')) {
                                $url = $urlr;
                            } else {
                                $url = $urlr . '/';
                            }

                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_URL, $url."get/files");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"service_folder\":\"".$json->service_id."\"}");
                            curl_setopt($ch, CURLOPT_POST, 1);

                            $headers = array();
                            $headers[] = "Content-Type: application/json";
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                            $filesWEB = json_decode(curl_exec($ch), true);
                            if (curl_errno($ch)) {
                                $data = errorMessage();
                            }
                            curl_close ($ch);



                            $files = array();
                            while($row = $Fresult->fetch_assoc()) {
                                $filetype = $filesWEB[array_search($row['file_id'], array_column($filesWEB, 'id'))]['mime'];

                                array_push($files, ["name" => $row['name'], "file_id" => $row['file_id'], "original_name" => $row['original_name'], "type" => $filetype, "size" => intval($row['size'])]);
                            }
                            $data = ["files" => $files];


                        }


                    } else {
                        $data = errorMessage(826);
                    }
                } else {
                    $data = errorMessage(814);
                }


            } else {
                $data = errorMessage(822);
            }
        } else {
            $data = errorMessage(814);
        }
            
        } else {
            $data = errorMessage(823);
        }
    } else {
        $data = errorMessage(820);
    }
} else {
    $data = errorMessage(815);
}






