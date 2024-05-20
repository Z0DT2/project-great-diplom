<?php
$connection_string = "host=localhost port=5432 dbname=Base user=postgres password=Sergoe";
$db_connection = pg_connect($connection_string);
date_default_timezone_set('UTC');

$today = date("Y-m-d");

// Запрос для выборки записей, удовлетворяющих условиям
$query = "SELECT id, expiredate, extension FROM taruch WHERE (expiredate = '$today' OR expiredate < '$today')";
$result = pg_query($db_connection, $query);

// Обработка выбранных записей
while ($row = pg_fetch_assoc($result)) {
    $id = $row['id'];
    $date = $row['expiredate'];
    $number = $row['extension'];

    // Если до указанной даты остался 1 день или дата меньше сегодняшней
    if ($date == $today || $date < $today) {
        // Отнимаем 1 от числа в соседнем столбце 
        $newNumber = $number - 1;

        // Прибавляем 30 дней к дате в таблице
        $newDate = date('Y-m-d', strtotime($date . ' + 30 days'));

        // Обновление записи в таблице
        $updateQuery = "UPDATE taruch SET extension = $newNumber, expiredate = '$newDate' WHERE id = $id";
        pg_query($db_connection, $updateQuery);
    }
}
echo '<script>alert("данные успешно обновленны.")</script>';
 // Запрос на получение данных
 $table = pg_query($db_connection, "SELECT * FROM taruch");
            
 // Создание таблицы HTML
 echo "<table>";
 echo "<tr><th>idusers</th><th>secname</th><th>expiredate</th><th align='center'>extension</th></tr>";
 
 // Вывод данных из базы данных в таблицу HTML
 while ($rowt = pg_fetch_assoc($table)) {
     echo "<tr><td>" . $rowt['idusers'] . "</td><td>" . $rowt['secname'] . "</td><td>" . $rowt['expiredate'] . "</td><td align='center'>" . $rowt['extension'] . "</td></tr>";
 }
 
 echo "</table>";
 