<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
    require $p_svropt;
    require $p_cdash;
    require $p_cnona;
      
    require_once $p_inc . "database/fetch_setting.php";
    require_once $p_inc . "login/fungsi.php";

    sec_session_start();

if (login_check($que_dash) == true) {
    if ($stmt = $que_nona->prepare("SELECT TANGGAL AS TANGGAL, COUNT(TROUBLE_NO) AS JUMLAH FROM " . $t_nona . " GROUP BY TANGGAL")) {
        
        $stmt->execute();   // Execute the prepared query.
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $date = $row["TANGGAL"];
            $ggn = $row["JUMLAH"];

            $update = date_format(date_create($row["TANGGAL"]),"d M Y, H:i");
        }

        $stmt->free_result();
        $stmt->close();
    }

    if ($stmt = $que_nona->prepare("SELECT COUNT(TROUBLE_NO) AS JUMLAH FROM " . $t_nona_h . "")) {
        
        $stmt->execute();   // Execute the prepared query.
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $ggn_h = $row["JUMLAH"];
        }

        $stmt->free_result();
        $stmt->close();
    }
}
else {
    header("Location: " . $p_dsh . "login/");
}
?>    
<html>
    <head>
        <title><?php echo $_SESSION['username']; ?> | Statistik Gangguan </title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="styles/mainv2.css" />
        <link rel="stylesheet" href="styles/responsive.css" />
        <link rel="stylesheet" href="styles/menu.css" />
        <link rel="stylesheet" href="../include/styles/reset.css" />

        <link rel="stylesheet" href="styles/font.css" />

        <link rel="stylesheet" href="statistik/chartist.css">
        <link rel="stylesheet" href="statistik/chartist-plugin-tooltip.css">

        <script src="statistik/chartist.js"></script>
        <script src="statistik/chartist-plugin-tooltip.js"></script>
        <link rel="icon" type="image/png" href="../favicon.ico" sizes="32x32" />
        <style>
            .ct-grid {
                stroke-dasharray: 2px;
            }
            .ct-chart {
                background-color: white;
                font-stretch: condensed;
                border-radius: 15px;
            }
            .ct-series-a .ct-line {
                stroke: #EA495F;
            }
            .ct-series-a .ct-point {
                stroke: #EA495F;
            }
            .ct-label {
                fill: rgba(0, 0, 0, 0.4);
                color: rgba(234, 73, 95, 1);
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                line-height: 1;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
    	<div id="header">
    		<span>Dashboard</span>
    	</div>
    	<div id="content">
    		<div class="aside">
    			<div class="aside-icon"></div>
    			<div class="aside-main">
    				<div class="info">
    					<div class="info-container">
    						<div class="info-box"><span><?php echo $_SESSION['level']; ?></span></div>
    						<div class="info-text">
                            <?php switch ($_SESSION['level']) {
                                case "4":
                                    echo "<span>ADMIN</span>";
                                    echo "<span>SERVER</span>";
                                    break;
                                case "3":
                                    echo "<span>SUB</span>";
                                    echo "<span>ADMIN</span>";
                                    break;
                                case "2":
                                    echo "<span>USER</span>";
                                    echo "<span>BIASA</span>";
                                    break;
                                case "1":
                                    echo "<span>USER</span>";
                                    echo "<span>TAMU</span>";
                                    break;
                            }
    						?>
    						</div>
    					</div>
    				</div>
    				<div class="list">
    					<ul>
    						<li class="selected"><a href="#">STATISTIK</a></li>
    						<li class="dummy"></li>
    						<li><a href="point/">POINT</a></li>
    						<li><a href="nonatero/">NONATERO</a></li>
    						<li><a href="rock/">ROCK</a></li>
    						<li class="dummy"></li>
    						<li><a href="server/">SERVER</a></li>
    						<li><a href="../include/login/logout.php">LOGOUT</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    		<div class="content">
    			<div class="content-header">
    				<div class="header-main">
    					<h2>Statistik Gangguan</h2>
    					<h1>Nonatero</h1>
    					<h2>Telkom Makassar</h2>
    				</div>
    				<div class="header-option remove"><a href="#">HELLO</a>
    				</div>
    			</div>
    			<div class="content-option"></div>
    			<div class="content-main">
<div class="ct-chart ct-major-eleventh"></div>
                        <script>
                            var data = {
                            labels: [<?php 
if ($stmt = $que_nona->prepare("SELECT DATE(TANGGAL) AS TANGGAL, COUNT(TROUBLE_NO) AS GANGGUAN FROM " . $t_nona_h . " GROUP BY DATE(TANGGAL)")){

    $stmt->execute();   // Execute the prepared query.
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        $parsed_date = date_format(date_create($row['TANGGAL']), "d M");
        echo "'" . $parsed_date . "',";

    }
    echo "], series: [[";

    $result->data_seek(0);
    while($row = $result->fetch_assoc()) {
        echo $row['GANGGUAN'] . ",";
    }

    $stmt->free_result();
    $stmt->close();
}
?>
  ]]
};
var option = { 
    plugins: [ Chartist.plugins.tooltip() ],
    lineSmooth: false,
    fullWidth: true,
    chartPadding: {
    top: 30,
    right: 25,
    bottom: 5,
    left: 10
  },
};
new Chartist.Line('.ct-chart', data, option);
</script>
    			</div>
    		</div>
    		<input type="checkbox" name="check" class="altbar-cbox" id="toggle">
    		<label for="toggle" class="altbar-toggle"><span>+</span></label>
    		<div class="altbar">
    			<div class="altbar-menu">
    				<ul>
                            <li class="selected"><a href="#">STATISTIK</a></li>
                            <li class="dummy"></li>
                            <li><a href="point/">POINT</a></li>
                            <li><a href="nonatero/">NONATERO</a></li>
                            <li><a href="rock/">ROCK</a></li>
                            <li class="dummy"></li>
                            <li><a href="server/">SERVER</a></li>
                            <li><a href="../include/login/logout.php">LOGOUT</a></li>
    				</ul>
    			</div>
    		</div>
    	</div>
    </body>
</html>
<?php

    mysqli_close($que_nona);
    mysqli_close($que_dash);

?>