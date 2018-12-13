<?php

include('/resources/mysql.php');

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}


$sql = "SELECT * FROM `files` WHERE file_id = '".$_GET['image']."'";
$result = $conn->query($sql);
//var_dump($Cresult);
if($result){
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {

            $Csql = "SELECT * FROM `clouds` WHERE cloud_id = '".$row['cloud_id']."'";
            $Cresult = $conn->query($Csql);
            //var_dump($Cresult);
            if($Cresult){
                if($Cresult->num_rows > 0){
                    while($Crow = $Cresult->fetch_assoc()) {
                        //var_dump($Crow);
                        if(endsWith($Crow['link'], '/')){
                            $url1 = $Crow['link'];
                        } else {
                            $url1 = $Crow['link'].'/';
                        }

                        $context = stream_context_create($opts);
                        header('Content-type: image/png');

                        $file = file_get_contents($url1 . '/cloud/services/' . $row['service_id'] . '/' . $row['name'], false, $context);
                        echo $file;
                    }
                }
            }

        }
    } else {
        echo 'not found';
    }
}
?>
