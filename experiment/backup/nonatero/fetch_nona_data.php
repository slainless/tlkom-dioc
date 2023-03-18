<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
  require $p_svropt;
  
  require $p_inc . "database/fetch_setting.php";
  
  $nona_login = curl_init(); 
  curl_setopt ($nona_login, CURLOPT_URL, $nona_llink); 
  curl_setopt ($nona_login, CURLOPT_SSL_VERIFYPEER, FALSE); 
  curl_setopt ($nona_login, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
  curl_setopt ($nona_login, CURLOPT_TIMEOUT, 20); 
  curl_setopt ($nona_login, CURLOPT_FOLLOWLOCATION, 0); 
  curl_setopt ($nona_login, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt ($nona_login, CURLOPT_COOKIEJAR, $p_cookies);
  curl_setopt ($nona_login, CURLOPT_COOKIEFILE, $p_cookies); 
  curl_setopt ($nona_login, CURLOPT_REFERER, $nona_llink); 

  curl_setopt ($nona_login, CURLOPT_POSTFIELDS, $nona_lpost); 
  curl_setopt ($nona_login, CURLOPT_POST, 1); 
  $nona_login_result = curl_exec ($nona_login);
  
  $login_check = substr($nona_login_result,0,10);
  
  if (strpos($nona_login_result, '[ NONATERO ]') !== false)
  {
    echo "login success!<br>";
  }
  else
  {
    echo "ERROR : login failed, terminate process";
    exit;
  }
  
  curl_close($nona_login);
  
  $nona_fetch = curl_init(); 
  curl_setopt ($nona_fetch, CURLOPT_URL, $nona_flink); 
  curl_setopt ($nona_fetch, CURLOPT_SSL_VERIFYPEER, FALSE); 
  curl_setopt ($nona_fetch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
  curl_setopt ($nona_fetch, CURLOPT_TIMEOUT, 60); 
  curl_setopt ($nona_fetch, CURLOPT_FOLLOWLOCATION, 0); 
  curl_setopt ($nona_fetch, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt ($nona_fetch, CURLOPT_COOKIEJAR, $p_cookies);
  curl_setopt ($nona_fetch, CURLOPT_COOKIEFILE, $p_cookies); 
  curl_setopt ($nona_fetch, CURLOPT_REFERER, $nona_flink); 

  curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fpost); 
  curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
  $nona_fetch_result = curl_exec ($nona_fetch); 

  $check_result = substr($nona_fetch_result, 0, 4);
  if($check_result != "CONN")
  {
    echo "ERROR : invalid data received, terminate process";
    exit;
  }
  else
  {
    echo "fetch success!<br>";
    if(file_put_contents($p_nonadata, $nona_fetch_result, LOCK_EX))
    {
      echo "file saved successfully!<br>";
    }
    else
    {
      echo "file save failed.<br>";
    }
  }