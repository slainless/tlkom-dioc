 <?php
	require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
	require $p_svropt;
	require $p_cnona;

	require $p_inc . "database/fetch_setting.php";

    $close = false;

    if(!isset($_POST["uf"])){
        $uf = false;
    }
    else {
        $uf = true;
    }

    if(!isset($_POST["ut"])){
        $ut = 0;
    }
    else {
        $ut = $_POST["ut"];
    }

    $f_nona = "fetch_nona_data.php";
    $f_plg = "fetch_nona_plg.php";

    $l_all = "load_alldata.php";
    $l_plg = "load_plgdata.php";

    switch ($ut) {
        case '1':
            if(!include $f_nona){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_nona . " NOT FOUND";
            }
            if(!include $f_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_plg . " NOT FOUND";
            }
            break;
        case '2':
            if(!include $l_all){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_all . " NOT FOUND";
            }
            if(!include $l_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_plg . " NOT FOUND";
            }
            break;
        case '3':
            if(!include $f_nona){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_nona . " NOT FOUND";
            }
            if(!include $f_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $f_plg . " NOT FOUND";
            }
            if(!include $l_all){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_all . " NOT FOUND";
            }
            if(!include $l_plg){
                $c_text = "[ERROR&nbsp;&nbsp;] FILE " . $l_plg . " NOT FOUND";
            }
            break;
        default:
            # code...
            break;
    }

?>
 <html>
    <head>
        <title> | Nonatero </title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../styles/main.css" />
        <link rel="stylesheet" href="../styles/reset.css" />

        <link rel="stylesheet" href="../styles/font-awesome.css" />
        <style>
        <?php if($ut == 2 || $ut = 3): ?>
        .console {
            overflow-y: scroll;
            height: 258px;
        }
        <?php endif ?>
        </style>
    </head>
    <body>
    	<div id="wrapper">
    		<div class="header">
    			<span>dioc / nonatero / advance.php</span>
    			<div class="wrapper">
    				<input type="text" placeholder="cari tiket"></input>
    			</div>
    		</div>
    		<div class="body">
    			<div class="main nonatero advance">
    				<div>
                    <?php if(!$uf): ?>
    					<div class="info">
    						<span class="name">
    							<span>update manual</span>
    							<span>database nonatero</span>
    						</span>
    					</div>
                    <?php else: ?>
                        <div class="console">
                            <?php echo $c_text; ?>
                        </div>
                    <?php endif ?>
    				</div>
    				<div>
                        <form action="" method="POST" id="console" class="hidden">
                            <input type="hidden" name="uf" value="1">
                        </form>
                        <div class="btn-list">
                            <button href="#" class="btn reverse" type="submit" form="console" value="1" name="ut">
                                <span>fetch data</span>
                            </button>
                            <button href="#" class="btn reverse" type="submit" form="console" value="2" name="ut">
                                <span>update database</span>
                            </button>
                            <button href="#" class="btn" type="submit" form="console" value="3" name="ut">
                                <span>all update</span>
                            </button>
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
