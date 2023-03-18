<?php
    require_once "path_definer.php";

    require "server_config.php";
    require "fetch_setting.php";

    if(!isset($close)){
        $close = false;
    }

    if(!isset($loginf)){
        $loginf = false;
    }

if(!isset($c_text) && !$close):
    $c_text = "# FETCH DATA PELANGGAN<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# FETCH DATA PELANGGAN<br>--------------------</br>";
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
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOGIN TO \"" . $nona_llink . "\", PROCESS TERMINATED..." . "</br>";
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fslv); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"PLG SILVER\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG SILVER\" DATA" . "<br>";
        endif;
        if(file_put_contents($p_nonaslv, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_slv_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA SILVER" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_slv_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fttn); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING \"PLG TITANIUM\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG TITANIUM\" DATA" . "<br>";
        endif;
        if(file_put_contents($p_nonattn, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_ttn_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA TITANIUM" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_ttn_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fplt); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"PLG PLATINUM\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG PLATINUM\" DATA" . "<br>";
        endif;
 
        if(file_put_contents($p_nonaplt, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_plt_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA PLATINUM" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_plt_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fbsn); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"PLG BUSINESS\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG BUSINESS\" DATA" . "<br>";
        endif;

        if(file_put_contents($p_nonabsn, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_bsn_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA BUSINESS" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_bsn_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fent); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"PLG ENTERPRISE\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG ENTERPRISE\" DATA" . "<br>";
        endif;

        if(file_put_contents($p_nonaent, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_ent_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA ENTERPRISE" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_ent_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fhc); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"HARD COMPLAIN\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG HARD COMPLAIN\" DATA" . "<br>";
        endif;

        if(file_put_contents($p_nonahc, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_hc_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA HARD COMPLAIN" . "<br>";
            $c_text = $c_text . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_hc_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
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

    curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fg3p); 
    curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
    $nona_fetch_result = curl_exec ($nona_fetch); 

    $check_result = substr($nona_fetch_result, 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FETCHING LATEST \"GGN 3P\" DATA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FETCHING \"PLG GGN 3P\" DATA" . "<br>";
        endif;

        if(file_put_contents($p_nonag3p, $nona_fetch_result, LOCK_EX))
        {
            if($debug == true):
                $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] SAVED TO \"" . $nona_g3p_n . "\"" . "<br>";
            endif;
            $c_text = $c_text . "[SUCCESS] FETCHING DATA GGN 3P" . "<br>";
            $c_text = $c_text . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] SAVED TO \"" . $nona_g3p_n . "\"" . ", PROCESS TERMINATED..." . "</br>";
            $close = true;
        }
    }

    curl_close($nona_fetch);
endif;