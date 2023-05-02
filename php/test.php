<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST GET');
  require ("./dbconnect.php");


  $sql = "SELECT * FROM koppelinggroepen";
  $result = $conn->query($sql);

  $arr = [];
  $inc = 0;

  if ($result !== false && $result -> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo $row['userid'] . ", " . $row['groepenid'] . "<br>";

      

    }
  }

?>
