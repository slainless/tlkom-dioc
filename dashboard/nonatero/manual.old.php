<?php
    require_once "path_definer.php";

    require $p_conf;
    require $webframe."webf_function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    $close = false;
    $debug = false;

    $page_title = "Nonatero | Update Manual";

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
<html>
<head>
        <?php
            require_once $webf_starter;
        ?>

<!-- 
        <script src="js/core/core.js"></script>
        <script src="js/core/touch.js"></script>
        <script src="js/core/utility.js"></script>
        <script src="js/core/smooth-scroll.js"></script>
        <script src="js/core/scrollspy.js"></script>
        <script src="js/core/toggle.js"></script>
        <script src="js/core/alert.js"></script>
        <script src="js/core/button.js"></script>
        <script src="js/core/dropdown.js"></script>
        <script src="js/core/grid.js"></script>
        <script src="js/core/modal.js"></script>
        <script src="js/core/nav.js"></script>
        <script src="js/core/offcanvas.js"></script>
        <script src="js/core/switcher.js"></script>
        <script src="js/core/tab.js"></script>
        <script src="js/core/cover.js"></script>

        <script src="js/components/accordion.js"></script>
        <script src="js/components/autocomplete.js"></script>
        <script src="js/components/datepicker.js"></script>
        <script src="js/components/form-password.js"></script>
        <script src="js/components/form-select.js"></script>
        <script src="js/components/grid.js"></script>
        <script src="js/components/grid-parallax.js"></script>
        <script src="js/components/htmleditor.js"></script>
        <script src="js/components/lightbox.js"></script>
        <script src="js/components/nestable.js"></script>
        <script src="js/components/notify.js"></script>
        <script src="js/components/pagination.js"></script>
        <script src="js/components/parallax.js"></script>
        <script src="js/components/search.js"></script>
        <script src="js/components/slider.js"></script>
        <script src="js/components/slideset.js"></script>
        <script src="js/components/slideshow.js"></script>
        <script src="js/components/sticky.js"></script>
        <script src="js/components/timepicker.js"></script>
        <script src="js/components/tooltip.js"></script>
        <script src="js/components/upload.js"></script> -->
        <style>
            <?php if($debug == true): ?>
                .sd-console-box {
                    overflow-y: scroll;
                    max-height: 417px;
                }
            <?php endif; ?>
        </style>
</head>
<body>
    <?php
            require_once $webf_sidebar;
    ?>
    <form action="" method="POST" id="fetch_ut" class="hidden">
        <input type="hidden" name="ut" value="1">
    </form>
    <form action="" method="POST" id="cmdf_ut" class="hidden">
        <input type="hidden" name="ut" value="2">
    </form>
    <form action="" method="POST" id="plg_ut" class="hidden">
        <input type="hidden" name="ut" value="3">
    </form>
    <div class="uk-grid">
        <?php
            require_once $webf_header;
        ?>
        <div class="uk-width-1-1 sd-subheader">
            <div>
                <div class="uk-panel-space">
                    <ul class="uk-breadcrumb">
                        <li><a class="uk-text-uppercase" href="../nonatero/">Nonatero</a></li>
                        <li><span class="uk-text-uppercase">Update Manual</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1 sd-content sd-console">
            <div class="sd-content-main uk-grid">
                <div class="uk-grid uk-container-center uk-width-8-10 uk-grid-collapse">
                    <div class="uk-width-6-10 sd-console-frame">
                        <pre class="uk-width-1-1 sd-console-box"><?php echo $c_text; ?>
                        </pre>
                    </div>
                    <div class="uk-width-2-10"></div>
                    <div class="uk-width-2-10">
                        <div class="uk-grid">
                            <div class="uk-width-1-1 uk-clearfix">
                            <!--<div class="uk-width-1-3">
                                    tengah
                                </div> -->
                                <div class="uk-width-3-4 uk-float-right sd-content-main-btn">
                                    <ul data-uk-grid-margin="" class="uk-grid">
                                        <li class="uk-width-1-1">
                                            <a class="uk-button uk-width-1-1 sd-button-large" id="fetch_btn">
                                                <div class="uk-panel">
                                                    <div class="sd-badge uk-panel-badge"><i class="uk-icon-cloud-download uk-icon-large"></i></div>
                                                    <div class="uk-text-right"><span>UPDATE</span><br><span>DATA NONATERO</span></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="uk-width-1-1">
                                            <a class="uk-button uk-width-1-1 sd-button-large" id="cmdf_btn">
                                                <div class="uk-panel">
                                                    <div class="sd-badge uk-panel-badge"><i class="uk-icon-random uk-icon-large"></i></div>
                                                    <div class="uk-text-right"><span>UPDATE</span><br><span>CMDF TO NONA</span></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="uk-width-1-1">
                                            <a class="uk-button uk-width-1-1 sd-button-large" id="plg_btn">
                                                <div class="uk-panel">
                                                    <div class="sd-badge uk-panel-badge"><i class="uk-icon-pencil-square-o uk-icon-large"></i></div>
                                                    <div class="uk-text-right"><span>UPDATE</span><br><span>DATA PELANGGAN</span></div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            require_once $webf_footer;
        ?>
    </div>
<script type="text/javascript">
$( "#fetch_btn" ).click(function() {
  $( "#fetch_ut" ).submit();
});
$( "#cmdf_btn" ).click(function() {
  $( "#cmdf_ut" ).submit();
});
$( "#plg_btn" ).click(function() {
  $( "#plg_ut" ).submit();
});
</script>
</body>
</html>