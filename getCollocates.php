<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  
  require 'db_account.php';
  $data = json_decode(file_get_contents("php://input"));
  $toFind = mysql_real_escape_string($data->toFind);
  $result = $conn->query("SELECT `tagged-sentence` FROM `corpus-mix-tble` WHERE `tagged-sentence` LIKE '%" .$toFind. "/%'");

  $collocateLine = array();
  $collocateList = array();
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    $tokens = explode(" ", $rs['tagged-sentence']);
    # start with third word
    for($i = 2; $i < sizeof($tokens);$i++){ 
      $temp = explode("/", $tokens[$i]);
      if($toFind == $temp[0]){
        array_push($collocateLine, explode("/", $tokens[$i-2]));
        array_push($collocateLine, explode("/", $tokens[$i-1]));
        array_push($collocateLine, $temp);
        
        array_push($collocateList, $collocateLine);
        $collocateLine = array();
      }
    }
  }
  $conn->close();

  echo(json_encode($collocateList));
?>