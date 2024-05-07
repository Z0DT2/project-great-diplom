<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="main_style.css">
    <title> Поддержка </title>
    <style>
        td,tr
        {
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <table style="background-color: #393e46;">
            <tr>
                <td><a href="news and updates.html" class="head-item"><img src="logo\123.png" width="140" height="80"></a></td>
                <td width = 200 align="center"><p><a href="tarifs.html" class="head-item">Тарифы </a></p></td>
                <td width = 200 align="center"><p><a href="news and updates.html" class="head-item">Новости и обновления </a></p></td>
                <td width = 200 align="center"><p><a href="achievements.html" class="head-item"> Достижения </a></p></td>
                <td width = 200 align="center"><p><a href="tech support.html" class="head-item"> Чат поддержки </a></p></td> 
                <td width = 200 align="center"><p><a href="for operators.html" class="head-item"> Для операторов </a></p></td> 
                <td width = 2000></td>
                <td width = 200 align="center"> <p><a href="registration.html" class="head-item"> регистрация </a><br></p></p><a href="login.html" class="head-item">вход </a></td>
            </tr>
        </table>
    </header>
</body>
</html>
<?php
// Подключение к базе данных
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=123";
$db_connection = pg_connect($connection_string);
$key = "aboba204980sdf";

$jwt = $_COOKIE['jwt'];
$decoded_payload = jwt_decode($jwt, $key);
$user_id = $decoded_payload['user_id'];

// Выполнение запроса к базе данных
if(isset($_POST['submit'])) {
    $table = pg_query($db_connection, "SELECT * FROM taruch join tariffs on id_type = idtarif where idusers = '$user_id'");
            
    // Создание таблицы HTML
    echo "<table align='center' width = 1000 cellspacing = '20px' style='background-color: rgb(32, 26, 68);' border='0'>";
    echo "<tr><th>ID тарифа</th><th>название тарифа</th><th>ФИО</th><th>Дата оплаты подписки</th><th>Дата истечения подписки</th><th align='center'>оставшиеся месяцы</th></tr>";
    
    // Вывод данных из базы данных в таблицу HTML
    while ($rowt = pg_fetch_assoc($table)) {
        echo "<tr><td>" . $rowt['id'] . "</td><td>" . $rowt['tar_name'] . "</td><td>" . $rowt['secname'] . "</td><td>" . $rowt['date'] . "</td><td>" . $rowt['expiredate'] . "</td><td>" . $rowt['extension'] . "</td></tr>";
    }
    
    echo "</table>";
    
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
?>
