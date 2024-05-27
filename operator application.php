<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=123";
$db_connection = pg_connect($connection_string);
date_default_timezone_set('UTC');

$compname = $_POST['company_name'];
$adress = $_POST['adress'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$date = date("Y-m-d");
$type_id = $_POST['id_type'];

// $user_id_result = pg_fetch_assoc($user_id_query);
// $user_id = $user_id_result['id'];
$add = pg_query($db_connection,"INSERT INTO oper_request ( company_name, adress, name, phone, email, type, date) VALUES ( '$compname', '$adress', '$name', '$phone', '$email', '$type_id', '$date')");
echo '<script>alert("заявка успешно создана.")</script>';
echo '<script>window.location.href = "/project-great-diplom/for operators.html"</script>';


//"INSERT INTO "TarUch" (id_users, id_type, "SecName", "Adress", "PhoneNum", "Date", "Cost") VALUES ('$user_id', '$type_id', '$name', '$adress', '$phone', '$date', '$cost')
// and  email = '$emailcook' and password = '$passcook'
