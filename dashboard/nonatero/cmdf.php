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
    $path_level = 1;

    $page_title = "Nonatero | CMDF";

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] < 3)):

    if ($stmt = $query->prepare("SELECT CMDF 
    FROM ".$t_nona_sto." GROUP BY CMDF"))
    {

        $stmt->execute();
        
        $sto_list = $stmt->get_result();
        $stmt->close();
    }

    if(isset($_POST["submit"]) && $_POST["submit"] == 1) {
        require "cmdf_proses.php";
    }

    $sto_list->data_seek(0);
    $op_sto = array();

    $op_sto[0][0] = "0";
    $op_sto[0][1] = "# CMDF";
    $op_sto[0][2] = "0";

    $x = 1;
    while($row = $sto_list->fetch_assoc()) {
        if($row["CMDF"] != ''){
            $op_sto[$x][0] = $x;
            $op_sto[$x][1] = $row["CMDF"];
            $op_sto[$x][2] = $x;

            $x++;
        }
    }

    if(!empty($_POST["nd_telp"]) || !empty($_POST["nd_int"])){
        $nd_telp = filter_input(INPUT_POST, 'nd_telp', FILTER_SANITIZE_NUMBER_INT);
        $nd_int = filter_input(INPUT_POST, 'nd_int', FILTER_SANITIZE_NUMBER_INT);
        $nd_sto = filter_input(INPUT_POST, 'sto', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    else {
        $nd_int = $nd_telp = $nd_sto = "";
    }

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
    <script src="<?php pathcv($path_type, "js/components/notify.js", $path_level); ?>"></script>
    <style>
    </style>
    <script>
    </script>
    </head>
    <body class="uk-height-1-1">
    <div class="sd-fixed sd-fixed-top">
        <a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-4-10 uk-width-medium-5-10 uk-width-small-6-10 uk-width-9-10 uk-container-center uk-margin-large-top uk-margin-large-bottom" id="container">
                    <form class="uk-form sd-box" action="" method="POST" id="option-form" name="registration-form">
                    <?php if(!isset($alert) || (isset($alert) && $alert[0] != 'success')): ?>
                            <input type='hidden' name='nd_telp' value="<?php echo $nd_telp; ?>"></input>
                            <input type='hidden' name='nd_int' value="<?php echo $nd_int; ?>"></input>
                            <input type='hidden' name='sto' value="<?php echo $nd_sto; ?>"></input>
                    <?php else:
                            $nd_telp = $nd_int = $nd_sto = '';
                    endif; ?>
                        <div class="uk-grid uk-grid-width-1-1 uk-grid-collapse sd-table-insert uk-panel uk-panel-box uk-panel-box">
                            <table class="uk-table uk-table-hover sd-table-edit">
                                <thead>
                                    <tr>
                                        <th colspan="4"><h3 class="uk-contrast">INSERT CMDF</h3></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>ND</th>
                                        <th>CMDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for($x=0; $x<20; $x++):

                                switch($x){
                                    case 0:
                                        $group = "group-5";
                                        break;
                                    case ($x < 5):
                                        $group = "group-5";
                                        break;
                                    case ($x > 4 && $x < 9):
                                        $group = "group-10";
                                        break;
                                    case ($x > 9 && $x < 14):
                                        $group = "group-15";
                                        break;
                                    case ($x > 14 && $x < 19):
                                        $group = "group-20";
                                        break;
                                } ?>


                                    <tr class="<?php echo $group; ?>">
                                        <td><input class="check-disabled" type="checkbox" name="insert[<?php echo $x; ?>][0]"></td>
                                        <td class="uk-width-5-10"><input type="text" placeholder="ND" value="<?php if($x == 0){ 
                                            if(empty($nd_telp)){
                                                echo $nd_int;
                                            }
                                            else {
                                                echo $nd_telp;
                                            }
                                        } ?>" class="uk-width-1-1" name="insert[<?php echo $x; ?>][1]"></td>
                                        <td class="uk-width-4-10">
                                            <select name="insert[<?php echo $x; ?>][2]" class="uk-width-1-1">
                                                <?php 
                                                if($x == 0) { print_option($nd_sto, $op_sto, 1); }
                                                else { print_option(-1, $op_sto); } ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                                    <tr>
                                            <td><input id="select_all" type="checkbox"></td>
                                            <td>IGNORE ALL</td>
                                            <td class="uk-grid uk-grid-small">
                                                <div class="uk-width-4-10">
                                                    <select id="option-view" class="uk-width-1-1">
                                                        <option value='1'>5</option>
                                                        <option value='2'>10</option>
                                                        <option value='3'>15</option>
                                                        <option value='4'>20</option>
                                                    </select>
                                                </div>
                                                <div class="uk-width-6-10">
                                                    <button type="submit" class="uk-button uk-button-primary uk-width-1-1" value="1" name="submit">SUBMIT</button>
                                                </div>
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php /* if(isset($message)): ?>
                            <div class="uk-width-1-1">
                                <div class="uk-grid uk-grid-width-1-1 uk-grid-small" data-uk-grid-margin="">
                                <?php
                                    $z++;
                                    for($x = 0; $x < $z; $x++):

                                        if(isset($message[$x])): ?>
                                        <div>
                                            <div class='uk-alert uk-margin-remove uk-alert-<?php echo $alert[$x]; ?>' data-uk-alert>
                                                <a href='' class='uk-alert-close uk-close'></a>
                                                <p><?php echo $message[$x]; ?></p>
                                            </div>
                                        </div>
                                        <?php endif;
                                    endfor; ?>
                                </div>
                            </div>
                            <?php endif; */ ?>
                    </form>
                </div>

            </div>
        </div>
    <script>
    $('#select_all').change(function() {
        var checkboxes = $(this).closest('form').find(':checkbox');
        if($(this).is(':checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });

    $( "#option-form" ).submit(function( event ) {
        $(this).find(":input:hidden").prop("disabled",true);
        $(this).find("input[name='nd_telp']").prop("disabled",false);
        $(this).find("input[name='nd_int']").prop("disabled",false);
        $(this).find("input[name='sto']").prop("disabled",false);
    });

$('#option-view').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    switch (valueSelected) { 
        case '1': 
            $('.group-10, .group-15, .group-20').css("display", "none");
            $('.group-5').css("display", "table-row");
            break;
        case '2': 
            $('.group-15, .group-20').css("display", "none");
            $('.group-5, .group-10').css("display", "table-row");
            break;
        case '3':
            $('.group-20').css("display", "none");
            $('.group-5, .group-10, .group-15').css("display", "table-row");
            break;
        case '4':
            $('.group-5, .group-10, .group-15, .group-20').css("display", "table-row");
            break;
        default:
            $('.group-10, .group-15, .group-20').css("display", "none");
            $('.group-5').css("display", "table-row");
            break;
    }
});

     $(function() {
        $('.group-10, .group-15, .group-20').css("display", "none");
      });

     <?php if(isset($message)):                    
        $z++;
        for($x = 0; $x < $z; $x++):
            if(isset($message[$x])): ?>
                UIkit.notify("<?php echo $message[$x]; ?>", {timeout: 3000, status:'<?php echo $alert[$x]; ?>'});
            <?php endif;
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