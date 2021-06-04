<?php
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
session_start();
include_once './dbh.inc.php'; 

$sql_query = '
DELETE FROM Preventivi
WHERE emailutente = "'.$_SESSION['session_user'].'"
AND
nomeauto = "'.htmlentities($_POST['scopriAuto']).'" AND nomebrand ="'.htmlentities($_POST['scopriBrand']).'"
';

$result = mysqli_query($conn, $sql_query);
header("location:../garage.php");