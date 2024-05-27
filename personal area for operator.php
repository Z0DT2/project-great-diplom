<html>
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="LK.css">
    <title> Личный кабинет </title>
    <style>
        td
        {
            color: white;
        }
        td,tr
        {
            color: white;
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
    <br>
    <table align="center" width = 1500 height = 800 cellspacing = "20px" style="background-color: rgb(32, 26, 68);" border="0">
        <?php
// Подключение к базе данных
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=123";
$db_connection = pg_connect($connection_string);
$key = "aboba204980sdf";

$jwt = $_COOKIE['jwt'];
$decoded_payload = jwt_decode($jwt, $key);
$user_id = $decoded_payload['user_id'];
$name = $decoded_payload['name'];
$email = $decoded_payload['email'];

// Выполнение запроса к базе данных

    $table = pg_query($db_connection, "SELECT * FROM operuch join operators on operid = opid join tariffs on tarid = idtarif where opid = '$user_id'");
            
    // Создание таблицы HTML
    echo "<tr valign = top><td width = 10 height = 10><img class=pfp src=no-image.jpg></td></td><td valign = bottom height = 10 width = 100>Login: $name</td><td valign=top width = 300 align=center rowspan=4><br><br>Активные услуги <br>";
    echo "<table align='center' width = 1000 cellspacing = '20px' style='background-color: #393e46;' border='1'>";
    echo "<tr><th>ID подключенной услуги</th><th>тип подключенной услуги</th><th>название тарифа</th><th>Дата заключения договора</th></tr>";
    
    // Вывод данных из базы данных в таблицу HTML
    while ($rowt = pg_fetch_assoc($table)) {
        echo "<tr><td align = center>" . $rowt['uchid'] . "</td><td align = center>" . $rowt['type'] . "</td><td align = center>" . $rowt['tar_name'] . "</td><td align = center>" . $rowt['date'] . "</td></tr>";
    }
    
    echo "</table>";
    echo "<tr><td align=right height = 10>Email:</td><td height = 10>$email</td></tr>";
    

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

            <tr><td align="center" height = 10 colspan="2"><button class="password-reset" id="passreset" onclick="modalforpass()">Сбросить пароль</button></td></tr>
            <div id="modalpass" class="modal">
                <!-- Содержимое модального окна -->
                <div class="modal-content">
                  <span class="close" onclick="closepassModal()">&times;</span>
                  <form action="reset.php" method="post">
                  <h2>Смена пароля</h2>
                  <!-- Добавьте здесь необходимые поля для смены пароля -->
                  старый пароль <br>
                  <input name="oldpassword" type="number" id="oldpassword" required ><br>
                  новый пароль <br>
                  <input name="newpassword" type="number" id="newpassword" required><br>
                  повторите новый пароль <br>
                  <input name="newpasswordrep" type="number" id="newpasswordrep" required><br><br>
                  <button  type="submit" onclick="savePassword()">Сохранить</button>
                </div>
            </div>
              
            <script>
              // Функция для открытия модального окна
              function modalforpass()
               {
                document.getElementById("modalpass").style.display = "block";
              }
              
              // Функция для закрытия модального окна
              function closepassModal() 
              {
                document.getElementById("modalpass").style.display = "none";
              }
              
              // Функция для сохранения нового пароля
              function savePassword() 
              {
                alert("Пароль успешно изменен! сейчас ваc вернет на страничку входа");
                closepassModal();
              }
            </script>
        </form> 
        <tr><td align="center" valign = "top" colspan="2"></td></tr>
    </form> 
    </table>
    <script src="app.js"></script>
    </body>
</html>