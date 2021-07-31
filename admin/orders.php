<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <header class="header">
      <nav class="nav-admin">
        <a href="admin.html" class="nav-admin-item">Товары</a>
        <a href="orders.php" class="nav-admin-item">Заказы</a>
      </nav>

    </header>
    <main class="main">
    <?php
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "diploma_v2";

  function connect(){
    $conn = mysqli_connect("localhost", "root", "root", "diploma_v2");
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
  }

  function link_bar($page, $pages_count)
{
for ($j = 1; $j <= $pages_count; $j++)
{
// Вывод ссылки
if ($j == $page) {
echo ' <a style="color: #800080;" ><b>'.$j.'</b></a> ';
} else {
echo ' <a style="color: #808000;" href='.$_SERVER['PHP_SELF'].'?page='.$j.'>'.$j.'</a> ';
}
// Выводим разделитель после ссылки, кроме последней
// например, вставить "|" между ссылками
if ($j != $pages_count) echo ' ';
}
return true;
} // Конец функции

// Подключение к базе данных


// Подготовка к постраничному выводу
$perpage = 5; // Количество отображаемых данных из БД

if (empty($_GET['page']) || ($_GET['page'] <= 0)) {
$page = 1;
} else {
$page = (int) $_GET['page']; // Считывание текущей страницы
}
// Общее количество информации
$conn = connect();

$sql = "SELECT * FROM forms ORDER by id DESC";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
$pages_count = ceil($count / $perpage); // Количество страниц

// Если номер страницы оказался больше количества страниц
if ($page > $pages_count) $page = $pages_count;
$start_pos = ($page - 1) * $perpage; // Начальная позиция, для запроса к БД


// Вывод информации из базы данных


$sql = "SELECT * FROM forms ORDER by id DESC LIMIT $start_pos,$perpage";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {

  // output data of each row
  while($row = mysqli_fetch_row($result)) {
    echo "<p>Номер закакза: $row[0]</p>";
    echo "<p> Имя: $row[1]</p>";
    echo "<p> Номер: $row[2]</p>";
    echo "<p> Заказ: $row[4]</p>";
    echo "<br>";
    echo "<br>";
  }
}
else {
  echo "0 results";
}

echo "Страницы:";
// Вызов функции, для вывода ссылок на экран
link_bar($page, $pages_count);
    ?>

    </main>
    <footer class="footer">

    </footer>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src=""></script>
</body>
</html>
