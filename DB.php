<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$reppassword = $_POST['reppassword'];

$povtor = pg_query($db_connection,"SELECT count(*) AS rows FROM users WHERE email = '$email'");

if($password != $reppassword)
{
  echo '<script>alert("пароли не совпадают.")</script>';
  echo '<script>window.location.href = "registration.html"</script>';
}
else
{

if (strpos($email, '@') === false) 

{
  echo '<script>alert("Введите корректную почту.")</script>';
  echo '<script>window.location.href = "registration.html"</script>';
}

 else 
 
{

if  (!$povtor) 
{
  echo "query did not execute";
}
$result = pg_fetch_assoc($povtor);

if ($result['rows']==0)
{ 
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $query = pg_query($db_connection,"INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')");
  $idreq = pg_query($db_connection,"SELECT * FROM users WHERE email = '$email' and password = '$hashedPassword'");
  $idres = pg_fetch_assoc($idreq);
    // Создание JWT токена
    $payload = [
     'user_id' => $idres['id'],
     'name' => $idres['name'],
     'email' => $idres['email'],
     'password' => $idres['password']
   ];
 
 // Кодирование JWT токена
 $jwt = jwt_encode($payload, "aboba204980sdf", "sha256");
 
 // Отправка JWT токена в ответе
 setcookie("jwt", $jwt, time() + (86400 * 30), "/");
 
 // echo "<a href='personal area.html' >Имя файла</a><br>";
 // $target = 'personal area.html'; // Это уже существующий файл
 // $link = 'newfile.ext'; // Это файл, который вы хотите привязать к первому
 
 // // symlink($target, $link);
 // echo readlink($link);
 
 function jwt_encode($payload, $key, $algorithm) {
   $header = json_encode(array("alg" => $algorithm, "typ" => "JWT"));
   $header = base64url_encode($header);
   
   $payload = json_encode($payload);
   $payload = base64url_encode($payload);
   
   $signature = hash_hmac($algorithm, "$header.$payload", $key, true);
   $signature = base64url_encode($signature);
   
   return "$header.$payload.$signature";
 }
 
 function base64url_encode($data) {
   $base64 = base64_encode($data);
   $base64url = str_replace(array("+", "/", "="), array("-", "_", ""), $base64);
   
   return $base64url;
 }

  //$povtor = pg_query($db_connection,"SELECT count(*) AS rows FROM users WHERE email = '$email'");
  header("Location: /project-great-diplom/personal area.html");
  // header("Location: https://example.com");
}

else 
{
  echo '<script>alert("ошибка регистрации.")</script>';
  echo '<script>window.location.href = "registration.html"</script>';
  // header("Location: /PFTC_/registration.html");
}
}
}
;