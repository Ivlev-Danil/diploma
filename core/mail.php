<?php
  // чтение json
  $json = file_get_contents(filename:'../goods.json');
  $json = json_decode($json, true);

  //письмо
  $message = '';
  $message .= '<h1>Заказ</h1>';
  $message .= '<p>Телефон:'.$_POST['ephone'].'</p>';
  $message .= '<p>Имя:'.$_POST['ename'].'</p>';
  $message .= '<p>Email:'.$_POST['email'].'</p>';

  $cart = $_POST['cart'];
  $sum = 0;
  foreach ($cart as $id => $count) {
    $message .= $json[$id]['name'].'  Кол-во:';
    $message .= $count.'  Cтоимость:';
    $message .= $count*$json[$id]['price'];
    $message .= '<br>';
    $sum = $sum + $count*$json[$id]['price'];
  }
  $message .= 'Всего: '.$sum;
  // print_r($message);

  $to = 'iwlev.danil@gmail.com'.',';
  $to .=$_POST['email'];
  $spectext = '<!DOCTYPE html>
  <html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ</title>
  </head>
  <body>';
  $headers = 'MIME-Version: 1.0'. "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $m = mail($to, 'Заказ', $spectext.$message.'</body></html>', $headers);

  if($m){ echo 1;} else{ echo 0;}

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


    $conn = connect();

    $name = $_POST['ename'];
    $phone = $_POST['ephone'];
    $email = $_POST['email'];
    $messageform = '';
    $cart = $_POST['cart'];
    foreach ($cart as $id => $count) {
      $messageform .= $json[$id]['name'].'  Кол-во:';
      $messageform .= $count.'  Cтоимость:';
      $messageform .= $count*$json[$id]['price'];
      $messageform .= '<br>';
    }

    $sql = "INSERT INTO forms (name, phone, email, cart)
    VALUES ('$name','$phone', '$email', '$messageform')";

    if (mysqli_query($conn, $sql)) {
      echo " ";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);




?>
