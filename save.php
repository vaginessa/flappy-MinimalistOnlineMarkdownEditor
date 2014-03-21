<?php
if(!empty($_POST['data'])){
$data = $_POST['data'];
$sendname = $_POST['name'].".md";

if ($_POST['subFolder'] != ""){
$subfolder = $_POST['subFolder']."/"; 
};

$file = fopen("saved/".$subfolder.$sendname, 'w');
fwrite($file, $data);
fclose($file);
}
?>