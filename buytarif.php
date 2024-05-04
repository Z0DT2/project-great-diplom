<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);
date_default_timezone_set('UTC');

$adress = $_POST['adress'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$date = date("Y-m-d");
$expiredate = date("Y-m-d", strtotime($date . " +30 days"));
$type_id = $_POST['id_type'];
$key = "aboba204980sdf";

if (isset($_COOKIE['jwt'])) 

{
    $jwt = $_COOKIE['jwt'];
    // // Декодирование JWT токена
    // $jwt = base64_decode($jwt);
    // $jwt = hash_hmac('sha256', $jwt, 'my_secret_key', true);
    // $jwt = base64_decode($jwt);

    // // Разбор данных из JWT токена
    // $payload = json_decode($jwt, true);

    // echo 'User ID: ' . $payload['user_id'];
    // echo 'Email: ' . $payload['email'];

    $decoded_payload = jwt_decode($jwt, $key);
    $user_id = $decoded_payload['user_id'];
    // JWT декодирован успешно
    // Используйте $decoded_payload для дальнейших операций

    // $emailcook = $_COOKIE['email'];
    // $passcook = $_COOKIE['password'];
    // $namecook = $_COOKIE['name'];
    // $user_id_query = pg_query($db_connection,"SELECT * FROM users WHERE  email = '$emailcook'");
    //echo $user_id;

    $cost_query = pg_query($db_connection,"SELECT costs FROM tariffs WHERE id = '$type_id'");
    $cost_result = pg_fetch_assoc($cost_query);
    $cost = $cost_result['costs'];   

    // $user_id_result = pg_fetch_assoc($user_id_query);
    // $user_id = $user_id_result['id'];
    $add = pg_query($db_connection,"INSERT INTO taruch ( id_type, secname, adress, phonenum, date, cost, idusers, expiredate) VALUES ( '$type_id', '$name', '$adress', '$phone', '$date', '$cost', '$user_id', '$expiredate')");
    echo '<script>alert("заявка успешно создана.")</script>';
    echo '<script>window.location.href = "tarifs.html"</script>';
    }

else 

{
    
        echo '<script>alert("войдите в свой аккаунт или создайте его.")</script>';
        echo '<script>window.location.href = "tarifs.html"</script>';
        // header("Location: /PFTC_/registration.html");
}
//"INSERT INTO "TarUch" (id_users, id_type, "SecName", "Adress", "PhoneNum", "Date", "Cost") VALUES ('$user_id', '$type_id', '$name', '$adress', '$phone', '$date', '$cost')
// and  email = '$emailcook' and password = '$passcook'
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