<?php
include('php/dbConnect.php');
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