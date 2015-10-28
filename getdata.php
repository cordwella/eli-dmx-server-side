
<?php
    require 'config.php';

    $data = array(
      "response"=>"OK",
      "server_name"=>$servername
    );

    $conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    $scenes = array();
    $channels = array();

    if($conn->connect_errno > 0){
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    if(!isset($_GET["scene"])){
      // No user helping here so no prepared statements
      $sql='SELECT s.id, s.name, c.category FROM `scenes` AS s INNER JOIN `categories` AS c on s.category_id = c.id_cat';

      if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
      }
      while($row = $result->fetch_assoc()){
        array_push($scenes, array("id"=>$row["id"],"name"=>$row["name"],"category"=>$row["category"]));
      }

      $data["scenes"] = $scenes;

   }else{
      $scene = array();
      // Reminder you started the IDs from 1, loser
      $test  = $_GET["scene"];
      $sql  = "SELECT * FROM `scenes` AS s INNER JOIN `categories` AS c on s.category_id = c.id_cat WHERE s.id = ?";

      if(!$stmt = $conn->prepare($sql)){
          die('There was an error running the query [' . $conn->error . ']');
      }
      $stmt->bind_param("i", $test);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      array_push($scene, array("id"=>$row["id"],"name"=>$row["name"],"category"=>$row["category"],"channels"=>array($row["chan1"],$row["chan2"],$row["chan3"],$row["chan4"],$row["chan5"],$row["chan6"],$row["chan7"],$row["chan8"],$row["chan9"],$row["chan10"],$row["chan11"],$row["chan12"],$row["chan13"],$row["chan14"],$row["chan15"],$row["chan16"],$row["chan17"],$row["chan18"],$row["chan19"],$row["chan20"],$row["chan21"],$row["chan22"],$row["chan23"],$row["chan24"])));
      $stmt->close();
      $data["scene"] = $scene;
  }

  $sql='SELECT * FROM lights';
  if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
  }
  while($row = $result->fetch_assoc()){
    array_push($channels, array("id"=>$row["channel"],"name"=>$row["name"],"category"=>"Light"));
  }

  $data["channels"] = $channels;

  $categories = array();
  $sql='SELECT * FROM `categories`';

  if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
  }

  while($row = $result->fetch_assoc()){
    array_push($categories, array("id"=>$row["id_cat"],"name"=>$row["category"]));
  }
  $conn->close();
  $data["categories"]=$categories;

  echo json_encode($data);
?>
