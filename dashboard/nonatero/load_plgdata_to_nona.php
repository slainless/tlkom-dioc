<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
  require $p_svropt;
  require $p_cnona;
  
  require $p_inc . "database/fetch_setting.php";
  $debug = false;

  if(!isset($debug)){
    $debug = false;
  }

  $process = "UPDATE " . $t_nona . ", " . $t_nona_tc . " 
  SET 
  " . $t_nona . ".TIPE_CUST = " . $t_nona_tc . ".TIPE_CUST,
  " . $t_nona . ".SLG = " . $t_nona_tc . ".SLG
  WHERE 
  " . $t_nona . ".TROUBLE_NO = " . $t_nona_tc . ".TROUBLE_NO";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona . ", " . $t_nona_hc . " 
  SET 
  " . $t_nona . ".HARDCOM = " . $t_nona_hc . ".hardcom
  WHERE 
  " . $t_nona . ".TROUBLE_NO = " . $t_nona_hc . ".TROUBLE_NO";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "
  UPDATE " . $t_nona . " 
  SET GGU = CASE 
  WHEN HARI > 3 AND HARI < 8 THEN 1 
  WHEN HARI > 7 AND HARI < 16 THEN 2 
  WHEN HARI > 15 AND HARI < 22 THEN 3 
  WHEN HARI > 21 AND HARI < 31 THEN 4 
  WHEN HARI > 30 THEN 5 
  END";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "
  UPDATE " . $t_nona . " 
  SET SLG_F = CASE 
  WHEN SLG > JAM THEN 1
  WHEN SLG < JAM THEN 0
  END";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "
  UPDATE " . $t_nona . " 
  SET INDI_F = CASE 
  WHEN CHANNEL = 'MY INDIHOME' THEN 1
  END";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona . ", " . $t_nona_rhn . " 
  SET 
  " . $t_nona . ".RHN_F = 1
  WHERE 
  " . $t_nona . ".TROUBLE_NO = " . $t_nona_rhn . ".TROUBLE_NO";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona . ", " . $t_nona_pls . " 
  SET 
  " . $t_nona . ".PLS_F = 1
  WHERE 
  " . $t_nona . ".TROUBLE_NO = " . $t_nona_pls . ".TROUBLE_NO";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  $process = "UPDATE " . $t_nona . ", " . $t_nona_odw . " 
  SET 
  " . $t_nona . ".ODW_F = 1
  WHERE 
  " . $t_nona . ".TROUBLE_NO = " . $t_nona_odw . ".TROUBLE_NO";
  if (mysqli_query($que_nona, $process)) // truncate nona tc
  {
    echo "SUCCESS, QUERY -> $process<br>";
  }
  else
  {
    echo "ERROR, QUERY -> $process, will exit now";
    exit();
  }

  mysqli_close($que_nona);

?>