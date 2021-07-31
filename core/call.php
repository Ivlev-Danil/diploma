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


  // print_r($message);

  $to = 'iwlev.danil@gmail.com';
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
?>
