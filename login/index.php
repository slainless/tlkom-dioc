<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require $p_incl."login/function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 1;

    $page_title = "Nonatero | CMDF";

    sec_session_start();

if(login_check($query) == false):
?>
<!DOCTYPE html>
<html  class="uk-height-1-1">
<head>
  <?php
        require_once $webf_starter;
  ?>
    <script src="<?php pathcv($path_type, "js/sha512.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/forms.js", $path_level); ?>"></script>
</head>
<body class="uk-height-1-1">
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-2-10 uk-width-medium-3-10 uk-width-small-5-10 uk-width-8-10 uk-container-center">
                    <form class="uk-form sd-box" action="<?php pathcv($path_type, "include/login/login_process.php", $path_level); ?>" method="POST" id="option-form" name="login_form">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                                <div class="uk-text-center">
                                    <img src="<?php pathcv($path_type, "assets/stardusk-brand.svg", $path_level); ?>" style="padding: 15px 0;">
                                </div>
                                <div class="uk-form-icon" style="padding-left: 0">
                                    <i class="uk-icon-user"></i>
                                    <input class="uk-width-1-1" type="text" placeholder="USERNAME" name="username"></input>
                                </div>
                                <div class="uk-form-icon" style="padding-left: 0">
                                    <i class="uk-icon-key"></i>
                                    <input class="uk-width-1-1" type="password" placeholder="PASSWORD" name="password" id="password"></input>
                                </div>
                                <div class="uk-clearfix">
                                    <button class="uk-float-right uk-width-3-10 uk-button" onclick="formhash(this.form, this.form.password);">LOGIN</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<?php else:
    header("Location: ".$r_main."");
endif;
?>