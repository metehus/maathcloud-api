<?php
header('Content-Type: application/json');

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[rand(0, $max)];
    }
    return implode('', $pieces);
}

function errorMessage($number = 800){

    switch ($number) {
        case 801:
            $msg = 'Invalid get method.';
            break;

        case 802:
            $msg = 'Invalid auth method.';
            break;

        case 803:
            $msg = 'Invalid function method.';
            break;

        case 804:
            $msg = 'Invalid method.';
            break;

        case 805:
            $msg = 'This request needs a auth token.';
            break;

        case 806:
            $msg = 'invalid auth token.';
            break;
            
        case 807:
            $msg = 'Missing user key or/and cloud id or/and service name.';
            break;

        case 808:
            $msg = 'Email address not found.';
            break;

        case 809:
            $msg = 'Invalid password.';
            break;
            
        case 810:
            $msg = 'This method requires a username input.';
            break;

        case 811:
            $msg = 'Username not found.';
            break;

        case 812:
            $msg = 'Missing data.';
            break;

        case 813:
            $msg = 'Invalid username.';
            break;

        case 814:
            $msg = 'Database server error';
            break;

        case 815:
            $msg = 'Invalid user key.';
            break;

        case 816:
            $msg = 'User not found.';
            break;

        case 817:
            $msg = 'Username already taken.';
            break;

        case 818:
            $msg = 'Email already registered.';
            break;
            
        case 819:
            $msg = 'Email or username not found.';
            break;
        case 820:
            $msg = 'Missing cloud id.';
            break;
        case 821:
            $msg = 'Missing cloud secret key.';
            break;
        case 822:
            $msg = 'Cloud not found.';
            break;
        case 823:
            $msg = 'Missing service id.';
            break;
        case 824:
            $msg = 'Invalid service id.';
            break;
        case 825:
            $msg = 'Missing file.';
            break;
        case 826:
            $msg = 'Invalid cloud or service.';
            break;
            
        
        default:
            $msg = 'Server error.';
            break;
    }

    $data = ['status' => $number, 'message' => $msg];
    return $data;
}



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


?>