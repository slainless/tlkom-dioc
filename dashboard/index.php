<?php 
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $p_incl."login/function.php";

    require $webframe."webf_function.php";


    $webf_header_type = 1;
    $webf_footer_type = 1;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    sec_session_start();

    switch($_SESSION["level"]){
            case 4:
                $leveluser = "Guest";
                break;
            case 3:
                $leveluser = "Regular";
                break;
            case 2:
                $leveluser = "Operator";
                break;
            case 1:
                $leveluser = "Administrator";
                break;
            }
    

    $page_title = "Dashboard | ".$_SESSION["name"]." | ".$leveluser;

if(login_check($query)): ?>
<!DOCTYPE html>
<html class="uk-height-1-1">
<head>
        <?php
            require_once $webf_starter;
        ?>
        <link rel="stylesheet" href="<?php pathcv($path_type, "js/chartist.css", $path_level); ?>">
        <link rel="stylesheet" href="<?php pathcv($path_type, "js/chartist-plugin-tooltip.css", $path_level); ?>">

        <script src="<?php pathcv($path_type, "js/chartist.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-tooltip.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-fill-donut.min.js", $path_level); ?>"></script>
</head>
<body class="uk-height-1-1">
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-3-10 uk-width-medium-4-10 uk-width-small-6-10 uk-width-9-10 uk-container-center">
                    <form class="uk-form sd-box" action="" method="POST" id="option-form">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                                <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                    <div class="uk-clearfix uk-width-1-1 uk-margin-bottom">
                                        <span id="clock" class="uk-float-left"></span>
                                        <div class="uk-float-right uk-text-right">
                                            <span><?php echo $_SESSION["name"]; ?></span><br>
                                            <span class="uk-text-muted">
                                            <?php switch($_SESSION["level"]){
                                                case 4:
                                                    echo "Guest";
                                                    break;
                                                case 3:
                                                    echo "Regular";
                                                    break;
                                                case 2:
                                                    echo "Operator";
                                                    break;
                                                case 1:
                                                    echo "Administrator";
                                                    break;
                                                }
                                            ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-grid uk-grid-small" data-uk-grid-margin="" data-uk-grid-match>
                                    <div class="uk-width-small-5-6 uk-width-medium-3-4 uk-width-4-5">
                                        <div class="uk-width-1-1 uk-width-small-9-10">
                                            <div class="uk-grid uk-grid-width-1-2 uk-grid-small" data-uk-grid-margin="">
                                                    <div>
                                                        <a class="uk-button uk-button-primary uk-width-1-1" href="statistik/">STATISTIK</a>
                                                    </div>
                                                    <div >
                                                        <div class="uk-button-dropdown uk-width-1-1" data-uk-dropdown="{mode:'click'}">
                                                            <a class="uk-button uk-width-1-1">NONATERO</a>
                                                            <div class="uk-dropdown uk-contrast">
                                                                <ul class="uk-nav uk-nav-dropdown">
                                                                    <li><a href="nonatero/current.php"><span class="uk-icon-eye uk-icon-justify"></span> CURRENT</a></li>
                                                                    <li><a href="nonatero/history.php"><span class="uk-icon-clock-o uk-icon-justify"></span> HISTORY</a></li>
                                                                    <?php if($_SESSION["level"] < 3): ?>
                                                                    <li class="uk-nav-divider"></li>
                                                                    <li><a href="nonatero/cmdf.php"><span class="uk-icon-book uk-icon-justify"></span> CMDF</a></li>
                                                                    <?php if($_SESSION["level"] == 1): ?>
                                                                    <li><a href="nonatero/manual.php"><span class="uk-icon-cogs uk-icon-justify"></span> MANUAL</a></li>
                                                                    <?php endif; endif; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="uk-button-dropdown uk-width-1-1" data-uk-dropdown="{mode:'click'}">
                                                            <a class="uk-button uk-width-1-1">POINT</a>
                                                            <div class="uk-dropdown uk-contrast">
                                                                <ul class="uk-nav uk-nav-dropdown">
                                                                    <li><a href="point/current.php"><span class="uk-icon-eye uk-icon-justify"></span> CURRENT</a></li>
                                                                    <?php if($_SESSION["level"] < 3): ?>
                                                                    <li class="uk-nav-divider"></li>
                                                                    <li><a href="point/rihana.php"><span class="uk-icon-twitter uk-icon-justify"></span> RIHANA</a></li>
                                                                    <li><a href="point/dewa.php"><span class="uk-icon-bolt uk-icon-justify"></span> ORDER DEWA</a></li>
                                                                    <li><a href="point/plasa.php"><span class="uk-icon-map-marker uk-icon-justify"></span> PLASA</a></li>
                                                                    <li class="uk-nav-divider"></li>
                                                                    <li><a href="nonatero/cmdf.php"><span class="uk-icon-book uk-icon-justify"></span> CMDF</a></li>
                                                                    <?php if($_SESSION["level"] == 1): ?>
                                                                    <li><a href="point/manual.php"><span class="uk-icon-cogs uk-icon-justify"></span> MANUAL</a></li>
                                                                    <li><a href="point/point_config.php"><span class="uk-icon-pencil-square-o uk-icon-justify"></span> POINT CONFIG</a></li>
                                                                    <?php endif; endif; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <?php if($_SESSION["level"] != 1): ?>
                                                        <a class="uk-button uk-width-1-1" style="opacity: 0; cursor: initial;"></a>
                                                        <?php elseif($_SESSION["level"] == 1): ?>
                                                        <div class="uk-button-dropdown uk-width-1-1" data-uk-dropdown="{mode:'click'}">
                                                            <a class="uk-button uk-width-1-1">UPLOAD</a>
                                                            <div class="uk-dropdown uk-contrast">
                                                                <ul class="uk-nav uk-nav-dropdown">
                                                                    <li><a href="upload/keterangan.php"><span class="uk-icon-commenting uk-icon-justify"></span> KETERANGAN</a></li>
                                                                    <li><a href="upload/cmdf.php"><span class="uk-icon-book uk-icon-justify"></span> CMDF</a></li> 
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-small-1-6 uk-width-medium-1-4 uk-width-1-5">
                                    
                                        <div class="uk-grid-small uk-grid uk-grid-width-1-1" data-uk-grid-margin="">
                                            <div class="uk-button-dropdown uk-width-1-1" data-uk-dropdown="{mode:'click'}">
                                            <?php if($_SESSION["level"] < 4): ?>
                                                <a class="uk-button uk-width-1-1 uk-hidden-small">USER</a>
                                                <a class="uk-button uk-width-1-1 uk-visible-small"><span class="uk-icon-user"></span></a>
                                                <div class="uk-dropdown uk-contrast">
                                                                <ul class="uk-nav uk-nav-dropdown">
                                                                    <li><a href="../userman/form.php?edit=1"><span class="uk-icon-pencil-square-o uk-icon-justify"></span> EDIT PROFILE</a></li>
                                                                <?php if($_SESSION["level"] == 1 || $_SESSION["level"] == 2): ?>
                                                                    <li class="uk-nav-divider"></li>
                                                                    <li><a href="../userman/form.php"><span class="uk-icon-user-plus uk-icon-justify"></span> ADD USER</a></li>
                                                                    <li><a href="../userman/"><span class="uk-icon-user-secret uk-icon-justify"></span> USER MANAGER</a></li>
                                                                <?php endif; ?>
                                                                </ul>
                                                            </div>
                                            <?php endif; ?>
                                            </div>
                                            <div>
                                                <a class="uk-button uk-button-danger uk-width-1-1 uk-hidden-small" href="<?php pathcv($path_type, "include/login/logout.php", $path_level); ?>">LOGOUT</a>
                                                <a class="uk-button uk-button-danger uk-width-1-1 uk-visible-small" href="<?php pathcv($path_type, "include/login/logout.php", $path_level); ?>"><span class="uk-icon-sign-out"></span></a>
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
    var d = new Date(<?php echo time() * 1000 ?>);
    function pad(n) { return ("0" + n).slice(-2); }

    Number.prototype.pad = function (len) {
        return (new Array(len+1).join("0") + this).slice(-len);
    }

    setInterval(function() {
        d.setSeconds(d.getSeconds() + 1);
        $('#clock').text((d.getHours().pad(2) +':' + d.getMinutes().pad(2) + ':' + d.getSeconds().pad(2) ));
    }, 1000);
    </script>
    </body>
</html>
<?php 
else:
    header("Location: ".$r_logn."");
endif;
?>