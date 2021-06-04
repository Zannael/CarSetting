
<?php 
session_start();
if (isset($_SESSION['session_user'])) { 

header("location: ./garage.php");
}
else {header("location:./login.html");}

?>
