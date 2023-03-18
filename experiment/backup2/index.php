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
        <title> | Summary </title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="styles/main.css" />
        <link rel="stylesheet" href="styles/reset.css" />

        <link rel="stylesheet" href="styles/font-awesome.css" />
    </head>
    <body>
    	<div id="wrapper">
    		<div class="header">
    			<span>dioc / summary</span>
    			<div class="wrapper">
    				<input type="text" placeholder="cari tiket"></input>
    			</div>
    		</div>
    		<div class="body">
    			<div class="main">
    				<div>
    					<div class="info">
    						<img class="avatar" src="http://media.istockphoto.com/vectors/lion-african-animals-stylized-geometric-head-vector-id617568318?s=235x235">
    						<span class="name">
    							<span>muhammad arham</span>
    							<span>admin server</span>
    						</span>
    					</div>
    				</div>
    				<div>
    					<div class="block-wrapper">
							<div class="s-block">
								<span><span><?php echo $dewa; ?></span></span>
								<div class="block-info">
									<span>dewa</span>
								</div>
							</div>
							<div class="s-block">
								<span><span><?php echo $plasa; ?></span></span>
								<div class="block-info">
									<span>plasa</span>
								</div>
							</div>
							<div class="s-block">
								<span><span><?php echo $rihana; ?></span></span>
								<div class="block-info">
									<span>rihana</span>
								</div>
	    					</div>
	    				</div>
    				</div>
    				<div>
						<div class="block-wrapper-large">
							<div class="s-block">
								<span><span><?php echo $nonatero; ?></span></span>
								<div class="block-info">
									<span>nonatero</span>
								</div>
							</div>
							<div class="s-block">
								<span><span><?php echo $rock; ?></span></span>
								<div class="block-info">
									<span>rock</span>
								</div>
							</div>
							<div class="s-block">
								<span><span><?php echo $cmdf; ?></span></span>
								<div class="block-info">
									<span>cmdf</span>
								</div>
	    					</div>
						</div>
    				</div>
    			</div>
    			<div class="sidebar">
    				<ul>
    					<li class="selected"><a><i class="fa fa-bar-chart"></i></a></li>
    					<li><a href="rock/"><i class="fa fa-home"></i></a></li>
    					<li><a href="nonatero/"><i class="fa fa-database"></i></a></li>
                        <li><a href="point/"><i class="fa fa-hashtag"></i></a></li>
                        <li><a href="server/"><i class="fa fa-gears"></i></a></li>
                        <li><a href="../include/login/logout.php"><i class="fa fa-times"></i></a></li>
    				</ul>
    				<ul>
    					<li><i class="fa fa-chevron-left"></i></li>
    				</ul>
    			</div>
    		</div>
    	</div>
    </body>
</html>
