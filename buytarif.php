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

if (isset($_COOKIE['name']) && isset($_COOKIE['password']) && isset($_COOKIE['email'])) 

{
    $emailcook = $_COOKIE['email'];
    $passcook = $_COOKIE['password'];
    $namecook = $_COOKIE['name'];
    $user_id_query = pg_query($db_connection,"SELECT * FROM users WHERE  email = '$emailcook'");
    //echo $user_id;
    $cost_query = pg_query($db_connection,"SELECT costs FROM tariffs WHERE id = '$type_id'");

    $cost_result = pg_fetch_assoc($cost_query);
    $cost = $cost_result['costs'];   

    $user_id_result = pg_fetch_assoc($user_id_query);
    $user_id = $user_id_result['id'];

    $add = pg_query($db_connection,"INSERT INTO taruch ( id_type, secname, adress, phonenum, date, expiredate, cost, idusers) VALUES ( '$type_id', '$name', '$adress', '$phone', '$date', '$expiredate', '$cost', '$user_id')");
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