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
        $c_text = $c_text . "[SUCCESS] LOGIN TO \"" . $nona_llink . "\"" . "<br>";
    }
    else
    {
        $c_text = "[ERROR  ] LOGIN TO \"" . $nona_llink . "\" FAILED, PROCESS TERMINATED...";
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
        $c_text = $c_text . "[ERROR  ] FETCHING LATEST \"PLG SILVER\" DATA FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING \"PLG SILVER\" DATA" . "<br>";
        if(file_put_contents($p_nonaslv, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $nona_slv_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR  ] SAVED TO \"" . $nona_slv_n . "\"" . " FAILED, PROCESS TERMINATED...";
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
        $c_text = $c_text . "[ERROR  ] FETCHING \"PLG TITANIUM\" DATA FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING \"PLG TITANIUM\" DATA" . "<br>";
        if(file_put_contents($p_nonattn, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $nona_ttn_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR  ] SAVED TO \"" . $nona_ttn_n . "\"" . " FAILED, PROCESS TERMINATED...";
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
        $c_text = $c_text . "[ERROR  ] FETCHING LATEST \"PLG PLATINUM\" DATA FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING \"PLG PLATINUM\" DATA" . "<br>";
        if(file_put_contents($p_nonaplt, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $nona_plt_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR  ] SAVED TO \"" . $nona_plt_n . "\"" . " FAILED, PROCESS TERMINATED...";
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
        $c_text = $c_text . "[ERROR  ] FETCHING LATEST \"PLG BUSINESS\" DATA FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING \"PLG BUSINESS\" DATA" . "<br>";
        if(file_put_contents($p_nonabsn, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $nona_bsn_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR  ] SAVED TO \"" . $nona_bsn_n . "\"" . " FAILED, PROCESS TERMINATED...";
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
        $c_text = $c_text . "[ERROR  ] FETCHING LATEST \"PLG ENTERPRISE\" DATA FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING \"PLG ENTERPRISE\" DATA" . "<br>";
        if(file_put_contents($p_nonaent, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $nona_ent_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR  ] SAVED TO \"" . $nona_ent_n . "\"" . " FAILED, PROCESS TERMINATED...";
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
        $c_text = $c_text . "[ERROR  ] FETCHING LATEST \"HARD COMPLAIN\" DATA FAILED, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FETCHING \"HARD COMPLAIN\" DATA" . "<br>";
        if(file_put_contents($p_nonahc, $nona_fetch_result, LOCK_EX))
        {
            $c_text = $c_text . "[SUCCESS] SAVED TO \"" . $nona_hc_n . "\"" . "<br>";
        }
        else
        {
            $c_text = $c_text . "[ERROR  ] SAVED TO \"" . $nona_hc_n . "\"" . " FAILED, PROCESS TERMINATED...";
            $close = true;
        }
    }

    curl_close($nona_fetch);
endif;