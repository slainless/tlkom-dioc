<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
  require $p_svropt;
  require $p_cnona;
  
  require $p_inc . "database/fetch_setting.php";

  if(!file_exists($p_nonaslv))
  {
    echo ("ERROR : $p_nonaslv not exist, terminate process. please run fetch data!");
    exit();
  }

  if(!file_exists($p_nonattn))
  {
    echo ("ERROR : $p_nonattn not exist, terminate process. please run fetch data!");
    exit();
  }

  if(!file_exists($p_nonaplt))
  {
    echo ("ERROR : $p_nonaplt not exist, terminate process. please run fetch data!");
    exit();
  }

  if(!file_exists($p_nonabsn))
  {
    echo ("ERROR : $p_nonabsn not exist, terminate process. please run fetch data!");
    exit();
  }

  if(!file_exists($p_nonaent))
  {
    echo ("ERROR : $p_nonaent not exist, terminate process. please run fetch data!");
    exit();
  }

  if(!file_exists($p_nonahc))
  {
    echo ("ERROR : $p_nonahc not exist, terminate process. please run fetch data!");
    exit();
  }
  
  if(substr(file_get_contents($p_nonaslv), 0, 4) != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit();
  }


  if(substr(file_get_contents($p_nonattn), 0, 4) != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit();
  }

  if(substr(file_get_contents($p_nonaplt), 0, 4) != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit();
  }

  if(substr(file_get_contents($p_nonabsn), 0, 4) != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit();
  }

  if(substr(file_get_contents($p_nonaent), 0, 4) != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit();
  }

  if(substr(file_get_contents($p_nonahc), 0, 4) != "CONN")
  {
    echo "ERROR : invalid file content, terminate process";
    exit();
  }  
  
  $process = "TRUNCATE TABLE " . $t_nona_tc . "";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "TRUNCATE TABLE " . $t_nona_hc . "";
  if (mysqli_query($que_nona, $process)) // truncate nona hc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  } 

  $process = "LOAD DATA INFILE '" . $p_nonaslv . "'
  INTO TABLE " . $t_nona_tc . " 
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES
  (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 1";
  if (mysqli_query($que_nona, $process)) // set load data #1 as silver
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "LOAD DATA INFILE '" . $p_nonattn . "'
  INTO TABLE " . $t_nona_tc . " 
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES
  (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

      $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 2 WHERE ID_TIPE = 0";
  if (mysqli_query($que_nona, $process)) // set load data #1 as silver
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "LOAD DATA INFILE '" . $p_nonaplt . "'
  INTO TABLE " . $t_nona_tc . " 
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES
  (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 3 WHERE ID_TIPE = 0";
  if (mysqli_query($que_nona, $process)) // set load data #1 as silver
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "LOAD DATA INFILE '" . $p_nonabsn . "'
  INTO TABLE " . $t_nona_tc . " 
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES
  (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 4 WHERE ID_TIPE = 0";
  if (mysqli_query($que_nona, $process)) // set load data #1 as silver
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "LOAD DATA INFILE '" . $p_nonaent . "'
  INTO TABLE " . $t_nona_tc . " 
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES
  (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 5 WHERE ID_TIPE = 0";
  if (mysqli_query($que_nona, $process)) // set load data #1 as silver
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "LOAD DATA INFILE '" . $p_nonahc . "'
  INTO TABLE " . $t_nona_hc . " 
  FIELDS TERMINATED BY ';' 
  OPTIONALLY ENCLOSED BY '\"'
  LINES TERMINATED BY '\n'
  IGNORE 2 LINES
  (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona_tc . " SET TIPE_CUST = CASE
  WHEN ID_TIPE = 1 THEN 'SILVER'
  WHEN ID_TIPE = 2 THEN 'TITANIUM/GOLD'
  WHEN ID_TIPE = 3 THEN 'PLATINUM'
  WHEN ID_TIPE = 4 THEN 'BUSINESS'
  WHEN ID_TIPE = 5 THEN 'ENTERPRISE'
  END";

  if (mysqli_query($que_nona, $process)) // set tipe_cust with case
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona_tc . " SET SLG = CASE
  WHEN ID_TIPE = 1 THEN '72'
  WHEN ID_TIPE = 2 THEN '48'
  WHEN ID_TIPE = 3 THEN '24'
  WHEN ID_TIPE = 4 THEN '12'
  WHEN ID_TIPE = 5 THEN '6'
  END";
  
  if (mysqli_query($que_nona, $process)) // set tipe_cust with case
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  mysqli_close($que_nona);
