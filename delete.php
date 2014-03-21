
<?php
if(!empty($_POST['name'])){
$fileName = $_POST['name'];

if ($_POST['subFolder'] != ""){
$subfolder = $_POST['subFolder'].'/'; 
};

unlink("saved/".$subfolder.$fileName.".md");
/*
$old = getcwd(); // Save the current directory
chdir("saved/".$subfolder);
unlink($fileName);
chdir($old); // Restore the old working directory */
}
?>