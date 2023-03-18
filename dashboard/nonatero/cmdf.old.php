<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "Nonatero | CMDF";
    
    $per_page=50;

    if(!isset($cf)) {
        $cf = false;
    }

    if(!isset($_GET["page"])) {
        $page=1;
    }
    else {
        $page = $_GET["page"];
    }

    if(!isset($_POST["mode"])) {
        $_POST["mode"] = 1;
        $disabled = '';
    }

    if(!isset($_POST["submit"])) {
        $_POST["submit"] = 0;
    }
    else {
        require "cmdf_proses.php";
    }

    $start_from = ($page-1) * $per_page;

    if ($stmt = $query->prepare("SELECT CMDF 
    FROM ".$t_nona_sto." GROUP BY CMDF"))
    {

        $stmt->execute();
        
        $sto_list = $stmt->get_result();
        $stmt->close();

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
    }

    if ($stmt = $query->prepare("SELECT COUNT(CMDF) 
    FROM ".$t_nona_cmdf.""))
    {
        $stmt->execute();
        
        $stmt->bind_result($count);
        $stmt->fetch();

        $stmt->close();
        $count = number_format($count);
    }

    $mode = array(
        array(1,"Insert Mode",0),
        array(2,"View/Delete Mode",0),
    )

?>
<!DOCTYPE html>
<html div class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    </head>
    <body>
    <div class="uk-grid">
        <?php
            require_once $webf_sidebar;
        ?>
        <?php
            require_once $webf_header;
        ?>
        <div class="uk-width-1-1 sd-subheader">
                <div>
                    <div class="uk-panel-space">
                        <ul class="uk-breadcrumb">
                            <li><a class="uk-text-uppercase" href="../nonatero/">Nonatero</a></li>
                            <li><span class="uk-text-uppercase">CMDF</span></li>
                        </ul>
                    </div>
                </div>
        </div>
        <div class="uk-width-1-1 sd-option sd-option-insert">
            <div class="uk-grid">
                <div class="uk-width-5-10 uk-container-center">
                    <form class="uk-form" action="" method="POST" id="option-form">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert" data-uk-grid-margin="">
                                <span class="sd-option-legend uk-width-1-1"><?php echo $count; ?> data.</span>
                                <div data-uk-margin>
                                        <?php
                                        if($_POST["mode"] == 3){
                                            $disabled = 1;
                                        }
                                        print_option($_POST["mode"], $mode, 1, "mode", 1, $disabled);
                                        ?>
                                </div>
                                <table class="uk-table uk-table-striped uk-table-hover">
                                <tbody>
                                <?php for($x=0; $x<20; $x++){

                                if($x < 5){
                                    $group = "group-5";
                                }
                                else if($x > 4 && $x < 10){
                                    $group = "group-10";
                                }
                                else if($x > 9 && $x < 15){
                                    $group = "group-15";
                                }
                                else if($x > 14 && $x < 20){
                                    $group = "group-20";
                                }

                                if($_POST["mode"] == 3){

                                    $array_val = $_POST["default_cmdf"];

                                if($x == 0){ $disabled = "disabled"; $disabled_select = ""; $value_def = "value='".$array_val[0]."'";}
                                else { $disabled = "disabled"; $disabled_select = $disabled; $value_def = "";  }
                                echo "<tr class='".$group."'>";
                                echo "<td class='uk-text-center uk-table-middle'><input class='check-disabled' type='checkbox' name='insert[".$x."][0]' ".$disabled."></td>";
                                echo "<td><input type='text' placeholder='NO. INT/TELEPON' class='uk-width-1-1' name='insert[".$x."][1]' ".$disabled_select." ".$value_def."></td>";
                                echo "<td>";
                                echo "<select name='insert[".$x."][2]' class='uk-width-1-1' ".$disabled_select.">";
                                        if($x == 0){print_option($array_val[1], $op_sto);}
                                        else {print_option(-1, $op_sto);}
                                echo "</select>";
                                echo "</td>";
                                echo "</tr>";
                                }
                                else if($_POST["mode"] == 1 || $_POST["mode"] == 2){
                                echo "<tr class='".$group."'>";
                                echo "<td class='uk-text-center uk-table-middle'><input class='check-disabled' type='checkbox' name='insert[".$x."][0]' ".$disabled."></td>";
                                echo "<td><input type='text' placeholder='NO. INT/TELEPON' class='uk-width-1-1' name='insert[".$x."][1]' ".$disabled."></td>";
                                echo "<td>";
                                echo "<select name='insert[".$x."][2]' class='uk-width-1-1'>";
                                        print_option(-1, $op_sto);
                                echo "</select>";
                                echo "</td>";
                                echo "</tr>";
                                }
                                } ?>
                                </tbody>
                                </table>
                                <div>
                                    <div class="uk-grid uk-grid-width-1-2 sd-no-pad" data-uk-margin>
                                        <div class="uk-text-middle">
                                            <input type="checkbox" id="select_all" style="margin-right: 8px" <?php if($_POST["mode"] == 3){ echo "disabled"; }?>>Select All
                                        </div>
                                        <div class="uk-clearfix"><div class="uk-float-right">
                                            <select id="option-view" <?php if($_POST["mode"] == 3){ echo "disabled"; }?>>
                                                <option value='1'>5</option>
                                                <option value='2'>10</option>
                                                <option value='3'>15</option>
                                                <option value='4'>20</option>
                                            </select>
                                            <button type="submit" class="uk-button uk-button-primary" value="1" name="submit">SUBMIT</button>
                                        </div></div>
                                    </div>
                                </div>
                                <div class="uk-alert uk-alert-warning" data-uk-alert>
                                    <a href="" class="uk-alert-close uk-close"></a>
                                    <p>Select the checkbox to ignore the row.</p>
                                </div>
                                <?php
                                if(isset($message)){

                                    $pcs_arlen_sto = count($message);
    
                                    for($x = 0; $x < $pcs_arlen_sto; $x++) {
                                        echo "<div class='uk-alert uk-alert-".$alert[$x]."' data-uk-alert>";
                                        echo "<a href='' class='uk-alert-close uk-close'></a>";
                                        echo "<p>".$message[$x]."</p>";
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            require_once $webf_footer;
        ?>
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

 $(function() {
    $('.group-10, .group-15, .group-20').css("display", "none");
  });

  $( "#option-form" ).submit(function( event ) {
        $(this).find(":input:hidden").prop("disabled",true);
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
    </script>
    </body>
</html>

<?php
    mysqli_close($query);
?>