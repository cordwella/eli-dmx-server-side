<?php
    // Here goes all the code about adding and editing scenes
    // path: data= (list of numbers representing the thing in percentaged)
    // optional parameters: id (for changing an already created scene)
    // category ID (or category (give options for both))

    require 'config.php';

    $data = array(
      "response"=>"OK",
      "server_name"=>$servername
    );

    $conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if($conn->connect_errno > 0){
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    if(isset($_GET['id'])){
        // Ugh this may take a while
        // Like a number of possibly unprepared statements
        // or would it be simpler to get the data and then use some of the same ideas as with the actual lights
        // yeah probably as that would allow for better blah security
        // Reminder you started the IDs from 1, loser
        $id  = $_GET["id"];
        $sql  = "SELECT * FROM `scenes` WHERE id = ?";

        if(isset($_GET["name"])){
            $name =$_GET["name"];
            $sql  = "UPDATE `scenes` SET name=? WHERE id = ?";
            if(!$stmt = $conn->prepare($sql)){
                die("Issue preparing statement");
            }
            $stmt->bind_param("si", $name, $id);
            $stmt->execute();
            $stmt->close();
        }
        if(isset($_GET["channels"])){
            $channelsFromURL = explode(',',$_GET["channels"]);
            $channels =array();
            foreach($channelsFromURL as $channel){
                if(is_numeric($channel)){
                    array_push($channels, $channel);
                }else{
                    array_push($channels, NULL);
                }
            }
            $sql  = "UPDATE `scenes` SET chan1=?, chan2=?, chan3=?, chan4=?, chan5=?, chan6=?, chan7=?, chan8=?, chan9=?, chan10=?, chan11=?, chan12=?, chan13=?, chan14=?, chan15=?, chan16=?, chan17=?, chan18=?, chan19=?, chan20=?, chan21=?, chan22=?, chan23=?, chan24=?  WHERE id = ?";
            $stmt = $conn->prepare($sql);
            // say SIIIIIIIIIIIIIIIIIIIIII out loud. I dare you.
            $stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiii", $channels[0], $channels[1], $channels[2], $channels[3], $channels[4], $channels[5], $channels[6], $channels[7], $channels[8], $channels[9], $channels[10], $channels[11], $channels[12], $channels[13], $channels[14], $channels[15], $channels[16], $channels[17], $channels[18], $channels[19], $channels[20], $channels[21], $channels[22], $channels[23], $id);
            $stmt->execute();
            $stmt->close();
        }
        if(isset($_GET["category"])){
            $category = $_GET["category"];
            $sql  = "UPDATE `scenes` SET category_id=? WHERE id = ?";
            if(!$stmt = $conn->prepare($sql)){
                die("Issue preparing statement");
            }
            $stmt->bind_param("si", $category, $id);
            $stmt->execute();
            $stmt->close();
        }
        //$sql = "UPDATE `scenes` SET chan1=?, column2=value2,.. WHERE id=?";

    }else{
        if(!isset($_GET["name"])){
            die("uhh didn't get a scene name out of you");
        }

        $name = $_GET["name"];
    	$channelsFromURL = explode(',',$_GET["channels"]);
    	$channels =array();
    	foreach($channelsFromURL as $channel){
    		if(is_numeric($channel)){
    		    array_push($channels, $channel);
    		}else{
    		    array_push($channels, NULL);
    		}
    	}

        $categoryid = NULL;

        if(isset($_GET["category"])){
            $categoryid = $_GET["category"];
        }

        $sql  = "INSERT INTO `lightsdb`.`scenes` (`id`, `name`, `category_id`, `chan1`, `chan2`, `chan3`, `chan4`, `chan5`, `chan6`, `chan7`, `chan8`, `chan9`, `chan10`, `chan11`, `chan12`, `chan13`, `chan14`, `chan15`, `chan16`, `chan17`, `chan18`, `chan19`, `chan20`, `chan21`, `chan22`, `chan23`, `chan24`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        // say SIIIIIIIIIIIIIIIIIIIIII out loud. I dare you.
        $stmt->bind_param("siiiiiiiiiiiiiiiiiiiiiiiii", $name, $categoryid, $channels[0], $channels[1], $channels[2], $channels[3], $channels[4], $channels[5], $channels[6], $channels[7], $channels[8], $channels[9], $channels[10], $channels[11], $channels[12], $channels[13], $channels[14], $channels[15], $channels[16], $channels[17], $channels[18], $channels[19], $channels[20], $channels[21], $channels[22], $channels[23]);
        $stmt->execute();
        $stmt->close();


        //;

    }
    echo json_encode($data);

?>
