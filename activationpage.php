<?php
$dbHost = "localhost";        //Location Of Database usually its localhost 
$dbUser = "root";            //Database User Name 
$dbPass = "";            //Database Password 
$dbDatabase = "animolibrosimple";    //Database Name 
     
$db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
//Connect to the databasse 
mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
//Selects the database 

$passkey = $_GET['passkey'];
$sql = "UPDATE UserAccount SET com_code=NULL WHERE com_code='$passkey'";
$result = mysql_query($sql) or die(mysql_error());
if($result)
{
session_start();
	$_SESSION['accountactivated']=true;
	header("location: http://localhost/animolibro/login_page.php");
}
else
{
	$_SESSION['accountactivated']=false;
	echo "Some error occurred.";
}
?>