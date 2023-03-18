<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "Point | Config Point";

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] == 1)):

    require "point_proses.php";

    $prep_stmt = "SELECT * FROM ".$t_point_cfg." WHERE ID = 1";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->execute();
                        $stmt->bind_result($id, $odw, $lpl, $rhn, $ind, $ggu, $slg, $pls, $hcm, $gll, $g3p);
                        $stmt->fetch();
                        $stmt->close();
    }

?>
<!DOCTYPE html>
<html div class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/datepicker.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/tooltip.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>

    <link rel="stylesheet" href="<?php pathcv($path_type, "js/spectrum.css", $path_level); ?>">
    <script src="<?php pathcv($path_type, "js/spectrum.js", $path_level); ?>"></script>
    <style>
        .uk-dropdown.uk-datepicker, .uk-dropdown.uk-datepicker a {
            color: white;
        }
        .uk-dropdown.uk-datepicker a:hover {
            color: dodgerblue;
        }
    </style>
    </head>
    <body class="uk-height-1-1">
    <div class="sd-fixed sd-fixed-top">
        <a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-3-10 uk-width-medium-4-10 uk-width-small-5-10 uk-width-8-10 uk-container-center">
                    <form class="uk-form sd-box" action="" method="POST" id="option-form" name="registration-form">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                            <div class="uk-grid uk-text-center">
                                <h3 class="uk-contrast">EDIT POINT</h3>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-user-secret""></i>
                                        <input type='text' placeholder='ORDER DEWA' class='uk-width-1-1' name="odw" value="<?php echo $odw; ?>" data-uk-tooltip="{pos:'left'}" title="ORDER DEWA">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-phone""></i>
                                        <input type='text' placeholder='LAPUL' class='uk-width-1-1' name="lpl" value="<?php echo $lpl; ?>" data-uk-tooltip="{pos:'right'}" title="LAPUL">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-twitter""></i>
                                        <input type='text' placeholder='RIHANA' class='uk-width-1-1' name="rhn" value="<?php echo $rhn; ?>" data-uk-tooltip="{pos:'left'}" title="RIHANA">
                                        <span data-uk-tooltip title=""></span> 
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-home""></i>
                                        <input type='text' placeholder='MY INDIHOME' class='uk-width-1-1' name="ind" value="<?php echo $ind; ?>" data-uk-tooltip="{pos:'right'}" title="MY INDIHOME">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-calendar-times-o""></i>
                                        <input type='text' placeholder='GGU TUA' class='uk-width-1-1' name="ggu" value="<?php echo $ggu; ?>" data-uk-tooltip="{pos:'left'}" title="GGU TUA">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-clock-o""></i>
                                        <input type='text' placeholder='SLG' class='uk-width-1-1' name="slg" value="<?php echo $slg; ?>" data-uk-tooltip="{pos:'right'}" title="SLG">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-building-o""></i>
                                        <input type='text' placeholder='PLASA' class='uk-width-1-1' name="pls" value="<?php echo $pls; ?>" data-uk-tooltip="{pos:'left'}" title="PLASA">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-exclamation-triangle""></i>
                                        <input type='text' placeholder='HARD COMPLAIN' class='uk-width-1-1' name="hcm" value="<?php echo $hcm; ?>" data-uk-tooltip="{pos:'right'}" title="HARD COMPLAIN">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-tachometer""></i>
                                        <input type='text' placeholder='GAUL' class='uk-width-1-1' name="gll" value="<?php echo $gll; ?>"  data-uk-tooltip="{pos:'left'}" title="GAUL">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-globe""></i>
                                        <input type='text' placeholder='GGN 3P' class='uk-width-1-1' name="g3p" value="<?php echo $g3p; ?>" data-uk-tooltip="{pos:'right'}" title="GGN 3P">
                                        <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-1 uk-width-small-1-1 uk-clearfix">
                                        <button type="reset" class="uk-button uk-button-danger uk-float-right uk-margin-small-left" value="1" name="submit">RESET</button>
                                        <button type="submit" class="uk-button uk-button-primary uk-float-right" value="1" name="submit" onclick="return formcheck(
                                           this.form.odw,
                                           this.form.lpl,
                                           this.form.rhn,
                                           this.form.ind,
                                           this.form.ggu,
                                           this.form.slg,
                                           this.form.pls,
                                           this.form.hcm,
                                           this.form.gll,
                                           this.form.g3p,
                                           );">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    $("#cpicker").spectrum({
        showPaletteOnly: true,
        preferredFormat: "hex",
        allowEmpty: true,
        containerClassName: "sd-cpick-box",
        replacerClassName: "sd-cpick-input",
        palette: [
            ["rgba(0,0,0,0)"],
            ["#c00000", "#f79646", "#f5f445", "#7fd13b", "#4bacc6", "#1f497d", "#8064a2"],
            ["#a3171e", "#e36c09", "#dede07", "#5ea226", "#31859b", "#17365d", "#5f497a"],
            ["#6d0f14", "#974806", "#c0c00d", "#3f6c19", "#205867", "#0f243e", "#3f3151"],
        ]
    })

    function formcheck(odw, lpl, rhn, ind, ggu, slg, pls, hcm, gll, g3p) {
    // Check each field has a value
        if (odw.value == '' || lpl.value == '' || ind.value == '' || ggu.value == '' || slg.value == '' || pls.value == '' || hcm.value == '' || gll.value == '' || g3p.value == '') {
            alert('You must provide all the requested details. Please try again');
            return false;
        }
    }

     <?php if(isset($message)): ?>              
                UIkit.notify("<?php echo $message; ?>", {timeout: 3000, status:'<?php echo $alert; ?>'});
            <?php
    endif; ?>
    </script>
    </body>
</html>

<?php
    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>