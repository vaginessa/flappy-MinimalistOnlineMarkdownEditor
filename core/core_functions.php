<?php
// check if we're logged in
function checkLogin(){
	// check for privileges
	if (isset($_COOKIE['username_log'])) {
		$loggedas = $_COOKIE['username_log'];
		echo "Folder: <strong>".$loggedas."</strong><br />";
		echo '<a href="index.php?logout=1">Logout</a>';
	}else{
		echo "You are here as Guest<br />";
	};
	include(str_replace('\\','\\\\','')."password_protect.php");
}

// get userfolder if logged
function getUserName(){
	if (isset($_COOKIE['username_log'])) {
		$userfolder = $_COOKIE['username_log'];
		}else{
		$userfolder = '';
	};
	return $userfolder;
}
?>