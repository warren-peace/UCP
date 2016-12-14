<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  
  require 'db_account.php';
  $data = json_decode(file_get_contents("php://input"));
  $toFind = mysql_real_escape_string($data->toFind);
  // $toFind = 'mangmangan';
  // $toFind = 'mangmanganen';
  // $toFind = 'mangmanumganen';
  $rootWord = "";
  $toEcho = array();
  $infixArray = array();
  
  // see if it is already a root word
  $result1 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$toFind."'");
  if($rs1 = $result1->fetch_array(MYSQLI_ASSOC)){
    array_push($toEcho,$toFind,$toFind);
    $result3 = $conn->query(
      "SELECT `pos` FROM `pos-tble` WHERE `dictionary-id` = '"
      .$rs1['id']
      ."' AND `prefix` = '' AND `suffix` = '' AND `infix` = ''"
    );
    if($rs3 = $result3->fetch_array(MYSQLI_ASSOC)){
      //$toEcho .= '"'.$rs3['pos'].'"]';
      array_push($toEcho,$rs3['pos']);
      echo json_encode($toEcho);
    }else{
      // $toEcho .= '"U"]';
      array_push($toEcho,"U");
      echo json_encode($toEcho);
    }
    $notFound = false;
  }else{
  
    $result = $conn->query("SELECT * FROM `affix-tble` ORDER BY `infix`");
    while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
      //print_r($rs);
      $toEcho = array();
      $patterns = array();
      $notFound = true;
      $pMatch = "";
      if($rs['infix'] == ""){
        
        if($rs['prefix'] == ""){
          $patterns[0] = "/".$rs['suffix']."$/";
          $pMatch = "/^.*".$rs['suffix']."/i";
        }elseif($rs['suffix'] == ""){
          $patterns[0] = "/^".$rs['prefix']."/";
          $pMatch = "/^".$rs['prefix'].".*$/i";
        }else{
          $patterns[0] = "/^".$rs['prefix']."/";
          $patterns[1] = "/".$rs['suffix']."$/";
          $pMatch = "/^".$rs['prefix'].".*".$rs['suffix']."$/i";
        }
        if(preg_match($pMatch, $toFind)){
          $rootWord = preg_replace($patterns, "", $toFind);
          $result2 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
          if($rs2 = $result2->fetch_array(MYSQLI_ASSOC)){
            //$toEcho .= '["'.$toFind.'","'.$rootWord.'",';
            array_push($toEcho,$toFind,$rootWord);
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
              //$toEcho .= '"'.$rs3['pos'].'"]';
              array_push($toEcho,$rs3['pos']);
              echo json_encode($toEcho);
            }else{
              // $toEcho .= '"U"]';
              array_push($toEcho,"U");
              echo json_encode($toEcho);
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
        $toEcho = array();
        if($rootWord == ""){
          if(preg_match("/.".$x['infix']."./i", $toFind)){
            $rootWord = preg_replace("/".$x['infix']."/i", "", $toFind);
            
            $result2 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
            if($rs2 = $result2->fetch_array(MYSQLI_ASSOC)){
              // $toEcho .= '["'.$toFind.'","'.$rootWord.'",';
              array_push($toEcho,$toFind,$rootWord);
              $result3 = $conn->query(
                "SELECT `pos` FROM `pos-tble` WHERE `dictionary-id` = '"
                .$rs2['id']
                ."' AND `prefix` = '' AND `suffix` = '' AND `infix` = '"
                .$x['infix']
                ."'"
              );
              if($rs3 = $result3->fetch_array(MYSQLI_ASSOC)){
                // $toEcho .= '"'.$rs3['pos'].'"]';
                array_push($toEcho,$rs3['pos']);
                echo json_encode($toEcho);
              }else{
                // $toEcho .= '"U"]';
                array_push($toEcho,"U");
                echo json_encode($toEcho);
              }
              $notFound = false;
              break;
            }
          }
        }else{
          if(preg_match("/.".$x['infix']."./i", $rootWord)){
            $rootWord = preg_replace("/".$x['infix']."/i", "", $rootWord);
            
            $result2 = $conn->query("SELECT `id` FROM `dictionary-tble` WHERE `name` = '".$rootWord."'");
            if($rs2 = $result2->fetch_array(MYSQLI_ASSOC)){
              // $toEcho .= '["'.$toFind.'","'.$rootWord.'",';
              array_push($toEcho,$toFind,$rootWord);
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
                // $toEcho .= '"'.$rs3['pos'].'"]';
                array_push($toEcho,$rs3['pos']);
                echo json_encode($toEcho);
              }else{
                // $toEcho .= '"U"]';
                array_push($toEcho,"U");
                echo json_encode($toEcho);
              }
              $notFound = false;
              break;
            }
          }
        }
      }
    }
  }
  if($notFound){
    echo json_encode(array($toFind,"",""));
  }

  $conn->close();
?>