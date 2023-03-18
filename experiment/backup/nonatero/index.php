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
    } else {
        header("Location: " . $p_dsh . "login/");
    }
?>

<html>
    <head>
        <title><?php echo $_SESSION['username']; ?> | Database Nonatero </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../styles/main.css" />
        <link rel="stylesheet" href="../styles/responsive.css" />
        <link rel="stylesheet" href="../styles/menu.css" />
        <link rel="stylesheet" href="../../include/styles/reset.css" />

        <link rel="stylesheet" href="../styles/font.css" />

        <link rel="icon" type="image/png" href="../../favicon.ico" sizes="32x32" />
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
    						<li><a href="../">STATISTIK</a></li>
    						<li class="dummy"></li>
    						<li><a href="../point/">POINT</a></li>
    						<li class="selected"><a href="#">NONATERO</a></li>
    						<li><a href="../rock/">ROCK</a></li>
    						<li class="dummy"></li>
    						<li><a href="../server/">SERVER</a></li>
    						<li><a href="../../include/login/logout.php">LOGOUT</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    		<div class="content">
    			<div class="content-header">
    				<div class="header-main">
    					<h2>Database</h2>
    					<h1>Nonatero</h1>
    					<h2>Telkom Makassar</h2>
    				</div>
    				<div class="header-option remove"><a href="#">HELLO</a>
    				</div>
    			</div>
    			<div class="content-option"></div>
    			<div class="content-main">
    				<a class="btn-stretch-fullside" href="current.php">


    					<div class="half-left">
    						<div class="sub-left">
    							<span>Table</span>
    							<span>Current</span>
    						</div>
    						<div class="sub-right">
    							<span>Update terakhir</span>
    							<span><?php echo $update; ?></span> <!-- 14 Nov 2016, 12:15 / GGN 425 -->
    						</div>
    					</div>
    					<div class="half-right">
    						<span><span>Jumlah </span>gangguan</span>
    						<span><?php echo $ggn; ?></span> 
    					</div>
    				</a>
    				<div class="container">
    					<a class="btn-half-fulldown" href="#">
    						<div class="half-top">
    							<span>Table</span>
    							<span>History</span>
    						</div>
    						<div class="half-bottom">
    							<span>Jumlah gangguan</span>
    							<span><?php echo number_format($ggn_h); ?></span>
    						</div>
    					</a>
    					<div class="btn-half-wrapper">
    						<div class="btn-quad">
    							<a class="btn-small" href="#">
    								<div>
    									<span>TABLE</span>
    									<span>VIP</span>
    								</div>
    							</a>
    							<a class="btn-small" href="#">
    								<div>
    									<span>EKSEKUSI</span>
    									<span>MANUAL</span>
    								</div>
    							</a>
    						</div>
    						<div class="btn-quad">
    							<a class="btn-small hidden">
    							</a>
    							<a class="btn-small" href="#">
    								<div>
    									<span>TABLE</span>
    									<span>CMDF</span>
    								</div>
    							</a>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<input type="checkbox" name="check" class="altbar-cbox" id="toggle">
    		<label for="toggle" class="altbar-toggle"><span>+</span></label>
    		<div class="altbar">
    			<div class="altbar-menu">
    				<ul>
                            <li><a href="../">STATISTIK</a></li>
                            <li class="dummy"></li>
                            <li><a href="../point/">POINT</a></li>
                            <li class="selected"><a href="#">NONATERO</a></li>
                            <li><a href="../rock/">ROCK</a></li>
                            <li class="dummy"></li>
                            <li><a href="../server/">SERVER</a></li>
                            <li><a href="../../include/login/logout.php">LOGOUT</a></li>
    				</ul>
    			</div>
    		</div>
    	</div>
    </body>
</html>
