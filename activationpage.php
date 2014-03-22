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
	echo '<div>Your account is now active. You may now <a href="login_page.html">Log in</a></div>';
}
else
{
	echo "Some error occurred.";
}
?>