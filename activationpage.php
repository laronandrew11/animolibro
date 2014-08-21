<?php
include_once('php/animolibroerrorhandler.php');
require_once("php/db_config.php");

$passkey = $_GET['passkey'];
$db = database::getInstance(); 
$sql = $db->dbh->prepare("UPDATE UserAccount SET com_code=:comcode WHERE com_code=:passkey");
$sql->bindValue(':comcode', null, PDO::PARAM_NULL);
$sql->bindValue(':passkey', $passkey, PDO::PARAM_STR);

//$sql = "UPDATE UserAccount SET com_code=NULL WHERE com_code='$passkey'";
//$result = mysql_query($sql) or die(mysql_error());
if($sql->execute()) {
	session_start();
	$_SESSION['accountactivated'] = true;
	header("location: http://localhost/animolibro/login_page.php");
}
else {
	$_SESSION['accountactivated'] = false;
	echo "Some error occurred.";
}
?>