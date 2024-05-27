<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=123";
$db_connection = pg_connect($connection_string);

$key = "aboba204980sdf";

$jwt = $_COOKIE['jwt'];
$decoded_payload = jwt_decode($jwt, $key);
$user_id = $decoded_payload['user_id'];

function jwt_decode($jwt, $key) {
    list($header, $payload, $signature) = explode('.', $jwt);
    
    $header = base64url_decode($header);
    $header = json_decode($header, true);
    
    $payload = base64url_decode($payload);
    $payload = json_decode($payload, true);
    
    $signature = base64url_decode($signature);
    
    $algorithm = $header['alg'];
    // $expected_signature = hash_hmac($algorithm, "$header.$payload", $key, true);
    $expected_signature = hash_hmac($algorithm, json_encode($header) . '.' . json_encode($payload), $key, true);
  
    // if ($signature === $expected_signature) {
      return $payload;
    // } else {
    //   return false; // Подпись не соответствует ожидаемой
    // }
  }
  
  function base64url_decode($data) {
    $base64 = str_replace(array("-", "_"), array("+", "/"), $data);
    $base64 = base64_decode($base64);
    
    return $base64;
  }

if (isset($_COOKIE['jwt'])) 
{
    $oldpasswordcookie = $decoded_payload['password'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $newpasswordrep = $_POST['newpasswordrep'];
    if ($oldpassword == $oldpasswordcookie && $newpassword == $newpasswordrep)
    {
        $temppassword = pg_query($db_connection,"UPDATE users SET password = '$newpassword'  WHERE idusers = '$user_id' AND password = '$oldpassword'");
        header("Location: /PFTC_/login.html");
    }
    else 
    echo '<script>alert("вы ввели неправильный старый пароль или не повторили новый.")</script>';
    echo '<script>window.location.href = "tarifs.html"</script>';
    exit;
}