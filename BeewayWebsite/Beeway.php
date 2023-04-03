<?php
  header("Access-Control-Allow-Origin: *");
  header('Access-Control-Allow-Methods: POST GET');
  require ("./dbconnect.php");

  if (isset($_POST['Test']))
  {

    $json = $_POST['Test'];
    $json = json_decode($json, true);

    $name = $json['Name'];
    $pwd = $json['Pwd'];

    echo $name . "  " . $pwd;
  }


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


  if (isset($_POST['SelectName']))
  {
    $sql = "SELECT * FROM nameoptiens";
    $result = $conn->query($sql);

    if ($result !== false && $result -> num_rows > 0)
    {
      $text = "";

      while ($row = $result->fetch_assoc())
      {
        $text = $text . '<option value="'.$row['Id'].'">'.$row['Name'].'</option>';
      }
      echo $text;
    }
    else
    {
      echo "NOK";
    }
  }



?>
