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

    $page_title = "Nonatero | CMDF";

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] < 3)):

    if(!isset($mode)){
        $mode = 0;
    }

    require "plasa_proses.php";

?>
<!DOCTYPE html>
<html div class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/datepicker.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
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
        <a href="plasa.php"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-3-10 uk-width-medium-4-10 uk-width-small-5-10 uk-width-8-10 uk-container-center">
                    <form class="uk-form sd-box" action="" method="POST" id="option-form" name="registration-form">
                        <?php if(isset($mode) && $mode == 1 && (!isset($alert) || (isset($alert) && $alert != 'success'))): ?>
                            <input type="hidden" name="mode" value="1">
                            <input type="hidden" name="itiket" value="<?php echo $itiket; ?>">
                            <input type="hidden" name="tiket" value="<?php echo $itiket; ?>">
                        <?php endif; ?>
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                            <div class="uk-grid uk-text-center">
                                <h3 class="uk-contrast">
                                <?php if($mode == 0){ echo "INSERT ORDER PLASA"; }
                                        else{ echo "EDIT ORDER PLASA"; }
                                ?>
                                </h3>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-key""></i>
                                        <input type='text' placeholder='TROUBLE NO' class='uk-width-1-1' <?php if($mode == 0) echo "name='tiket'"; else echo "disabled"; ?> value="<?php echo $itiket; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-key""></i>
                                        <input type='text' placeholder='ND TELP/INT' class='uk-width-1-1' name="nd" value="<?php echo $ind; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-user""></i>
                                        <input type='text' placeholder='NAMA PENGIRIM' class='uk-width-1-1' name="nama" value="<?php echo $inama; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-phone-square""></i>
                                        <input type='text' placeholder='CP PENGIRIM' class='uk-width-1-1' name="cp" value="<?php echo $icp; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-user""></i>
                                        <input type='text' placeholder='CSR' class='uk-width-1-1' name="csr" value="<?php echo $icsr; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-phone-square""></i>
                                        <input type='text' placeholder='DATEK' class='uk-width-1-1' name="datek" value="<?php echo $idatek; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-small-1-1" >
                                        <textarea class='uk-width-1-1' placeholder="KELUHAN (max. 200 digit)" name="keluhan"><?php echo $ikeluhan; ?></textarea>
                                </div>
                                <div class="uk-form-icon uk-width-small-1-1" >
                                        <textarea class='uk-width-1-1' placeholder="KETERANGAN (max. 200 digit)" name="keterangan"><?php echo $iketerangan; ?></textarea>
                                </div>
                                <div class="uk-form-icon uk-width-medium-4-10 uk-width-small-1-1">
                                        <i class="uk-icon-calendar-plus-o""></i>
                                        <input type='text' placeholder='TANGGAL' class='uk-width-1-1' name="tanggal" data-uk-datepicker value="<?php echo $itanggal; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-6-10 uk-width-small-1-1 uk-clearfix">
                                        <input type='text' placeholder='FLAG (ex. #00ff00)' id="cpicker" name="flag" value="<?php if(empty($iflag)) echo "rgba(0,0,0,0)"; else echo $iflag; ?>">
                                        <button type="reset" class="uk-button uk-button-danger uk-float-right uk-margin-small-left" value="1" name="submit">RESET</button>
                                        <button type="submit" class="uk-button uk-button-primary uk-float-right" value="1" name="submit" onclick="return formcheck(
                                           this.form.tiket,
                                           this.form.nd,
                                           this.form.nama);">SUBMIT</button>
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

    function formcheck(tiket, nd, nama, perihal) {
    // Check each field has a value
        if (tiket.value == '' || nd.value == '' || nama.value == '') {
            alert('You must provide all the requested details. Please try again');
            return false;
        }
    }

     <?php if(isset($message)):                    
        $z = count($message);
        for($x = 0; $x < $z; $x++): ?>
                UIkit.notify("<?php echo $message[$x]; ?>", {timeout: 3000, status:'<?php echo $alert[$x]; ?>'});
            <?php
         endfor;
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