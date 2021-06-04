<?php
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
session_start();
include_once './dbh.inc.php'; 

$rating = $_POST['rating'];
$idval = $_POST['idval'];
$sql_query = 'update valutazioni set rating = '.$rating.' WHERE id = '.$idval.';';
$result = mysqli_query($conn, $sql_query);
$resultCheck = mysqli_num_rows($result);