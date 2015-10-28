<?php

    require 'config.php';

    $data = array(
      "response"=>"OK",
      "server_name"=>$servername
    );

    $conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);


    if(!(isset($_GET["scenes"]) && isset($_GET["values"]))){
        die("uhh you didn't tell me anything to change");
    }

    $scenesFromURL = explode(',',$_GET["scenes"]);
    $valuesFromURL = explode(',',$_GET["values"]);
    $senddata = array();
    $senddata = array_pad($senddata, 24, "d");
    $cmd = "./senddata.py";


    if($conn->connect_errno > 0){
      die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    $scenes = array();
    $ids  = $scenesFromURL;
    $sql  = "SELECT * FROM `scenes` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    for ($i = 0; $i < count($ids); $i++)
    {
        $stmt->bind_param("i", $ids[$i]);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
          array_push($scenes, array("id"=>$row["id"],"name"=>$row["name"],"channels"=>array($row["chan1"],$row["chan2"],$row["chan3"],$row["chan4"],$row["chan5"],$row["chan6"],$row["chan7"],$row["chan8"],$row["chan9"],$row["chan10"],$row["chan11"],$row["chan12"],$row["chan13"],$row["chan14"],$row["chan15"],$row["chan16"],$row["chan17"],$row["chan18"],$row["chan19"],$row["chan20"],$row["chan21"],$row["chan22"],$row["chan23"],$row["chan24"])));
        }
    }
    $stmt->close();
    // End of data getting, closing the query

    for($i=0;$i<count($scenes);$i++){

        if(!isset($scenes[$i])){
          die("uhh undefined scene name");
        }

        $channels=$scenes[$i]["channels"];
        for($n=0;$n<count($channels);$n++){
            $chan = $channels[$n];
            if($chan != NULL){
                if(!isset($valuesFromURL[$i])){
                    die("uhh undefined value");
                }
                $lightValue = $valuesFromURL[$i]*$chan*0.01;
                $senddata[$n] = $lightValue;
            }

        }
    }

    foreach($senddata as $i){
        if($senddata == NULL){
          $cmd = $cmd." d";
        }else{
          $cmd = $cmd." ".$i;
        }
    }
    if(isset($_GET["fade"])){
        $fade = $_GET["fade"];
        if($fade > 0){
            $cmd = $cmd." -f ".$fade;
        }
    }

    exec("$cmd 2>&1", $output);

    //exec("bash -c 'exec nohup setsid $cmd > /dev/null 2>&1 &'");
    echo $cmd;
    print_r($output);

    $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
    $date = date('m/d/Y h:i:s a', time());
    $txt = $date." ".$cmd."\n";
    fwrite($myfile, $txt);
    fclose($myfile);
    echo $date;
    //echo $output;
?>
