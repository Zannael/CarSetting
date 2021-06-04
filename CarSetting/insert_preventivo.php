<?php
session_start();
include_once './php/dbh.inc.php'; 

$sql_query = '
insert into preventivi(emailutente, nomeauto, nomebrand, totale, datacreazione, idoptional)
values (
    "'.$_SESSION['session_user'].'",
    "'.htmlentities($_POST['scopriNome']).'",
    "'.htmlentities($_POST['scopriBrand']).'", 
    '.htmlentities($_POST['scopriPrezzo']).', 
    "'.date("Y-m-d").'", 
    '.htmlentities($_POST['scopriOptional']).'
    )
';

echo $sql_query;
/*insert into preventivi(emailutente, nomeauto, nomebrand, totale, datacreazione, idoptional)
values ("mirko", "Fiesta", "Ford", 17050, "2021-05-12", 1);*/

$result = mysqli_query($conn, $sql_query);
header("location:garage.php");