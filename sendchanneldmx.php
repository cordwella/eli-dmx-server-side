<?php

    if(!(isset($_GET["channels"]) && isset($_GET["values"]))){
        die("uhh you didn't tell me anything to change");
    }

    $channelsFromURL = explode(',',$_GET["channels"]);
    $valuesFromURL = explode(',',$_GET["values"]);
    $data = array();
    $data = array_pad($data, 24, "d");
    $cmd = "./senddata.py";

    for($i = 0; $i<count($channelsFromURL);$i++){
        if(!isset($valuesFromURL[$i])){
            die("uhh undefined value");
        }
        $lightNo = $channelsFromURL[$i];
        $data[$lightNo-1] = $valuesFromURL[$i];
    }


    foreach($data as $i){
        if($data == NULL){
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

    //$output=exec($cmd);
    exec("bash -c 'exec nohup setsid $cmd > /dev/null 2>&1 &'");

    echo $cmd;
    /*$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
    $date = date('m/d/Y h:i:s a', time());
    $txt = $date." ".$cmd."\n";
    fwrite($myfile, $txt);
    fclose($myfile);
    echo $date;
*/
    //echo $output;

?>
