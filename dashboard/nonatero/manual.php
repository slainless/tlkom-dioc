<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/register.php";
    require $p_incl."login/function.php";

    $webf_sidebar_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 1;

    $debug = 0;

    $page_title = "Nonatero | Manual Update";

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] == 1)):

    if(!isset($_POST["ut"])){
        $ut = 0;
    }
    else {
        $ut = $_POST["ut"];
    }

    if(!isset($c_text)){
        $c_text = '';
    }

    $f_nona = "fetch_nona_data.php";
    $f_plg = "fetch_nona_plg.php";

    $l_all = "load_alldata.php";
    $l_plg = "load_plgdata.php";

    $l_cmdf = "load_cmdf.php";

    switch ($ut) {
        case '1':
            if(!include $f_nona){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_nona . " NOT FOUND";
            }
            if(!include $l_all){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_all . " NOT FOUND";
            }
            break;
        case '2':
            if(!include $l_cmdf){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_cmdf . " NOT FOUND";
            }
            break;
        case '3':
            if(!include $f_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_plg . " NOT FOUND";
            }
            if(!include $l_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_plg . " NOT FOUND";
            }
            break;
        /*case '3':
            if(!include $f_nona){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_nona . " NOT FOUND";
            }
            if(!include $f_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_plg . " NOT FOUND";
            }
            if(!include $l_all){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_all . " NOT FOUND";
            }
            if(!include $l_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_plg . " NOT FOUND";
            }
            break;*/
        default:
            # code...
            break;
    }

?>
<!DOCTYPE html>
<html class="uk-height-1-1 sd-small">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/sha512.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/forms.js", $path_level); ?>"></script>
    <style>
    </style>
    </head>
    <body class="uk-height-1-1">
    <div class="sd-fixed sd-fixed-top">
        <a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-5-10 uk-width-medium-7-10 uk-width-small-9-10 uk-width-1-1 uk-container-center">
                    <form class="uk-form sd-box" action="" method="POST" id="option-form" name="manual">
                        <input type="hidden" name="ut" value="">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                                <div>
                                    <pre class="uk-width-1-1 sd-console uk-scrollable-text"><?php echo $c_text; ?></pre>
                                </div>
                                <div>
                                    <div class="uk-width-1-1">
                                        <div class="uk-grid uk-grid-width-1-3 uk-grid-small">
                                            <div>
                                                <button class="uk-button uk-button-primary uk-width-1-1 uk-hidden-small ut-1"><span class="uk-icon-cloud uk-icon-justify"></span> UPDATE DATA</button>
                                                <button class="uk-button uk-button-primary uk-width-1-1 uk-visible-small ut-1"><span class="uk-icon-cloud uk-icon-justify"></span></button>
                                            </div>
                                            <div>
                                                <button class="uk-button uk-button-primary uk-width-1-1 uk-hidden-small ut-2"><span class="uk-icon-random uk-icon-justify"></span> CMDF > DATA</button>
                                                <button class="uk-button uk-button-primary uk-width-1-1 uk-visible-small ut-2"><span class="uk-icon-random uk-icon-justify"></span></button>
                                            </div>
                                            <div>
                                                <button class="uk-button uk-button-primary uk-width-1-1 uk-hidden-small ut-3"><span class="uk-icon-flag uk-icon-justify"></span> UPDATE FLAG</button>
                                                <button class="uk-button uk-button-primary uk-width-1-1 uk-visible-small ut-3"><span class="uk-icon-flag uk-icon-justify"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    <script>
        $( ".ut-1" ).click(function() {
            var lookup = $(this).closest("form").find("input[type='hidden']");

            lookup.attr("value", "1");
            lookup.submit();
        });
        $( ".ut-2" ).click(function() {
            var lookup = $(this).closest("form").find("input[type='hidden']");

            lookup.attr("value", "2");
            lookup.submit();
        });
        $( ".ut-3" ).click(function() {
            var lookup = $(this).closest("form").find("input[type='hidden']");

            lookup.attr("value", "3");
            lookup.submit();
        });
    </script>
    </body>
</html>

<?php
else:
    header("Location: ".$r_logn."");
endif;
?>