<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST GET');
  require ("./dbconnect.php");


  if (isset($_POST['User'])) //een test
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
    } else {
      echo "NOK";
    }
  }

  if (isset($_POST['AllBeeways'])) //data ophalen voor Beeway lijst
  {
    $json = $_POST['AllBeeways'];
    $json = json_decode($json, true);
    $token = $json['token'];

    // docent of admin?
    // addmin al beeways from schoolid
    // docent all beeway from schoolid and groepid

    $sql = "SELECT s.userid, u.schoolid, u.rol FROM session as s, users as u WHERE token='$token' AND u.userid=s.userid";
    $result = $conn->query($sql);

    if ($result !== false && $result -> num_rows > 0)
		{
      while ($row = $result->fetch_assoc())
			{
        if ($row['rol'] == 0) {
          $sql = "SELECT k.groepenid, g.groepenid, b.*
                  FROM koppelinggroepen as k, groepen as g, beeway as b
                  WHERE s.userid=k.userid
                    AND k.groepenid=g.groepenid
                    AND g.groepenid=b.groepenid";

        } elseif ($row['rol'] == 1) {
          $sql = "SELECT * FROM beeway WHERE schoolid='$row['schoolid']'";
        }
      }
    }
    else
    {
      echo "NOK";
    }

    $sql = "SELECT groepenid FROM koppelinggroepen WHERE userid = '$userid'";
    $sql = "SELECT groepenid FROM groepen WHERE groepenid = '$groepenid'";
    $sql = "SELECT * FROM beeway WHERE groepenid = '$groepenid' AND schoolid='$schoolid'";
  }

  if (isset($_POST['AllKlassen'])) //data ophalen voor Klassen lijst
  {

  }

  if (isset($_POST['AllVakken'])) //data ophalen voor Vakken lijst
  {

  }

  if (isset($_POST['AllHoofdthemas'])) //data ophalen voor Hoofdthema's lijst
  {

  }

  if (isset($_POST['AllUsers'])) //data ophalen voor Users lijst
  {

  }

  if (isset($_POST['AllScholen'])) //data ophalen voor scholen lijst
  {

  }

  if (isset($_POST['beeway'])) //data afhandelen voor opslaan beeway
  {
    $json = $_POST['beeway'];
    $json = json_decode($json, true);
    $gen = $json['gen'];
    $plan = $json['plan'];
    $obs = $json['obs'];

    $gen = json_decode($gen, true);

    $keys = "";
    $values = "";

    // foreach ($plan as $key => $value) {
    //   $keys = $keys . "" . $key . ", " ;
    //   $values = $values . "'" . $value . "', " ;
    // }

    echo $keys;

    // $sql = "INSERT INTO `beeway` (" . substr($keys, 0, -2) . ") VALUES (" . substr($values, 0, -2) . ")";
    //
    // if ($conn->query($sql) === TRUE) {
    //   $last_id = $conn->insert_id;
    //   echo "New record created successfully. Last inserted ID is: " . $last_id;
    // } else {
    //   echo "Error: " . $sql . "<br>" . $conn->error;
    // }


    foreach ($gen as $key => $value) {
      $keys = $keys . "" . $key . ", " ;
      $values = $values . "'" . $value . "', " ;
    }

    $sql = "INSERT INTO `beeway` (" . substr($keys, 0, -2) . ") VALUES (" . substr($values, 0, -2) . ")";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
      echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }



?>
