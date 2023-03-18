<?php

$filter = file_get_contents("../cron/log.html");
$filter = substr($filter, 17, 17);
echo $filter;

?>