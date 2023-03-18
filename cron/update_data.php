<?php
    require_once "path_definer.php";

    require "server_config.php";
    require "fetch_setting.php";
    require "connection.php";

    if(!isset($close)){
        $close = false;
    }

    if(!isset($debug)){
        $debug = false;
    }

if(!isset($c_text) && !$close):
    $c_text = "# RECALC POINT<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# RECALC POINT<br>--------------------</br>";
endif;

if(!$close):
    $process = "call nona_upoin()";
    if (mysqli_query($query, $process)) // replace nonatero > history
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] CALL ROUTINE NONA_UPOIN()<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] RECALC POINT VALUE" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] CALL ROUTINE NONA_UPOIN(), PROCESS TERMINATED...";
        $close = true;
    }
endif;

mysqli_close($query);
