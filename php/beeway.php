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
          // echo $dt . ", " . $stmp . ", ";
          if ($dt > $stmp) {
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
        echo "NOK2"; // session not found (invalid)
      }
  }


  if (isset($_POST['Login'])) // User login
  {
      $json = $_POST['Login'];
      $json = json_decode($json, true);
      $email = $json['Email'];
      $psw = $json['Psw'];
      $school = $json['School'];

      if ($school === "0" && $email != "" && $psw != "") { // superadmin login
        $sql = "SELECT DISTINCT userid, firstname
                From users
                WHERE email=?
                AND password=?
                AND role='2'
                AND archive<>'1'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $psw);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result !== false && $result -> num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $userid = $row['userid'];
            $voornaam = $row['firstname'];

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
      } else if ($school != "0" && $email != "" && $psw != "") { // school admin or school teatcher login
        $sql = "SELECT DISTINCT u.userid, u.firstname
                From users as u
                WHERE u.email=?
                AND u.password=?
                AND u.schoolid=?
                AND u.role<>'2'
                AND u.archive<>'1'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $psw, $school);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result !== false && $result -> num_rows > 0) {
          if ($row = $result->fetch_assoc()) {
            $userid = $row['userid'];
            $voornaam = $row['firstname'];

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
      } else {
        echo "NOK3"; // error
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
        $sql1 = "SELECT s.userid, u.schoolid, u.rol
                FROM session as s, users as u
                WHERE s.token=?
                AND u.archive<>'1'
                AND u.userid=s.userid";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if ($result1 !== false && $result1 -> num_rows > 0) {
          while ($row = $result1->fetch_assoc()) {
            $schoolid = $row['schoolid'];
            $userid = $row['userid'];

            if ($row['role'] == 0) { // docent
              $sql2 = "SELECT g.groups, b.*, v.disciplinename, h.namethema, u.firstname
                      FROM linkgroups as k, groups as g, beeway as b, disciplines as v, users as u, maintheme as h
                      WHERE ?=k.userid
                      AND k.groupid=g.groupid
                      AND g.groupid=b.groupid
                      AND b.schoolid=?
                      AND v.disciplineid=b.disciplineid
                      AND h.themeid=b.mainthemeid
                      AND u.userid=b.createdby
                      AND u.archive<>'1'
                      LIMIT 2";
              $stmt2 = $conn->prepare($sql2);
              $stmt2->bind_param("ss", $userid, $schoolid);
              $stmt2->execute();
              $result2 = $stmt2->get_result();

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

                  $text = $text . '<tr><td>'.$row["beewayname"].'</td><td>'.$row["groups"].'</td><td>'.$row["disciplinename"].'</td><td>'.$row["namethema"].'</td><td>'.$row['firstname'].'</td><td>'.$status.'</td><td>'.$archive.'</td><td hidden>'.$row["beewayid"].'</td><td><button class="editbutton beewaybutton">bekijken</button></td></tr>';
                }

                echo $text = $text . '</table> <button class="editbutton loadmorebeeway">more</button>';

              } else {
                echo "NOK3"; // not found
              }
            } elseif ($row['role'] == 1) { // school admin
              $sql3 = "SELECT b.*, g.groups, v.disciplinename, h.namethema, u.firstname
                      FROM beeway as b, groups as g, disciplines as v, maintheme as h, users as u
                      WHERE b.schoolid=?
                      AND b.groupid=g.groupid
                      AND v.disciplineid=b.disciplineid
                      AND h.themeid=b.mainthemeid
                      AND u.userid=b.createdby
                      AND u.archive<>'1'";
                      $stmt3 = $conn->prepare($sql3);
                      $stmt3->bind_param("s", $schoolid);
                      $stmt3->execute();
                      $result3 = $stmt3->get_result();

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

                  $text = $text . '<tr><td>'.$row["beewayname"].'</td><td>'.$row["groups"].'</td><td>'.$row["disciplinename"].'</td><td>'.$row["namethema"].'</td><td>'.$row['firstname'].'</td><td>'.$status.'</td><td>'.$archive.'</td><td hidden>'.$row["beewayid"].'</td><td><button class="editbutton beewaybutton">bekijken</button></td></tr>';
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



  if (isset($_POST['AllGroups'])) // get data for classes table
  {
      $json = $_POST['AllGroups'];
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



  if (isset($_POST['AllDisciplines'])) // get data for discipline table (super user and school admin only)
  {
      $json = $_POST['AllDisciplines'];
      $json = json_decode($json, true);
      $token = $json['Token'];


      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "OK") { // session OK

        $sql1 = "SELECT u.role, u.schoolid
                FROM session as s, users as u
                WHERE s.token=?
                AND u.userid=s.userid
                AND u.role<>'0'
                AND u.archive<>'1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if ($result1 !== false && $result1 -> num_rows > 0) {
          if ($row = $result1->fetch_assoc()) {
            $schoolid = $row['schoolid'];

            if ($row['role'] == 1) { // school admin
              // $sql2 = "SELECT m.*
              //         FROM maintheme as m
              //         WHERE m.schoolid=?
              //         AND m.schoolid<>'0'
              //         AND m.archive<>'1'";
              // $stmt2 = $conn->prepare($sql2);
              // $stmt2->bind_param("s", $schoolid);
              // $stmt2->execute();
              // $result2 = $stmt2->get_result();
              //
              // if ($result2 !== false && $result2 -> num_rows > 0) {
              //   $text = '<table class="beewaylijsttable">
              //           <tr>
              //            <th><h3>Naamvak</h3></th>
              //            <th><h3>verwijderd</h3></th>
              //            <th><a href="vakkentoevoegen.html" class="addbutton">toevoegen</a></th>
              //           </tr>';
              //
              //   while ($row = $result2->fetch_assoc()) {
              //     if ($row["archive"] == "1") {$archive = "yes";}
              //     else {$archive = "no";}
              //
              //     if ($row["schoolyear"] == "1") {$schoolyear = "2021/2022";}
              //     else if ($row["schoolyear"] == "1") {$schoolyear = "2022/2023";}
              //     else if ($row["schoolyear"] == "1") {$schoolyear = "2023/2024";}
              //     else if ($row["schoolyear"] == "1") {$schoolyear = "2024/2025";}
              //     else if ($row["schoolyear"] == "1") {$schoolyear = "2025/2026";}
              //     else if ($row["schoolyear"] == "1") {$schoolyear = "2026/2027";}
              //     else if ($row["schoolyear"] == "1") {$schoolyear = "2027/2028";}
              //
              //     $text = $text . '<tr><td>'.$schoolyear.'</td><td>'.$row["namethemep1"].'</td><td>'.$row["namethemep2"].'</td><td>'.$row["namethemep3"].'</td><td>'.$row["namethemep4"].'</td><td>'.$row["namethemep5"].'</td><td>'.$archive.'</td><td hidden>'.$row["themeid"].'</td><td><a href="useraanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
              //   }
              //
              //   echo $text = $text . "</table>";
              // } else { // no users found
              //   echo "NOK1";
              // }
              echo "NOK";
            } elseif ($row['role'] == 2) { // super user
              $sql3 = "SELECT d.*
                      FROM disciplines as d
                      WHERE d.archive<>'1'";
              $result3 = $conn->query($sql3);

              if ($result3 !== false && $result3 -> num_rows > 0) {
                $text = '<table class="beewaylijsttable">
                        <tr>
                        <th><h3>Naamvak</h3></th>
                        <th><h3>verwijderd</h3></th>
                        <th><a href="vakkentoevoegen.html" class="addbutton">toevoegen</a></th>
                        </tr>';

                while ($row = $result3->fetch_assoc()) {
                  if ($row["archive"] == "1") {$archive = "yes";}
                  else {$archive = "no";}

                  $text = $text . '<tr><td>'.$row['disciplinename'].'</td><td>'.$archive.'</td><td hidden>'.$row["disciplineid"].'</td><td><a href="vakkenaanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
                }

                echo $text = $text . "</table>";
              } else { // no users found
                echo "NOK1";
              }
            } else { // no valid user found
              echo "NOK";
            }
          }
        } else { // no valid token found
          echo "NOK";
        }

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK!";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK!";
      } else {
        echo "NOK?";
      }
  }



  if (isset($_POST['AllMainthemes'])) // get data for mainthemes table (super user and school admin only)
  {
      $json = $_POST['AllMainthemes'];
      $json = json_decode($json, true);
      $token = $json['Token'];


      $sessionvalid = SessionCheck($conn, $token); // session check

        if ($sessionvalid == "OK") { // session OK
          $sql1 = "SELECT u.role, u.schoolid
                  FROM session as s, users as u
                  WHERE s.token=?
                  AND u.userid=s.userid
                  AND u.role<>'0'
                  AND u.archive<>'1'";
          $stmt1 = $conn->prepare($sql1);
          $stmt1->bind_param("s", $token);
          $stmt1->execute();
          $result1 = $stmt1->get_result();

          if ($result1 !== false && $result1 -> num_rows > 0) {
            if ($row = $result1->fetch_assoc()) {
              $schoolid = $row['schoolid'];

              if ($row['role'] == 1) { // school admin
                $sql2 = "SELECT m.*
                        FROM maintheme as m
                        WHERE m.schoolid=?
                        AND m.schoolid<>'0'
                        AND m.archive<>'1'";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("s", $schoolid);
                $stmt2->execute();
                $result2 = $stmt2->get_result();

                if ($result2 !== false && $result2 -> num_rows > 0) {
                  $text = '<table class="beewaylijsttable">
                          <tr>
                            <th><h3>Schooljaar</h3></th>
                            <th><h3>Periode 1</h3></th>
                            <th><h3>Periode 2</h3></th>
                            <th><h3>Periode 3</h3></th>
                            <th><h3>Periode 4</h3></th>
                            <th><h3>Periode 5</h3></th>
                            <th><h3>verwijderd</h3></th>
                            <th><a href="hoofdthematoevoegen.html" class="addbutton">toevoegen</a></th>
                          </tr>';

                  while ($row = $result2->fetch_assoc()) {
                    if ($row["archive"] == "1") {$archive = "yes";}
                    else {$archive = "no";}

                    if ($row["schoolyear"] == "1") {$schoolyear = "2021/2022";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2022/2023";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2023/2024";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2024/2025";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2025/2026";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2026/2027";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2027/2028";}

                    $text = $text . '<tr><td>'.$schoolyear.'</td><td>'.$row["namethemep1"].'</td><td>'.$row["namethemep2"].'</td><td>'.$row["namethemep3"].'</td><td>'.$row["namethemep4"].'</td><td>'.$row["namethemep5"].'</td><td>'.$archive.'</td><td hidden>'.$row["themeid"].'</td><td><a href="hoofdthemaaanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
                  }

                  echo $text = $text . "</table>";
                } else { // no users found
                  echo "NOK1";
                }
              } elseif ($row['role'] == 2) { // super user
                $sql3 = "SELECT m.*, s.schoolname
                        FROM maintheme as m, schools as s
                        WHERE m.schoolid=s.schoolid
                        AND m.schoolid<>'0'
                        AND m.archive<>'1'";
                $result3 = $conn->query($sql3);

                if ($result3 !== false && $result3 -> num_rows > 0) {
                  $text = '<table class="beewaylijsttable">
                          <tr>
                            <th><h3>Schooljaar</h3></th>
                            <th><h3>Periode 1</h3></th>
                            <th><h3>Periode 2</h3></th>
                            <th><h3>Periode 3</h3></th>
                            <th><h3>Periode 4</h3></th>
                            <th><h3>Periode 5</h3></th>
                            <th><h3>verwijderd</h3></th>
                            <th><a href="hoofdthematoevoegen.html" class="addbutton">toevoegen</a></th>
                          </tr>';

                  while ($row = $result3->fetch_assoc()) {
                    if ($row["archive"] == "1") {$archive = "yes";}
                    else {$archive = "no";}

                    if ($row["schoolname"] == "") {$schoolname = "<em>(geen)</em>";}
                    else {$schoolname = $row["schoolname"];}

                    if ($row["schoolyear"] == "1") {$schoolyear = "2021/2022";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2022/2023";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2023/2024";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2024/2025";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2025/2026";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2026/2027";}
                    else if ($row["schoolyear"] == "1") {$schoolyear = "2027/2028";}

                    $text = $text . '<tr><td>'.$row['schoolname'].'</td><td>'.$schoolyear.'</td><td>'.$row["namethemep1"].'</td><td>'.$row["namethemep2"].'</td><td>'.$row["namethemep3"].'</td><td>'.$row["namethemep4"].'</td><td>'.$row["namethemep5"].'</td><td>'.$archive.'</td><td hidden>'.$row["themeid"].'</td><td><a href="useraanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
                  }

                  echo $text = $text . "</table>";
                } else { // no users found
                  echo "NOK1";
                }
              } else { // no valid user found
                echo "NOK";
              }
            }
          } else { // no valid token found
            echo "NOK";
          }
      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK!";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK!";
      } else {
        echo "NOK?";
      }
  }



  if (isset($_POST['AllUsers'])) // get data for user table (school admins and super users only)
  {
      $json = $_POST['AllUsers'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "OK") { // session OK
        $sql1 = "SELECT u.role, u.schoolid
                FROM session as s, users as u
                WHERE s.token=?
                AND u.userid=s.userid
                AND u.role<>'0'
                AND u.archive<>'1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if ($result1 !== false && $result1 -> num_rows > 0) {
          if ($row = $result1->fetch_assoc()) {
            $schoolid = $row['schoolid'];

            if ($row['role'] == 1) { // school admin
              $sql2 = "SELECT u.*, s.schoolname
                      FROM users as u, schools as s
                      WHERE u.schoolid=?
                      AND s.schoolid=u.schoolid
                      AND u.schoolid<>'0'
                      AND u.archive<>'1'";
              $stmt2 = $conn->prepare($sql2);
              $stmt2->bind_param("s", $schoolid);
              $stmt2->execute();
              $result2 = $stmt2->get_result();

              if ($result2 !== false && $result2 -> num_rows > 0) {
                $text = '<table class="beewaylijsttable">
                        <tr>
                          <th><h3>School</h3></th>
                          <th><h3>Naam</h3></th>
                          <th><h3>Email</h3></th>
                          <th><h3>Rol</h3></th>
                          <th><h3>geblokkeerd/verwijderd</h3></th>
                          <th><a href="usertoevoegen.html" class="addbutton">toevoegen</a></th>
                        </tr>';

                while ($row = $result2->fetch_assoc()) {
                  if ($row["role"] == "0") {$rol = "docent";}
                  else if ($row["role"] == "1") {$rol = "school admin";}
                  else {$rol = "super user";}

                  if ($row["archive"] == "1") {$archive = "yes";}
                  else {$archive = "no";}

                  if ($row["schoolname"] == "") {$schoolname = "<em>(geen)</em>";}
                  else {$schoolname = $row["schoolname"];}

                  $text = $text . '<tr><td>'.$schoolname.'</td><td>'.$row["firstname"].' '.$row["lastname"].'</td><td>'.$row["email"].'</td><td>'.$rol.'</td><td>'.$archive.'</td><td hidden>'.$row["userid"].'</td><td><a href="useraanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
                }

                echo $text = $text . "</table>";
              } else { // no users found
                echo "NOK1";
              }
            } elseif ($row['role'] == 2) { // super user
              $sql3 = "SELECT u.*, s.schoolname
                      FROM users as u, schools as s
                      WHERE s.schoolid=u.schoolid";
              $result3 = $conn->query($sql3);

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
                  if ($row["role"] == "0") {$rol = "docent";}
                  else if ($row["role"] == "1") {$rol = "school admin";}
                  else {$rol = "super user";}

                  if ($row["archive"] == "1") {$archive = "yes";}
                  else {$archive = "no";}

                  if ($row["schoolname"] == "") {$schoolname = "<em>(geen)</em>";}
                  else {$schoolname = $row["schoolname"];}

                  $text = $text . '<tr><td>'.$schoolname.'</td><td>'.$row["firstname"].' '.$row["lastname"].'</td><td>'.$row["email"].'</td><td>'.$rol.'</td><td>'.$archive.'</td><td hidden>'.$row["userid"].'</td><td><a href="useraanpassen.html" class="editbutton edituser">bewerken</a></td></tr>';
                }

                echo $text = $text . "</table>";
              } else { // no users found
                echo "NOK1";
              }
            } else { // no valid user found
              echo "NOK";
            }
          }
        } else { // no valid token found
          echo "NOK";
        }
      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK!";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK!";
      } else {
        echo "NOK?";
      }
  }



  if (isset($_POST['AllSchools'])) // get data for school table (super user only)
  {
      $json = $_POST['AllSchools'];
      $json = json_decode($json, true);
      $token = $json['Token'];

      $sessionvalid = SessionCheck($conn, $token); // session check

      if ($sessionvalid == "OK") { // session OK
        $sql1 = "SELECT u.role
                FROM session as s, users as u
                WHERE s.token=?
                AND u.userid=s.userid
                AND u.role='2'
                AND u.archive<>'1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if ($result1 !== false && $result1 -> num_rows > 0) {
          while ($row = $result1->fetch_assoc()) {
            $rol = $row['role'];

            if ($rol == 2) { // super user
              $sql2 = "SELECT s.*
                      FROM schools as s
                      WHERE schoolid<>0";
              $result2 = $conn->query($sql2);

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

                  $text = $text . '<tr><td>'.$row["schoolname"].'</td><td>'.$archive.'</td><td><a href="schoolaanpassen.html" class="editbutton">users bekijken</a></td><td><a href="schoolaanpassen.html" class="editbutton">bewerken</a></td></tr>';
                }

                echo $text = $text . "</table>";
              } else {
                echo "NOK1"; // no schools found
              }
            } else { // no valid user found
              echo "NOK!";
            }
          }
        } else { // no valid user found
          echo "NOK";
        }

      } elseif ($sessionvalid == "NOK1") { // session expierd
        echo "NOK!";
      } elseif ($sessionvalid == "NOK2") { // session not found
        echo "NOK!";
      } else {
        echo "NOK?";
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




  function SetSession($conn, $userid) { // set a session when user logs in
      $number = generateRandomNumber();
      $token = RandomString($number);

      $now = new datetime();

      if (isset($rememberme)) {
        $now->modify('+7 day');
      } else {
        $now->modify('+1 hour');
      }

      $dt = strtotime($now->format('y-m-d h:i:s'));

      $sql = "INSERT INTO session (stmp, token, userid) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $dt, $token, $userid);
      $stmt->execute();
      $result = $stmt->get_result();

      return $token;
  }


  function RandomString($length) { // set random string
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $string = '';

      for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
      }

      return $string;
  }

  function generateRandomNumber() { // Generate a random number between 50 and 100
    $randomNumber = rand(80, 100);
    return $randomNumber;
  }

  function SessionCheck($conn, $token) { // set a user session in the database
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
