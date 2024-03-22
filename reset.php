<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);


if (isset($_COOKIE['name']) && isset($_COOKIE['password']) && isset($_COOKIE['email'])) 
{
    $email = $_COOKIE['email'];
    $oldpasswordcookie = $_COOKIE['password'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $newpasswordrep = $_POST['newpasswordrep'];
    if ($oldpassword == $oldpasswordcookie and $newpassword == $newpasswordrep)
    {
        $temppassword = pg_query($db_connection,"UPDATE users SET password = '$newpassword'  WHERE email = '$email' AND password = '$oldpassword'");
        header("Location: /PFTC_/login.html");
    }
    else 
    echo '<script>alert("вы ввели неправильный старый пароль или не повторили новый.")</script>';
    echo '<script>window.location.href = "tarifs.html"</script>';
    exit;
}