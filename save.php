<?php
if(!empty($_POST['data'])){
$data = $_POST['data'];
$sendname = $_POST['name'];
$fname = $sendname.".md";//generates random name

$file = fopen("saved/" .$fname, 'w');//creates new file
fwrite($file, $data);
fclose($file);
}
?>