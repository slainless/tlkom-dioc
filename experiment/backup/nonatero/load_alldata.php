<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
  require $p_svropt;
  require $p_cnona;
  
  require $p_inc . "database/fetch_setting.php";

  if(!file_exists($p_nonadata))
  {
    echo ("ERROR : data not exist, terminate process");
    exit;
  }
  
  $check_result = substr(file_get_contents($p_nonadata), 0, 4);
  if($check_result != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit;
  }
  
  $pro_1 = "REPLACE INTO " . $t_nona_h . " SELECT * FROM " . $t_nona . "";
  if (mysqli_query($que_nona, $pro_1)) // replace nonatero > history
  {
    echo "SUCCESS, QUERY -> REPLACE nonatero INTO history<br>";
  }
  else
  {
    echo "ERROR, QUERY -> REPLACE nonatero INTO history<br>";
  } 
  
  $pro_2 = "TRUNCATE TABLE " . $t_nona . "";
  if (mysqli_query($que_nona, $pro_2)) // truncate nonatero
  {
    echo "SUCCESS, QUERY -> TRUNCATE nonatero<br>";
  }
  else
  {
    echo "ERROR, QUERY -> TRUNCATE nonatero<br>";
  } 

  $pro_3 = "
  LOAD DATA INFILE '" . $p_nonadata . "'
  INTO TABLE " . $t_nona . "
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES";
  if (mysqli_query($que_nona, $pro_3)) // load from alldata to nonatero
  {
    echo "SUCCESS, QUERY -> LOAD DATA INFILE TO nonatero<br>";
  }
  else
  {
    echo "ERROR, QUERY -> LOAD DATA INFILE TO nonatero<br>";
  } 
  
  mysqli_close($que_nona);
