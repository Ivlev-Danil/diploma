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

  function init(){
    // вывод товаров
    $conn = connect();

    $sql = "SELECT id, name FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $out  = array();
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $out[$row["id"]] = $row;
      }
      echo  json_encode($out);
    } else {
      echo "0 results";
    }
    mysqli_close($conn);
  }

  function selectOneGoods(){
    $conn = connect();
    $id = $_POST['gid'];
    $sql = "SELECT * FROM goods WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      echo  json_encode($row);
    } else {
      echo "0 results";
    }
    mysqli_close($conn);
  }

  function updateGoods(){
    $conn = connect();
    $id = $_POST['id'];
    $name = $_POST['gname'];
    $discription = $_POST['gdiscription'];
    $PFC = $_POST['gpfc'];
    $price = $_POST['gprice'];
    $img = $_POST['gimg'];

    $sql = "UPDATE goods SET name = '$name', discription = '$discription', PFC = '$PFC', price = '$price', img = '$img' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
      echo "1";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    writeJSON();
  }

  function newGoods(){
    $conn = connect();

    $name = $_POST['gname'];
    $discription = $_POST['gdiscription'];
    $PFC = $_POST['gpfc'];
    $price = $_POST['gprice'];
    $img = $_POST['gimg'];

    $sql = "INSERT INTO goods (name, discription, PFC, price, img )
    VALUES ('$name','$discription', '$PFC', '$price','$img')";

    if (mysqli_query($conn, $sql)) {
      echo "1";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    writeJSON();
  }

  function writeJSON(){
    $conn = connect();

    $sql = "SELECT * FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $out  = array();
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $out[$row["id"]] = $row;
      }
      $a = file_put_contents('../goods.json', json_encode($out));
      echo $a;
    } else {
      echo "0 results";
    }

    mysqli_close($conn);

  }

  function loadGoods(){
    $conn = connect();

    $sql = "SELECT * FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $out  = array();
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $out[$row["id"]] = $row;
      }
      echo json_encode($out);
    }
    else {
      echo "0 results";
    }

    mysqli_close($conn);
  }

  function loadSingleGood(){
    $id = $_POST['id'];
    $conn = connect();

    $sql = "SELECT * FROM goods WHERE id='$id' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $out  = array();
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $out[$row["id"]] = $row;
      }
      echo json_encode($out);
    }
    else {
      echo "0 results";
    }

    mysqli_close($conn);
  }
?>
