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
      $json = $_POST['AllBeeways'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sql = "SELECT s.userid, u.schoolid, u.rol
              FROM session as s, users as u
              WHERE s.token='$token'
              AND u.userid=s.userid";
      $result1 = $conn->query($sql);

      if ($result1 !== false && $result1 -> num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
          $schoolid = $row['schoolid'];
          $userid = $row['userid'];

          if ($row['rol'] == 0) { // docent
            $sql = "SELECT g.groepen, b.*, v.naamvakgebied, h.naamthema, u.voornaam
                    FROM koppelinggroepen as k, groepen as g, beeway as b, vakgebied as v, users as u, hoofdthema as h
                    WHERE '$userid'=k.userid
                    AND k.groepenid=g.groepenid
                    AND g.groepenid=b.groepenid
                    AND b.schoolid='$schoolid'
                    AND v.vakid=b.vakgebiedid
                    AND h.themaid=b.hoofdthemaid
                    AND u.userid=b.createdby";
            $result2 = $conn->query($sql);

            if ($result2 !== false && $result2 -> num_rows > 0) {
              $text = '<table class="beewaylijsttable">
                      <tr>
                        <th><h3>Beeway Naam</h3></th>
                        <th><h3>Groep(en)</h3></th>
                        <th><h3>Vakgebied</h3></th>
                        <th><h3>Hoofdthema</h3></th>
                        <th><h3>aan gemaakt door</h3></th>
                        <th><h3>Status</h3></th>
                        <th><h3>verwijderd</h3></th>
                        <th><a href="beewaybewerken.html" class="addbutton">toevoegen</a></th>
                      </tr>';

              while ($row = $result2->fetch_assoc()) {
                if ($row["status"] == "0") {$status = "open";}
                else {$status = "afgerond";}

                $text = $text . '<tr><td>'.$row["beewaynaam"].'</td><td>'.$row["groepen"].'</td><td>'.$row["naamvakgebied"].'</td><td>'.$row["naamthema"].'</td><td>'.$row['voornaam'].'</td><td>'.$status.'</td><td>'.$row["archive"].'</td><td><a href="beewaybewerken.html" class="editbutton">bekijken</a></td></tr>';
              }

              echo $text = $text . "</table>";

            } else {
              echo "NOK1"; // not found
            }
          } elseif ($row['rol'] == 1) { // admin
            $sql = "SELECT b.*, g.groepen, v.naamvakgebied, h.naamthema, u.voornaam
                    FROM beeway as b, groepen as g, vakgebied as v, hoofdthema as h, users as u
                    WHERE b.schoolid='$schoolid'
                    AND v.vakid=b.vakgebiedid
                    AND h.themaid=b.hoofdthemaid
                    AND u.userid=b.createdby";
            $result3 = $conn->query($sql);

            if ($result3 !== false && $result3 -> num_rows > 0) {
              $text = '<table class="beewaylijsttable">
                      <tr>
                        <th><h3>Beeway Naam</h3></th>
                        <th><h3>Groep(en)</h3></th>
                        <th><h3>Vakgebied</h3></th>
                        <th><h3>Hoofdthema</h3></th>
                        <th><h3>aan gemaakt door</h3></th>
                        <th><h3>Status</h3></th>
                        <th><h3>verwijderd</h3></th>
                        <th><a href="beewaybewerken.html" class="addbutton">toevoegen</a></th>
                      </tr>';

              while ($row = $result3->fetch_assoc()) {
                $text = $text . '<tr><td>'.$row["beewaynaam"].'</td><td>'.$row["groepen"].'</td><td>'.$row["naamvakgebied"].'</td><td>'.$row["naamthema"].'</td><td>'.$row['voornaam'].'</td><td>'.$row["status"].'</td><td>'.$row["archive"].'</td><td><a href="beewaybewerken.html" class="editbutton">bekijken</a></td></tr>';
              }

              echo $text = $text . "</table>";

            } else {
              echo "NOK1"; // not found
            }
          }
        }
      } else {
        echo "NOK"; // error
      }
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
      $json = $_POST['AllUsers'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sql = "SELECT s.userid, u.rol, u.schoolid
              FROM session as s, users as u
              WHERE s.token='$token'
              AND u.userid=s.userid
              AND u.rol<>'0'";
      $result1 = $conn->query($sql);

      if ($result1 !== false && $result1 -> num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
          $schoolid = $row['schoolid'];
          $userid = $row['userid'];

          if ($row['rol'] == 1) { // school admin
            $sql = "SELECT u.*, g.groepen
                    FROM users as u, groepen as g, koppelinggroepen as k
                    WHERE u.schoolid=$schoolid
                    AND u.rol<>'2'
                    AND k.userid=u.userid
                    AND g.groepenid=k.groepenid";
            $result2 = $conn->query($sql);

            if ($result2 !== false && $result2 -> num_rows > 0) {
              $text = '<table class="beewaylijsttable">
                      <tr>
                        <th><h3>Naam</h3></th>
                        <th><h3>Email</h3></th>
                        <th><h3>Rol</h3></th>
                        <th><h3>groepen</h3></th>
                        <th><h3>geblokkeerd/verwijderd</h3></th>
                        <th><a href="usertoevoegen.html" class="addbutton">toevoegen</a></th>
                      </tr>';

              while ($row = $result2->fetch_assoc()) {
                if ($row["rol"] == "0") {$rol = "docent";}
                else if ($row["rol"] == "1") {$rol = "school admin";}
                else {$rol = "super user";}

                $text = $text . '<tr><td>'.$row["voornaam"].' '.$row["achternaam"].'</td><td>'.$row["email"].'</td><td>'.$rol.'</td><td>'.$row["groepen"].'</td><td>'.$row["archive"].'</td><td><a href="useraanpassen.html" class="editbutton">bewerken</a></td></tr>';
              }

              echo $text = $text . "</table>";

            } else {
              echo "NOK1"; // not found
            }
          } elseif ($row['rol'] == 2) { // super user
            $sql = "SELECT u.*, g.groepen
                    FROM users as u, groepen as g, koppelinggroepen as k
                    WHERE k.userid=u.userid
                    AND g.groepenid=k.groepenid";
            $result3 = $conn->query($sql);

            if ($result3 !== false && $result3 -> num_rows > 0) {
              $text = '<table class="beewaylijsttable">
                      <tr>
                        <th><h3>Naam</h3></th>
                        <th><h3>Email</h3></th>
                        <th><h3>Rol</h3></th>
                        <th><h3>groepen</h3></th>
                        <th><h3>geblokkeerd/verwijderd</h3></th>
                        <th><a href="usertoevoegen.html" class="addbutton">toevoegen</a></th>
                      </tr>';

              while ($row = $result3->fetch_assoc()) {
                $text = $text . '<tr><td>'.$row["beewaynaam"].'</td><td>'.$row["groepen"].'</td><td>'.$row["naamvakgebied"].'</td><td>'.$row["naamthema"].'</td><td>'.$row['voornaam'].'</td><td>'.$row["status"].'</td><td>'.$row["archive"].'</td><td><a href="beewaybewerken.html" class="editbutton">bekijken</a></td></tr>';
              }

              echo $text = $text . "</table>";

            } else {
              echo "NOK1"; // not found
            }
          }
        }
      } else { // no valid user found
        echo "NOK"; // error
      }
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
      $now->modify('+1 day');
    }

    $dt = strtotime($now->format('y-m-d h:i:s'));

    $sql = "INSERT INTO session (stmp, token, userid) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $dt, $token, $userid);
    $stmt->execute();
    $result = $stmt->get_result();

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
