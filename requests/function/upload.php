<?php


if(isset($_POST['cloud_key'])){
    $cloudkey = $_POST['cloud_key'];
    if(isset($_POST['service'])){
        $service = $_POST['service'];
        if(isset($_FILES['file'])){
            $file = $_FILES['file'];

            $sql = "SELECT * FROM `clouds` WHERE cloud_key = '".$cloudkey."'";
            //$sql = "SELECT * FROM clouds WHERE user_id = ".$json->user_id;
            $result = $conn->query($sql);

            if ($result) {
                if($result->num_rows > 0){
                    while($Crow = $result->fetch_assoc()) {
                        
                        if(endsWith($Crow['link'], '/')){
                            $url1 = $Crow['link'];
                        } else {
                            $url1 = $Crow['link'].'/';
                        }

                        $Ssql = "SELECT * FROM `services` WHERE service_id = '".$service."' AND cloud = '".$Crow['cloud_id']."'";
                        $Sresult = $conn->query($Ssql);

                        if ($Sresult) {
                            if($Sresult->num_rows > 0){
                                $ch = curl_init($url1.'/function/upload');
                                curl_setopt ($ch, CURLOPT_POST, 1);
                                $fields = [
                                    'file' => new \CurlFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']),
                                    'service' => $service
                                ];
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                //var_dump(json_decode($Crow['cookie']));
                                $cookiejson = json_decode($Crow['cookie']);
                                if($cookiejson->enabled == true){
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                        'Cookie: '.$cookiejson->name.'='.$cookiejson->value.'; expires=Thu, 31-Dec-37 23:55:55 GMT; path=/'
                                    ));
                                    echo 'Cookie: '.$cookiejson->name.'='.$cookiejson->value.'; expires=Thu, 31-Dec-37 23:55:55 GMT; path=/';
                                }

                                $response = curl_exec( $ch );
                                $rjson = json_decode($response);
                                

                                curl_close($ch);
                                if(isset($rjson->status)){
                                    if($rjson->status == 200){
                    
                                        
                                        $id = explode('.', $rjson->new_name);

                                        $sql = "INSERT INTO `files`(`name`, `file_id`, `original_name`, `size`, `cloud_id`, `service_id`) VALUES ('".$rjson->new_name."', '".$id[0]."', '".$rjson->original_name."', '".$rjson->size."', '".$Crow['cloud_id']."', '".$service."')";
                                        
                                        if ($conn->query($sql)) {
                                            $data = ['status' => 200, 'message' => 'Upload complete.', 'original_name' => $rjson->original_name, 'id' => $id[0], 'new_name' => $rjson->new_name, 'type' => $rjson->type, 'error' => $rjson->error, 'size' => $rjson->size];
                                        } else {
                                            $data = ['status' => 814, 'error' => $conn->error];
                                        }
                                    } else {
                                        $data = errorMessage(800);
                                    }
                                } else {
                                    $data = errorMessage(800);
                                }

                                
                            } else {
                                $data = errorMessage(824);
                            }
                        } else {
                            $data = ["status" => 814, "message" => "Database server error", 'error' => $conn->error];
                        }

                    }
                } else {
                    $data = errorMessage(822);
                }
            } else {
                $data = errorMessage(800);
            }
            
        } else {
            $data = errorMessage(825);
        }
    } else {
        $data = errorMessage(823);
    }
} else {
    $data = errorMessage(821);
}

