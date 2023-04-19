<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST GET');
  require ("./dbconnect.php");

  // if (isset($_POST['Test']))
  // {
  //
  //   $json = $_POST['Test'];
  //   $json = json_decode($json, true);
  //
  //   $name = $json['Name'];
  //   $pwd = $json['Pwd'];
  //
  //   echo $name . "  " . $pwd;
  // }


  if (isset($_POST['User']))
  {
    $sql = "SELECT * FROM users";
	 	$result = $conn->query($sql);

    if ($result !== false && $result -> num_rows > 0)
		{
      $text = "<table border=1> <tr><th>Naam</th><th>password</th></tr>";

			while ($row = $result->fetch_assoc())
			{
        $text = $text . "<tr><td>".$row['VoorNaam']."</td><td>".$row['Wachtword']."</td></tr>";
			}
      echo $text = $text . "</table>";
		}
    else
    {
      echo "NOK";
    }
  }


  if (isset($_POST['beeway']))
  {

    $json = $_POST['beeway'];
    $json = json_decode($json, true);
    $gen = $json['gen'];
    $plan = $json['plan'];
    $obs = $json['obs'];

    $plan = json_decode($plan, true);

    $keys = "";
    $values = "";

    foreach ($plan as $key => $value) {
      $keys = $keys . "" . $key . ", " ;
      $values = $values . "'" . $value . "', " ;
    }

    echo $keys;

    // $sql = "INSERT INTO `beeway` (" . substr($keys, 0, -2) . ") VALUES (" . substr($values, 0, -2) . ")";
    //
    // if ($conn->query($sql) === TRUE) {
    //   $last_id = $conn->insert_id;
    //   echo "New record created successfully. Last inserted ID is: " . $last_id;
    // } else {
    //   echo "Error: " . $sql . "<br>" . $conn->error;
    // }




    // foreach ($gen as $key => $value) {
    //   $keys = $keys . "" . $key . ", " ;
    //   $values = $values . "'" . $value . "', " ;
    // }
    //
    // $sql = "INSERT INTO `beeway` (" . substr($keys, 0, -2) . ") VALUES (" . substr($values, 0, -2) . ")";
    //
    // if ($conn->query($sql) === TRUE) {
    //   $last_id = $conn->insert_id;
    //   echo "New record created successfully. Last inserted ID is: " . $last_id;
    // } else {
    //   echo "Error: " . $sql . "<br>" . $conn->error;
    // }

  }



?>
