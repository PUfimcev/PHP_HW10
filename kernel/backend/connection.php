<?php 

$config = parse_ini_file('config/config.ini');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli = new mysqli($config['host'], $config['login'], $config['pass'], $config['db']);
