<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST GET');
  require ("./dbconnect.php");



  if (isset($_POST['DashboardCheck'])) // Check if user session token is stil valid
  {
      $json = $_POST['DashboardCheck'];
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

            $sql2 = "DELETE FROM session WHERE token=?";
            $stmt1 = $conn->prepare($sql2);
            $stmt1->bind_param("s", $token);
            $stmt1->execute();
            $result2 = $stmt1->get_result();
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
        $sql = "SELECT userid, voornaam
                From users
                WHERE email=?
                AND wachtwoord=?
                AND rol='2'
                AND archive<>'1'";
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
        $sql = "SELECT u.userid, u.schoolid, u.voornaam
                From scholen as s, users as u
                WHERE email=?
                AND wachtwoord=?
                AND u.schoolid=?
                AND u.archive<>'1'";
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


  if (isset($_POST['AllBeeways'])) // get data for beeway table (school admin and teachers only)
  {
      $json = $_POST['AllBeeways'];
      $json = json_decode($json, true);
      $token = $json['Token'];
      if (isset($json['Test']))
      {echo "string";}

      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "ok") {  // session OK

        $sql = "SELECT s.userid, u.schoolid, u.rol
                FROM session as s, users as u
                WHERE s.token='$token'
                AND u.archive<>'1'
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
                      AND u.userid=b.createdby
                      AND u.archive<>'1'
                      LIMIT 2";
              $result2 = $conn->query($sql);

              if ($result2 !== false && $result2 -> num_rows > 0) {
                $text = '<table class="beewaylijsttable" id="bw1">
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

                  if ($row["archive"] == "1") {$archive = "yes";}
                  else {$archive = "no";}

                  $text = $text . '<tr><td>'.$row["beewaynaam"].'</td><td>'.$row["groepen"].'</td><td>'.$row["naamvakgebied"].'</td><td>'.$row["naamthema"].'</td><td>'.$row['voornaam'].'</td><td>'.$status.'</td><td>'.$archive.'</td><td hidden>'.$row["beewayid"].'</td><td><button class="editbutton beewaybutton">bekijken</button></td></tr>';
                }

                echo $text = $text . '</table> <button class="editbutton loadmorebeeway">more</button>';

              } else {
                echo "NOK3"; // not found
              }
            } elseif ($row['rol'] == 1) { // school admin
              $sql = "SELECT b.*, g.groepen, v.naamvakgebied, h.naamthema, u.voornaam
                      FROM beeway as b, groepen as g, vakgebied as v, hoofdthema as h, users as u
                      WHERE b.schoolid='$schoolid'
                      AND v.vakid=b.vakgebiedid
                      AND h.themaid=b.hoofdthemaid
                      AND u.userid=b.createdby
                      AND u.archive<>'1'";
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
                  if ($row["status"] == "0") {$status = "open";}
                  else {$status = "afgerond";}

                  if ($row["archive"] == "1") {$archive = "yes";}
                  else {$archive = "no";}

                  $text = $text . '<tr><td>'.$row["beewaynaam"].'</td><td>'.$row["groepen"].'</td><td>'.$row["naamvakgebied"].'</td><td>'.$row["naamthema"].'</td><td>'.$row['voornaam'].'</td><td>'.$status.'</td><td>'.$archive.'</td><td hidden>'.$row["beewayid"].'</td><td><button class="editbutton beewaybutton">bekijken</button></td></tr>';
                }

                echo $text = $text . "</table>";

              } else {
                echo "NOK3"; // not found
              }
            }
          }
        } else {
          echo "NOK"; // error
        }

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK1";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK2";
      }
  }



  if (isset($_POST['AllKlassen'])) // get data for classes table
  {
      $json = $_POST['AllKlassen'];
      $json = json_decode($json, true);
      $token = $json['Token'];


      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "ok") { // session OK

        // code

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK1";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK2";
      }
  }



  if (isset($_POST['AllVakken'])) // get data for discipline table (super user and school admin only)
  {
      $json = $_POST['AllVakken'];
      $json = json_decode($json, true);
      $token = $json['Token'];


      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "ok") { // session OK

        // code

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK1";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK2";
      }
  }



  if (isset($_POST['AllHoofdthemas'])) // get data for mainthemes table
  {
      $json = $_POST['AllHoofdthemas'];
      $json = json_decode($json, true);
      $token = $json['Token'];


      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "ok") { // session OK

        // code

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK1";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK2";
      }
  }



  if (isset($_POST['AllUsers'])) // get data for user table (school admins and super users only)
  {
      $json = $_POST['AllUsers'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sql1 = "SELECT s.userid, u.rol, u.schoolid
              FROM session as s, users as u
              WHERE s.token='$token'
              AND u.userid=s.userid
              AND u.rol<>'0'
              AND u.archive<>'1'";
      $result1 = $conn->query($sql1);

      if ($result1 !== false && $result1 -> num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
          $schoolid = $row['schoolid'];
          $userid = $row['userid'];


          if ($row['rol'] == 1) { // school admin
            $sql2 = "SELECT u.*
                    FROM users as u
                    WHERE u.schoolid=1
                    AND u.archive<>'1'";
            $result2 = $conn->query($sql2);

            if ($result2 !== false && $result2 -> num_rows > 0) {
              echo "string";
            } else { // no users found
              echo "NOK1";
            }
          }



          elseif ($row['rol'] == 2) { // super user
            $sql2 = "SELECT u.*, s.naamschool
                    FROM users as u, scholen as s
                    WHERE s.schoolid=u.schoolid";
            $result3 = $conn->query($sql2);

            if ($result3 !== false && $result3 -> num_rows > 0) {
              $text = '<table class="beewaylijsttable">
                      <tr>
                        <th><h3>School</h3></th>
                        <th><h3>Naam</h3></th>
                        <th><h3>Email</h3></th>
                        <th><h3>Rol</h3></th>
                        <th><h3>geblokkeerd/verwijderd</h3></th>
                        <th><a href="usertoevoegen.html" class="addbutton">toevoegen</a></th>
                      </tr>';

              while ($row = $result3->fetch_assoc()) {
                if ($row["rol"] == "0") {$rol = "docent";}
                else if ($row["rol"] == "1") {$rol = "school admin";}
                else {$rol = "super user";}

                if ($row["archive"] == "1") {$archive = "yes";}
                else {$archive = "no";}

                if ($row["naamschool"] == "") {$schoolname = "<em>(geen)</em>";}
                else {$schoolname = $row["naamschool"];}

                $text = $text . '<tr><td>'.$schoolname.'</td><td>'.$row["voornaam"].' '.$row["achternaam"].'</td><td>'.$row["email"].'</td><td>'.$rol.'</td><td>'.$archive.'</td><td hidden>'.$row["userid"].'</td><td><a href="useraanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
              }

              echo $text = $text . "</table>";

            } else { // no users found
              echo "NOK1";
            }
          } else { // no valid user found
            echo "NOK";
          }
        }
      } else { // no valid user found
        echo "NOK";
      }
  }



  if (isset($_POST['AllScholen'])) // get data for school table (super user only)
  {
      $json = $_POST['AllScholen'];
      $json = json_decode($json, true);
      $token = $json['Token'];


      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "ok") { // session OK

        $sql = "SELECT u.rol
                FROM session as s, users as u
                WHERE s.token='$token'
                AND u.userid=s.userid
                AND u.rol='2'
                AND u.archive<>'1'";
        $result1 = $conn->query($sql);

        if ($result1 !== false && $result1 -> num_rows > 0) {
          while ($row = $result1->fetch_assoc()) {
            $rol = $row['rol'];

            if ($rol == 2) { // super user
              $sql = "SELECT s.*
                      FROM scholen as s";
              $result2 = $conn->query($sql);

              if ($result2 !== false && $result2 -> num_rows > 0) {
                $text = '<table class="beewaylijsttable">
                        <tr>
                          <th><h3>school naam</h3></th>
                          <th><h3>geblokkeerd/verwijderd</h3></th>
                          <th><h3>users voor school bekijken</h3></th>
                          <th><a href="schooltoevoegen.html" class="addbutton">toevoegen</a></th>
                        </tr>';

                while ($row = $result2->fetch_assoc()) {
                  if ($row["archive"] == "1") {$archive = "yes";}
                  else {$archive = "no";}

                  $text = $text . '<tr><td>'.$row["naamschool"].'</td><td>'.$archive.'</td><td><a href="schoolaanpassen.html" class="editbutton">users bekijken</a></td><td><a href="schoolaanpassen.html" class="editbutton">bewerken</a></td></tr>';
                }

                echo $text = $text . "</table>";

              } else {
                echo "NOK1"; // not found
              }
            } else { // no valid user found
              echo "NOK!"; // error
            }
          }
        } else { // no valid user found
          echo "NOK!"; // error
        }

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK1";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK2";
      }
  }



  if (isset($_POST['beeway'])) // handel saving beeway data
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



  if (isset($_POST['getbeewayperuser'])) // get one beeway by userid and groups
  {
      $json = $_POST['getbeewayperuser'];
      $json = json_decode($json, true);
      $token = $json['Token'];
      $beewayid = $json['BeewayId'];


  }





// --------------------------------------------- other functions --------------------------------------------- //




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

  function SessionCheck($conn, $token)
  {
      $sql = "SELECT stmp
              FROM session
              WHERE token=?";
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
            return "NOK1"; // session expierd

            $sql = "DELETE FROM session WHERE token=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
          } else {
            return "OK"; // session valid
          }
        }
      } else {
        return "NOK2"; // session not found
      }
  }

?>
