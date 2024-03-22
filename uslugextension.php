<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);

$uslugid = $_POST['uslugid'];
// Получаем значение из элемента input
$rawDate = $_POST['updateusluguntil'];

// Создаем объект DateTime с полученной датой
$date = new DateTime($rawDate);

// Форматируем дату в нужный формат для PostgreSQL
$dbDate = $date->format('Y-m-d');


if (isset($_COOKIE['name']) && isset($_COOKIE['password']) && isset($_COOKIE['email'])) 
{
    $emailcook = $_COOKIE['email'];
    $passcook = $_COOKIE['password'];
    $namecook = $_COOKIE['name'];
    $idcheck = pg_query($db_connection,"SELECT count(*) AS rows FROM taruch WHERE id = '$uslugid'");
    $result = pg_fetch_assoc($idcheck);
    if ($result['rows']==1)    
    {
        // тут нужен код для продления услуги чтобы она продлевалась на 30 дней до числа в $dbdate
        // 2 вариант реализации: можно вместо числа до которого она будет продлеваться указать просто количество продлений и изменять его счетчиком каждые 30-31 день
        // для 2 варианта связаться с фронт-энд разрабом
    }
    else 
    echo '<script>alert("вы ввели неправильный старый пароль или не повторили новый.")</script>';
    echo '<script>window.location.href = "tarifs.html"</script>';
    exit;
}