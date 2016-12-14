<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  
  require 'db_account.php';
  // $data = json_decode(file_get_contents("php://input"));
  // $toFind = mysql_real_escape_string($data->toFind);
  // $toFind = 'mangmanganen';
  $toFind = 'mangmanumganen';
  $result = $conn->query("SELECT * FROM `affix-tble` ORDER BY `infix`");
  $infixArray = array();
  $rootWord = "";
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    //print_r($rs);
    $patterns = array();
    $patterns[0] = "/^".$rs['prefix']."/";
    $patterns[1] = "/".$rs['suffix']."$/";
    $notFound = true;
    if($rs['infix'] == ""){
      if(preg_match("/^".$rs['prefix'].".*".$rs['suffix']."/i", $toFind)){
        $rootWord = preg_replace($patterns, "", $toFind);
        $result2 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
        if($rs2 = $result2->fetch_array(MYSQLI_ASSOC)){
          echo '["'.$toFind.'","'.$rootWord.'",';
          $result3 = $conn->query(
            "SELECT `pos` FROM `pos-tble` WHERE `dictionary-id` = '"
            .$rs2['id']
            ."' AND `prefix` = '"
            .$rs['prefix']
            ."' AND `suffix` = '"
            .$rs['suffix']
            ."' AND `infix` = ''"
          );
          if($rs3 = $result3->fetch_array(MYSQLI_ASSOC)){
            echo '"'.$rs3['pos'].'"]';
          }else{
            echo '"U"]';
          }
          $notFound = false;
          break;
        }
      }
    }else{
      array_push($infixArray,$rs);
    }
  }
  if($notFound){
    foreach($infixArray as $x){
      if($rootWord == ""){
        if(preg_match("/.".$x['infix']."./i", $toFind)){
          $rootWord = preg_replace("/".$x['infix']."/i", "", $toFind);
          
          $result2 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
          if($rs2 = $result2->fetch_array(MYSQLI_ASSOC)){
            echo '["'.$toFind.'","'.$rootWord.'",';
            $result3 = $conn->query(
              "SELECT `pos` FROM `pos-tble` WHERE `dictionary-id` = '"
              .$rs2['id']
              ."' AND `prefix` = '' AND `suffix` = '' AND `infix` = '"
              .$x['infix']
              ."'"
            );
            if($rs3 = $result3->fetch_array(MYSQLI_ASSOC)){
              echo '"'.$rs3['pos'].'"]';
            }else{
              echo '"U"]';
            }
            break;
          }
        }
      }else{
        if(preg_match("/.".$x['infix']."./i", $rootWord)){
          $rootWord = preg_replace("/".$x['infix']."/i", "", $rootWord);
          
          $result2 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
          if($rs2 = $result2->fetch_array(MYSQLI_ASSOC)){
            echo '["'.$toFind.'","'.$rootWord.'",';
            $result3 = $conn->query(
              "SELECT `pos` FROM `pos-tble` WHERE `dictionary-id` = '"
              .$rs2['id']
              ."' AND `prefix` = '"
              .$x['prefix']
              ."' AND `suffix` = '"
              .$x['suffix']
              ."' AND `infix` = '"
              .$x['infix']
              ."'"
            );
            if($rs3 = $result3->fetch_array(MYSQLI_ASSOC)){
              echo '"'.$rs3['pos'].'"]';
            }else{
              echo '"U"]';
            }
            break;
          }
        }
      }
    }
  }
 
  
  $conn->close();

  #echo(json_encode($collocateList));
?>