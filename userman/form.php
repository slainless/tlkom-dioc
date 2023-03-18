<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    sec_session_start();

    if(login_check($query) && $_SESSION["level"] < 4):

    if(!isset($_GET["edit"])){
        $_GET["edit"] = 0;
    }

    if(!isset($_POST["mode"])){
        if($_GET["edit"] == 1){
            $mode = 1;
            $num = $_SESSION["user_id"];
        }
        else {
            if($_SESSION["level"] == 1 || $_SESSION["level"] == 2){
                $mode = 0;
            }
            else {
                $mode = 1;
                $num = $_SESSION["user_id"];
            }
        }   
    }
    else if($_POST["mode"] == 2) {
        if($_SESSION["level"] == 1 || $_SESSION["level"] == 2){
            $mode = 2;
            $num = $_POST["id"];
        }
        else {
            $mode = 1;
            $num = $_SESSION["user_id"];
        }
    }
    else if($_POST["mode"] == 0){
        if($_SESSION["level"] == 1 || $_SESSION["level"] == 2){
            $mode = 0;
        }
        else {
            $mode = 1;
            $num = $_SESSION["user_id"];
        }
    }
    else {
        $mode = 1;
        $num = $_SESSION["user_id"];
    }

    if($mode == 2 || $mode == 1) {

        $prep_stmt = "SELECT username, name, level FROM ".$t_members." WHERE id = ? LIMIT 1";
        $stmt = $query->prepare($prep_stmt);
        
        if ($stmt) {
            $stmt->bind_param('s', $num);
            $stmt->execute();

            $stmt->bind_result($un, $nm, $lv);
            $stmt->fetch();

            if($_SESSION["level"] == 2 && $lv == 1){
                header("Location: ".$r_dash."userman/?error=1");
                exit;
            }
        
        }
    }

    require $p_incl."login/register.php";

    $webf_sidebar_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 1;

    $page_title = "Dashboard | User";

?>
<!DOCTYPE html>
<html class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/sha512.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/forms.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/upload.min.js", $path_level); ?>"></script>
    <style>
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
                        <?php if($mode == 1 || $mode == 2){
                            echo "<input type='hidden' name='mode' value='".$mode."'></input>";
                            echo "<input type='hidden' name='id' value='".$num."'></input>";
                        }
                        if($mode == 1){
                            echo "<input type='hidden' name='level' value='".$_SESSION["level"]."'></input>";
                        } ?>
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                            <div class="uk-grid uk-text-center">
                                <h3 class="uk-contrast">
                                <?php if($mode == 0):
                                echo "REGISTRATION FORM";
                                elseif($mode == 1):
                                echo "EDIT PROFILE";
                                elseif($mode == 2):
                                echo "EDIT USER";
                                endif; ?>
                                </h3>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                    <i class="uk-icon-user"></i>
                                    <input class="uk-width-1-1" type="text" placeholder="USERNAME" name="username" id="username" 
                                    <?php if($mode == 2):
                                            echo "value='".$un."'";
                                        elseif($mode == 1):
                                            echo "value='".$_SESSION["username"]."'";
                                        endif; 
                                    ?>
                                    ></input>
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                    <i class="uk-icon-eye"></i>
                                    <input class="uk-width-1-1" type="text" placeholder="NAME" name="name" id="name"
                                    <?php if($mode == 2):
                                            echo "value='".$nm."'";
                                        elseif($mode == 1):
                                            echo "value='".$_SESSION["name"]."'";                                            
                                        endif; 
                                    ?>
                                    ></input>
                                </div>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-form-icon uk-width-medium-7-10 uk-width-small-6-10">
                                    <i class="uk-icon-key""></i>
                                    <input class="uk-width-1-1" type="password" placeholder="PASSWORD" name="password" id="password"></input>
                                </div>
                                <div class="uk-width-medium-3-10 uk-width-small-4-10">
                                <?php if($mode == 0 || $mode == 2 ): ?>
                                    <select name="level" id="level" class="uk-width-1-1">
                                        <option value=""># Level</option>
                                        <?php if($_SESSION["level"] == 1){ 
                                        echo "<option value='1'>Admin</option>"; 
                                        echo "<option value='2'>Operator</option>";
                                        } ?>
                                        <option value="3">Regular</option>
                                        <option value="4">Guest</option>
                                    </select>
                                <?php else: ?>
                                    <input type="hidden" name="level" value="1">
                                <?php endif ?>
                                </div>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-form-icon uk-width-medium-7-10 uk-width-small-6-10">
                                    <i class="uk-icon-unlock-alt""></i>
                                    <input class="uk-width-1-1" type="password" placeholder="CONFIRM PASSWORD" name="confirm" id="confirm"></input>
                                </div>
                                <div class="uk-width-medium-3-10 uk-width-small-4-10">
                                    <button class="uk-width-1-1 uk-button uk-button-primary" type="text" placeholder="PASSWORD" onclick="return regformhash(this.form,
                                   this.form.name,
                                   this.form.username,
                                   this.form.password,
                                   this.form.confirm);">SUBMIT</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <?php 
            require $webf_sidebar;
        ?>
    <script>

    <?php 
    if(isset($message)): ?>                   
        UIkit.notify("<?php echo $message; ?>", {timeout: 3000, status:'<?php echo $alert; ?>'});
    <?php endif; ?>
    </script>
    </body>
</html>

<?php
    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>