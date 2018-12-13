<?php

header('Content-Type: application/json');
$data = ['status' => 404 , 'message' => 'Invalid api request'];
echo json_encode($data);

?>