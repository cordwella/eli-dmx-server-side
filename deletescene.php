<?php

    // This one is simple
    // Get a scene ID and then deletes us
    // This should require high level priveleges when I get around to that.
    $scenesFromURL = explode(',',$_GET["scenes"]);
    // GET ME THAT HOT DATA
    $conn = new mysqli('localhost', 'root', '', 'lightsdb');

    if($conn->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $sql = 'DELETE FROM `scenes` WHERE id = ?';
    $stmt = $conn->prepare($sql);
    for ($i = 0; $i < count($scenesFromURL); $i++)
    {
        $stmt->bind_param("i", $scenesFromURL[$i]);
        $stmt->execute();
    }
    $stmt->close();
    $conn->close();

    $data = array(
        "response"=>"OK",
        "server_name"=>"WEGC",
    );

?>
