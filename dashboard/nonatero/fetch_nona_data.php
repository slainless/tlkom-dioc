<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_incl."function/fetch_setting.php";

    if(!isset($close)){
        $close = false;
    }

    if(!isset($loginf)){
        $loginf = false;
    }

if(!isset($c_text) && !$close):
    $c_text = "# FETCH DATA NONATERO<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# FETCH DATA NONATERO<br>--------------------</br>";
endif;

if(!$close && !$loginf):
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
        if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOGIN TO \"" . $nona_llink . "\"" . "<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] LOGIN TO WEBSITE" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR  ] LOGIN TO \"" . $nona_llink . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }

    curl_close($nona_login);
endif;

if(!$close):
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
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"NONATERO\", PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING LATEST \"NONATERO\" DATA" . "<br>";
        endif;

        if(file_put_contents($p_nonadata, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_save_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING LATEST DATA" . "<br>";
            $c_text = $c_text . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_save_n . "\"" . ", PROCESS TERMINATED...";
            $close = true;
        }
    }

    curl_close($nona_fetch);
endif;