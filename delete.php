<?php
if(!empty($_POST['filename'])){

	$fileName = $_POST['filename'].".md";
	$pathToFile = $_POST['pathToFile'].'/'; 

	unlink($pathToFile.$fileName);

/*
$old = getcwd(); // Save the current directory
chdir("saved/".$subfolder);
unlink($fileName);
chdir($old); // Restore the old working directory */

}
?>