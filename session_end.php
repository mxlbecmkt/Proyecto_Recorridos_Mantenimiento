<?
	session_name("admin_pad");
 	$_SESSION = array();
	session_start();
	session_destroy();
	setcookie('idusradmin', "", time() - 3600);
	setcookie('nombreadmin', "", time() - 3600);
	setcookie('mailadmin', "", time() - 3600);
	setcookie('noempleadoadmin', "", time() - 3600);
	setcookie('moduloadmin', "", time() - 3600);
	setcookie('cookiesonadmin', "", time() - 3600);
	Header ("Location:../unlock-devos.php");
?>