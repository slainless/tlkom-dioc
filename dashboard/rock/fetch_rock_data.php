<?php
require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
require $p_svropt;

require $p_inc . "database/fetch_setting.php";

if(!isset($close)){
    $close = false;
}

if(!isset($loginf)){
    $loginf = false;
}

if(!$close && !$loginf):
    $nona_login = curl_init(); 
    curl_setopt ($nona_login, CURLOPT_URL, $rock_llink); 
    curl_setopt ($nona_login, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt ($nona_login, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
    curl_setopt ($nona_login, CURLOPT_TIMEOUT, 20); 
    curl_setopt ($nona_login, CURLOPT_FOLLOWLOCATION, 0); 
    curl_setopt ($nona_login, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt ($nona_login, CURLOPT_COOKIEJAR, $p_cookies);
    curl_setopt ($nona_login, CURLOPT_COOKIEFILE, $p_cookies); 
    curl_setopt ($nona_login, CURLOPT_REFERER, $rock_llink); 

    curl_setopt ($nona_login, CURLOPT_POSTFIELDS, $rock_lpost); 
    curl_setopt ($nona_login, CURLOPT_POST, 1); 
    $nona_login_result = curl_exec ($nona_login);

    $login_check = substr($nona_login_result,0,10);

    if (strpos($nona_login_result, 'ROCK') !== false)
    {
        $c_text = "[SUCCESS] LOGIN TO \"" . $rock_llink . "\"" . "<br>";
        $loginf = true;
    }
    else
    {
        $c_text = "[ERROR&nbsp;&nbsp;] LOGIN TO \"" . $rock_llink . "\" FAILED, PROCESS TERMINATED..." . "<br>";
        $close = true;
    }

    curl_close($nona_login);
endif;

if(!$close):
    $nona_fetch = curl_init(); 
    curl_setopt ($nona_fetch, CURLOPT_URL, $rock_flink); 
    curl_setopt ($nona_fetch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt ($nona_fetch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
    curl_setopt ($nona_fetch, CURLOPT_TIMEOUT, 60); 
    curl_setopt ($nona_fetch, CURLOPT_FOLLOWLOCATION, 0); 
    curl_setopt ($nona_fetch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt ($nona_fetch, CURLOPT_COOKIEJAR, $p_cookies);
    curl_setopt ($nona_fetch, CURLOPT_COOKIEFILE, $p_cookies); 
    curl_setopt ($nona_fetch, CURLOPT_REFERER, $rock_flink); 

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $rock_fpost); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "regi")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"ROCK\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING LATEST DATA" . "<br>";
        if(file_put_contents($p_rockdata, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $rock_save_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $rock_save_n . "\"" . " FAILED, PROCESS TERMINATED...";
            $close = true;
        }
    }

    curl_close($nona_fetch);
endif;