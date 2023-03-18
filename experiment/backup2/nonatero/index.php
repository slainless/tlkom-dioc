 <?php
	require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
	require $p_svropt;
	require $p_cnona;

	require $p_inc . "database/fetch_setting.php";

	if(!isset($debug)){
		$debug = FALSE;
	}

	$process = "SELECT * FROM " . $t_stat . "";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($dummy, $nonatero, $cmdf, $rock, $dewa, $plasa, $rihana, $nona_h, $rock_h);

		$stmt->fetch();
		$stmt->close();
	}
	else
	{
		if($debug == TRUE){
			echo "ERROR, QUERY -> $process, will exit now";
		}
		exit();
	}

	mysqli_close($que_nona);
?>
 <html>
    <head>
        <title> | Nonatero </title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../styles/main.css" />
        <link rel="stylesheet" href="../styles/reset.css" />

        <link rel="stylesheet" href="../styles/font-awesome.css" />
    </head>
    <body>
    	<div id="wrapper">
    		<div class="header">
    			<span>dioc / nonatero</span>
    			<div class="wrapper">
    				<input type="text" placeholder="cari tiket"></input>
    			</div>
    		</div>
    		<div class="body">
    			<div class="main nonatero">
    				<div>
    					<div class="info">
    						<span class="name">
    							<span>database nonatero</span>
    							<span>12 desember 2016, 12:32</span>
    						</span>
    					</div>
    					<div class="btn-list">
    						<a href="#" class="btn reverse">
    							<div>history</div>
    						</a>
    						<a href="#" class="btn reverse">
    							<div>current</div>
    						</a>
    						<a href="#" class="btn reverse">
    							<div>cmdf</div>
    						</a>
    					</div>
    				</div>
    				<div>
    					<a href="advance.php" class="btn">
    						<div>advance option</div>
    					</a>
						<div class="block-wrapper-large">
							<div class="s-block">
								<span><span><?php echo $nonatero; ?></span></span>
								<div class="block-info">
									<span>nonatero</span>
								</div>
							</div>
							<div class="s-block">
								<span><span><?php echo $nona_h; ?></span></span>
								<div class="block-info">
									<span>history</span>
								</div>
	    					</div>
						</div>
    				</div>
    			</div>
    			<div class="sidebar">
    				<ul>
    					<li><a href="../"><i class="fa fa-bar-chart"></i></a></li>
    					<li><a href="../rock/"><i class="fa fa-home"></i></a></li>
    					<li class="selected"><a><i class="fa fa-database"></i></a></li>
                        <li><a href="../point/"><i class="fa fa-hashtag"></i></a></li>
                        <li><a href="../server/"><i class="fa fa-gears"></i></a></li>
                        <li><a href="../../include/login/logout.php"><i class="fa fa-times"></i></a></li>
    				</ul>
    				<ul>
    					<li><a href="<?php $_SERVER['HTTP_REFERER']; ?>"><i class="fa fa-chevron-left"></i></a></li>
    				</ul>
    			</div>
    		</div>
    	</div>
    </body>
</html>
