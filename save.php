<?php
if(!empty($_POST['filename'])){
		
	$filename = $_POST['filename'].".md";
	$data = $_POST['data'];

	$pathtosave = $_POST['pathtosave'];

	if (isset($userfolder)){ $userfolder = $userfolder.'/'; };
	$file = fopen($pathtosave."/".$filename, 'w');
	fwrite($file, $data);
	fclose($file);		
}
?>