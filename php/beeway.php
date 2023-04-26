<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST GET');
  require ("./dbconnect.php");


  if (isset($_POST['test'])) // test
  {
    $sql = "SELECT voornaam FROM users";
    $result = $conn->query($sql);

    if ($result !== false && $result -> num_rows > 0) {
      $text = "<table border=1> <tr><th>naam</th></tr>";

      while ($row = $result->fetch_assoc()) {
          $text = $text . "<tr><td>".$row['voornaam']."</td></tr>";
      }
      echo $text = $text . "</table>";
    } else {
      echo "string";
    }
  }

  if (isset($_POST['SessionCheck'])) // Check if user session token is stil valid
  {
      $json = $_POST['SessionCheck'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sql = "SELECT stmp FROM session WHERE token=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $token);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result !== false && $result -> num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $stmp = $row['stmp'];

          $now = new datetime();
          $dt = strtotime($now->format('y-m-d h:i:s'));

          if ($dt >= $stmp) {
            echo "NOK1"; // session expierd

            $sql = "DELETE FROM session WHERE token=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
          } else {
            echo "OK"; // session valid
          }
        }
      } else {
        echo "NOK2"; // session not found
      }
  }


  if (isset($_POST['Login'])) // User login
  {
      $json = $_POST['Login'];
      $json = json_decode($json, true);
      $email = $json['Email'];
      $psw = $json['Psw'];
      $school = $json['School'];

      if ($school === "0") { // superadmin login
        $sql = "SELECT userid, voornaam From users WHERE email=? AND wachtwoord=? AND rol='2'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $psw);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result !== false && $result -> num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $userid = $row['userid'];
            $voornaam = $row['voornaam'];

            $token = SetSession($conn, $userid);
            $jsonArrayObject = (array('Token' => $token,
                        						  'Voornaam' => $voornaam
                              ));
           $json_array = json_encode($jsonArrayObject);
      		 echo $json_array;
          }
        } else {
          echo "NOK1"; // error
        }
      } else { // school admin or school teatcher login
        $sql = "SELECT u.userid, u.schoolid, u.voornaam From scholen as s, users as u WHERE email=? AND wachtwoord=? AND u.schoolid=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $psw, $school);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result !== false && $result -> num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $userid = $row['userid'];
            $voornaam = $row['voornaam'];

            $token = SetSession($conn, $userid);
            $jsonArrayObject = (array('Token' => $token,
                                      'Voornaam' => $voornaam
                              ));
            $json_array = json_encode($jsonArrayObject);
            echo $json_array;
            }
          } else {
          echo "NOK2"; // error
        }
      }
  }


  if (isset($_POST['Logout'])) // User logout
  {
      $json = $_POST['Logout'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sql = "DELETE FROM session WHERE token=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $token);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result !== false && $result -> num_rows > 0) {

      } else {
        echo "NOK";
      }
  }


  if (isset($_POST['AllBeeways'])) //data ophalen voor Beeway lijst
  {
      // $json = $_POST['AllBeeways'];
      // $json = json_decode($json, true);
      $token = "hGEnZO3R1cffGakKUeyOBA5zt87m62nAs67U1exUpAQojwum39";

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
            $schoolid = $row['schoolid'];

            $sql = "SELECT * FROM beeway WHERE schoolid='$schoolid'";
          }
        }
      }
      else
      {
        echo "NOK"; // error
      }

      // $sql = "SELECT groepenid FROM koppelinggroepen WHERE userid = '$userid'";
      // $sql = "SELECT groepenid FROM groepen WHERE groepenid = '$groepenid'";
      // $sql = "SELECT * FROM beeway WHERE groepenid = '$groepenid' AND schoolid='$schoolid'";
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





  function SetSession($conn, $userid)
  {
    $number = generateRandomNumber();
    $token = RandomString($number);

    $now = new datetime();

    if (isset($rememberme)) {
      $now->modify('+7 day');
    } else {
      $now->modify('+8 hour');
    }

    $dt = strtotime($now->format('y-m-d h:i:s'));

    $sql = "INSERT INTO session (stmp, token, userid) VALUES ('$dt', '$token', '$userid')";
    $result = $conn->query($sql);

    return $token;
  }

  function RandomString($length) // set random string
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
  }
  function generateRandomNumber() { // Generate a random number between 50 and 100
    $randomNumber = rand(50, 100);
    return $randomNumber;
  }

?>
