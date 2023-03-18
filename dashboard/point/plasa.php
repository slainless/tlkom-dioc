<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "point";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "Point | Order Dewa";
    
    $per_page=50;

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] < 3)):

    require "plasa_remove.php";
    require "plasa_proses.php";

    if(!isset($cf)) {
        $cf = false;
    }

    if(!isset($_GET["page"])) {
        $page=1;
    }
    else {
        $page = $_GET["page"];
    }

    $start_from = ($page-1) * $per_page;

        $condition = "";

    if ($stmt = $query->prepare("SELECT ".$t_nona_pls.".*, ".$t_nona_cmdf.".CMDF, ".$t_nona_cmdf.".JENIS, ".$t_nona_cmdf.".MITRA, ".$t_nona_cmdf.".STO, ".$t_nona_cmdf.".SEGMEN FROM ".$t_nona_pls." LEFT OUTER JOIN ".$t_nona_cmdf." ON ".$t_nona_pls.".ND = ".$t_nona_cmdf.".ND " . $condition . " LIMIT ?, ?")) {

            $stmt->bind_param("ii", $start_from, $per_page); 
            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            $stmt->close();
            
            $no = $per_page * ($page-1);
    }

    if ($stmt = $query->prepare("SELECT 
    COUNT(TROUBLE_NO) as number FROM " . $t_nona_pls . "" . $condition . "")) {
        // Bind "$user_id" to parameter.
        $stmt->execute();   // Execute the prepared query.

        $stmt->bind_result($total_records);
        $stmt->fetch();

        $stmt->close();
    }
    
    $total_pages = ceil($total_records / $per_page);
?>

<!DOCTYPE html>
<html div class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickyfooter.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>

    <script src="<?php pathcv($path_type, "js/components/datepicker.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
    <link rel="stylesheet" href="<?php pathcv($path_type, "js/spectrum.css", $path_level); ?>">
    <script src="<?php pathcv($path_type, "js/spectrum.js", $path_level); ?>"></script>
     <style>
    .uk-table tbody tr {
        background: #f5f5f5;
    }
    </style>
    </head>
    <body class="uk-height-1-1">
    <div class="uk-grid">
        <div class="uk-width-1-1 sd-header">
        </div>
        <div class="uk-width-1-1 sd-content sd-table">
            <table class="uk-table uk-table-striped">
                <thead class="uk-contrast">
                    <tr>
                        <td colspan="8"><a class="submit" href="#inputpop" data-uk-modal><i class="uk-icon-medium uk-icon-chrome uk-icon-spin"></i></a></td>
                        <td colspan="1" class="uk-clearfix"><a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>" class="sd-offcanvas-toggle uk-float-right"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a></td>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Info Tiket</th>
                        <th>Nama</th>
                        <th>Info STO</th>
                        <th>CSR</th>
                        <th>Keluhan</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                <?php
                while($row = $result->fetch_assoc()):

                switch ($row["MITRA"]) {
                    case 'PT. TA':
                        $row["MITRA"] = 'PT.TA';
                        break;
                }

                switch ($row["JENIS"]) {
                    case 'FTTH':
                        $badge_jenis = 'uk-badge-success';
                        break;
                    case 'NON-FTTH':
                        $badge_jenis = 'uk-badge-danger';
                        break;
                    default:
                        $badge_jenis = 'sd-super-hidden';
                        break;
                }

                switch ($row["SEGMEN"]) {
                    case 'INNER':
                        $badge_segmen2 = '';
                        $badge_segmen = 'uk-icon-sign-in';
                        break;
                    case 'OUTER':
                        $badge_segmen2 = '';
                        $badge_segmen = 'uk-icon-sign-out';
                        break;
                    default:
                        $badge_segmen2 = 'sd-super-hidden';
                        $badge_segmen = 'sd-super-hidden';
                        break;
                }

                $no = $no + 1;
                ?>
                
                    <tr <?php if($row["FLAG_COLOR"] != "#000000" && !empty($row["FLAG_COLOR"])) echo "style='background-color: ".$row["FLAG_COLOR"].";' class='uk-contrast'"; ?>>
                        <td><?php echo $no; ?></td>
                        <td>
                            <span class="tiket"><?php echo $row["TROUBLE_NO"]; ?></span><br>
                            <span><?php echo $row["ND"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["NAMA"]; ?></span><br>
                            <span>[CP: <?php echo $row["CP_PENGIRIM"]; ?>]</span>
                        </td>
                        <td>
                            <span class='uk-badge <?php echo $badge_jenis; ?>'><?php echo $row["JENIS"]; ?></span>
                            <span class='uk-badge <?php echo $badge_segmen2; ?>'><span class='<?php echo $badge_segmen; ?>' style='margin-right: 5px;'></span><?php echo $row["SEGMEN"]; ?></span><br>
                            <span>[<?php echo $row["STO"]; ?>]</span>
                            <span><?php echo $row["MITRA"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["CSR"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["KELUHAN"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["KETERANGAN"]; ?></span><br>
                            <span><?php echo $row["DATEK"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["TANGGAL"]; ?></span>
                        </td>
                        <td>
                            <a class="uk-button uk-button-danger uk-margin-small-bottom remove"><span class='uk-icon-trash uk-icon-justify'></span></a>
                            <a class="uk-button uk-button-success submit uk-margin-small-bottom" href="#inputpop" data-uk-modal><span class='uk-icon-pencil-square-o uk-icon-justify'></span></a>
                        </td>
                    </tr>

                <?php endwhile; ?>


                </tbody>
            </table>
        </div>
        <div class="uk-width-1-1 sd-pagination">
            <ul class="uk-pagination uk-panel-space uk-margin-top uk-margin-bottom">
                <li><button class="uk-pagination-previous" type="submit" form="option-form" name="page" value="1">First</button></li>
                <?php
                    for ($i=1; $i<=$total_pages; $i++) {
                        if($page == $i){
                            echo " <li><button class='uk-active sd-disabled' type='submit' form='option-form' name='page' value='" .$i. "' disabled>" .$i. "</button>";
                        }
                        else {
                        echo " <li><button type='submit' form='option-form' name='page' value='" .$i. "'>" .$i. "</button>";
                        }
                    };
                ?>
                <li><button class="uk-pagination-next" type="submit" form="option-form" name="page" value="<?php echo $total_pages; ?>">Last</button></li>
            </ul>
        </div>
    </div>
    <script>
    $('.uk-table').stickyTableHeaders();

    $( ".submit" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

/*            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("target", "_blank");
            form.attr("action", "../point/plasa_edit.php");
            form.submit();
            form.attr("action", "");
            form.attr("target", "");

            $(".inputinfo").remove();*/
            $.post( "<?php pathcv($path_type, "dashboard/point/plasa_module.php", $path_level); ?>", { itiket: tiket }, function( data ) {
                $( "#modalbox" ).html( data );
            });
        });

    $( ".remove" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

            var accept = confirm('Are you sure want to remove this data?');
            if(accept == true){
                $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "tiket").attr("class", "inputinfo");
                $("<input>").appendTo(icon).attr("type", "hidden").attr("value", "1").attr("name", "remove").attr("class", "inputinfo");

                form.attr("action", "");
                form.attr("target", "");
                form.submit();

                $(".inputinfo").remove();
            }
            else {
                event.preventDefault();
            }
        });

 <?php if(!empty($message)): ?>
                UIkit.notify("<?php echo $message; ?>", {timeout: 3000, status:'<?php echo $alert; ?>'});
        <?php endif;        ?>

    </script>
    <form action='' method='POST' id='sub-option' target="_blank">
        <div id="container"></div>
    </form>
    <div class="sd-backtop">
        <a href="#top" data-uk-smooth-scroll><span class="uk-icon-angle-up uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
        <a href="#bottom" data-uk-smooth-scroll><span class="uk-icon-angle-down uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
    </div>
    <div class="uk-modal" id="inputpop">
        <div class="uk-modal-dialog sd-background-none" id="modalbox">
        </div>
    </div>
    <div id="bottom"></div>
    </body>
</html>

<?php
    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>