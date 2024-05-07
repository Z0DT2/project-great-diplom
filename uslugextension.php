<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);

$uslugid = $_POST['uslugid'];
// Получаем значение из элемента input
$extensionnum = $_POST['numofmonths'];
$key = "aboba204980sdf";

if (isset($_COOKIE['jwt'])) 
{
    $jwt = $_COOKIE['jwt'];
    $decoded_payload = jwt_decode($jwt, $key);
    $user_id = $decoded_payload['user_id'];
    $idcheck = pg_query($db_connection,"SELECT count(*) AS rows FROM taruch WHERE id = '$uslugid' and idusers = '$user_id'");
    $idresult = pg_fetch_assoc($idcheck);
    if ($idresult['rows']==1)    
    {
        $extension = pg_query($db_connection,"UPDATE taruch set extension = '$extensionnum' where id = '$uslugid' and idusers = '$user_id'");
    }
    else 
    echo '<script>alert("вы ввели неверный id услуги.")</script>';
    echo '<script>window.location.href = "personal area.html"</script>';
    exit;
}

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