<?php
// if (isset($_COOKIE['name']) && isset($_COOKIE['password'])) 
// {
//   // Если файлы куки существуют, перенаправляем на личный кабинет
//   header("Location: /PFTC_/personal area.html");;
//   exit;
// }

$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);

$email = $_POST['email'];
$password = $_POST['password'];

$user = pg_query($db_connection,"SELECT count(*) AS rows FROM users WHERE email = '$email'");

if  (!$user) 
{
  echo "query did not execute";
}




$result = pg_fetch_assoc($user);
if ($result['rows']==0)

{ 
  echo '<script>alert("ошибка входа.")</script>';
  header("Location: /PFTC_last/login.html");
  // header("Location: /PFTC_/123.html");
}

else

{ 
  header("Location: /PFTC_last/personal area.html");
// echo "<a href='personal area.html' >Имя файла</a><br>";
// $target = 'personal area.html'; // Это уже существующий файл
// $link = 'newfile.ext'; // Это файл, который вы хотите привязать к первому

// // symlink($target, $link);
// echo readlink($link);
}

$stmt = pg_query($db_connection,$query);




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