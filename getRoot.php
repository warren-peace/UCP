<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  
  require 'db_account.php';
  // $data = json_decode(file_get_contents("php://input"));
  // $toFind = mysql_real_escape_string($data->toFind);
  $toFind = 'mangmanganen';
  $result = $conn->query("SELECT * FROM `affix-tble`");
  
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    //print_r($rs);
    $patterns = array();
    $patterns[0] = "/^".$rs['prefix']."/";
    $patterns[1] = "/".$rs['suffix']."$/";
    $found = false;
    if($rs['infix'] == ""){
      if (preg_match("/^".$rs['prefix'].".*".$rs['suffix']."/i", $toFind)){
        $rootWord = preg_replace($patterns, "", $toFind);
        $result2 = $conn->query("SELECT `name` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
        if($rs = $result->fetch_array(MYSQLI_ASSOC)){
          echo "boom!";
          $found = true;
        }
      }
    }
  }
  $conn->close();

  #echo(json_encode($collocateList));
?>