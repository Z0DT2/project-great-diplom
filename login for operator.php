<?php
// if (isset($_COOKIE['name']) && isset($_COOKIE['password'])) 
// {
//   // Если файлы куки существуют, перенаправляем на личный кабинет
//   header("Location: /PFTC_/personal area.php");;
//   exit;
// }

$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);

$email = $_POST['email'];
$password = $_POST['password'];
$passFromDb = pg_query($db_connection,"SELECT password FROM operators WHERE email = '$email'");
$haspassres = pg_fetch_assoc($passFromDb);
$hashedpass = $haspassres['password'];

if (password_verify($password, $hashedpass)) 
{
$user = pg_query($db_connection,"SELECT count(*) AS rows FROM operators WHERE email = '$email' and password = '$hashedpass'");
$userinfo = pg_query($db_connection,"SELECT * FROM operators WHERE email = '$email' and password = '$hashedpass'");


if  (!$user) 
{
  echo "ошибка подключения к серверу";
}



$infores = pg_fetch_assoc($userinfo);
$result = pg_fetch_assoc($user);
if ($result['rows']==0)

{ 
  echo '<script>alert("данных нету в базе данных.")</script>';
  echo '<script>window.location.href = "login for operator.html"</script>';
  // header("Location: /PFTC_/123.html");
}

else

{ 
   // Создание JWT токена
   $payload = [
    'user_id' => $infores['id'],
    'name' => $infores['name'],
    'email' => $infores['email'],
    'password' => $infores['password']
  ];

// Кодирование JWT токена
$jwt = jwt_encode($payload, "aboba204980sdf", "sha256");

// Отправка JWT токена в ответе
setcookie("jwt", $jwt, time() + (86400 * 30), "/");
  header("Location: personal area for operator.php");

// echo "<a href='personal area.php' >Имя файла</a><br>";
// $target = 'personal area.php'; // Это уже существующий файл
// $link = 'newfile.ext'; // Это файл, который вы хотите привязать к первому

// // symlink($target, $link);
// echo readlink($link);
}
}
else{
  echo '<script>alert("неправельно введены логин или пароль.")</script>';
  echo '<script>window.location.href = "login for operator.html"</script>';
}
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
// $stmt = pg_query($db_connection,$query);




// if(isset($_POST['submit'])) {
//   $name = $_POST['name'];
//   $email = $_POST['email'];

//   // Проверка ввода данных
//   if(!empty($name) && !empty($email)) {
//       // Если данные правильные, перенаправляем по ссылке
//       header("");
//       exit;
//   } else {
//       // Если данные неправильные, выводим сообщение об ошибке
//       echo "Пожалуйста, заполните все поля.";
//   }
// }






















// if (condition)
//  {

//  if else (condition) 
//  {

//  }
//  else
// }