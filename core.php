<?php
// Welcome to the core file
// this is where you can find all important setting of mome

// edit these as desired, 
// but, leave the "core" intouched,
// unless you know what you're doing ;)

// -- core settings
// path to the default directory
$GLOBALS["CORE_default_path"] = "saved/";
// change the core admin username
$GLOBALS["CORE_admin_username"] = "admin";
// insert here your password
$GLOBALS["CORE_admin_password"] = "admin";
// default users
$GLOBALS["CORE_list_of_users"] = array(
      $GLOBALS["CORE_admin_username"] => $GLOBALS["CORE_admin_password"],
      // if you wish, add users and passwords here
      // NOTE: all rows except last must have comma "," at the end of line
      'guest' => 'guest',
      'testing' => 'testing'
      );
// your full name, not required
$GLOBALS["CORE_full_name"] = "Filip Vincůrek";

// these files and folders will NOT be listed
$GLOBALS["CORE_black_list"] = array('index.php', 'undefined.md', 'undefined');
// 
//
// Core functions, some with case switch for calling from javascript
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

// call needed function (for javascript calls)
if (!empty($_POST['do'])){
// save file
function saveFile(){
	if(!empty($_POST['filename'])){
		
		$filename = $_POST['filename'].".md";
		$data = $_POST['data'];
		$pathtosave = $_POST['pathtosave'];

		if (isset($userfolder)){ $userfolder = $userfolder.'/'; };

		$file = fopen($pathtosave."/".$filename, 'w');
		fwrite($file, $data);
		fclose($file);		
	}
}

// delete file
function deleteFile(){
	if(!empty($_POST['filename'])){
		$fileName = $_POST['filename'].".md";
		$pathToFile = $_POST['pathToFile'].'/'; 
		unlink($pathToFile.$fileName);
	}
}
// add secure.txt with username and password
function secureFolder(){
	$filename = "secure.txt";
	$data = "username:password;\n";
	$pathtosave = $_POST['pathtosave'];

	if (isset($userfolder)){ $userfolder = $userfolder.'/'; };
	$file = fopen($pathtosave."/".$filename, 'w');
	fwrite($file, $data);
	fclose($file);
}
// create new directory
function createDir(){
	
	$newdirpath = $_POST['folderpath'];
	if (!mkdir($newdirpath, 0777, true)) {
	    die('Failed to create folders...');
	}
}
// delete directory with all the files
function deleteDir($dir) {
	$files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      delTree("$dir/$file");
      unlink("$dir/$file");
      rmdir($dir);
    } 
} 
function listFolderFiles($dir){
	$exclude = $GLOBALS["CORE_black_list"];
    $ffs = scandir($dir);
    // show file list
    echo "<ul class='list_files' id='".$dir."'>";
    foreach($ffs as $ff){
	    if(is_array($exclude) and !in_array($ff,$exclude)){
	        if($ff != '.' && $ff != '..'){
	            
	            $trim_dir = $dir.$ff;
	            $trimmed_dir = ltrim($trim_dir, "/.");
	        	
	        	if (isset($_COOKIE['verify'])) {
	        	// this is shown when user is logged in	
			        if(!is_dir($dir.'/'.$ff)) {
			            $info = pathinfo($ff);
			            $file_name =  basename($ff,'.'.$info['extension']);
			            echo '<li id="'.$trimmed_dir.'" class="file-title">';
			            // show the delete button
			            echo '<a href="#" onClick=\'deleteFile("'.$file_name.'", "'.$dir.'")\'>';
			            echo '<svg version="1.1" id="delete_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">';
						echo '<polygon class="delete_icon_cross" points="17.778,4.343 15.657,2.222 10,7.879 4.343,2.222 2.222,4.343 7.879,10 2.222,15.657 4.343,17.778 10,12.121 15.657,17.778 17.778,15.657 12.121,10 "/>';
						echo '</svg></a> - ';
						// end of delete button
			            echo '<a href="#" onClick=\'loadFile("'.$file_name.'", "'.$dir.'")\'>'.$ff.'</a>'; 
		            } else {
		                if ($ff == "default"){ echo '<span style="color: red;">'; }
		                echo '<li onClick="setActiveFolder(\''.$trimmed_dir.'\',\''.$dir.'/'.$ff.'\')" class="folder-title">';
						// show the delete button
			            echo '<a href="#" onClick=\'deleteFolder("'.$dir.'/'.$ff.'")\'>';
			            echo '<svg version="1.1" id="delete_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">';
						echo '<polygon class="delete_icon_cross" points="17.778,4.343 15.657,2.222 10,7.879 4.343,2.222 2.222,4.343 7.879,10 2.222,15.657 4.343,17.778 10,12.121 15.657,17.778 17.778,15.657 12.121,10 "/>';
						echo '</svg></a> - ';
						// end of delete button
		                echo '<strong>'.$ff.'</strong><span style="font-size: 0.8em;"> ['.$dir.'] </span></li>'; 
		                if ($ff == "default"){ echo '</span>'; } 
		            }
		        }else{
		        	// this is shown for guest
		        	if(!is_dir($dir.'/'.$ff)) {
			            $info = pathinfo($ff);
			            $file_name =  basename($ff,'.'.$info['extension']);
			            echo '<li>';
			            echo '<a href="#" onClick=\'loadFile("'.$file_name.'", "'.$dir.'")\'>'.$ff.'</a>'; 
		            } else {
		                echo '<li onClick="setActiveFolder(\''.$ff.'/'.$dir.'\')" class="folder-title" id="'.$dir.'/'.$ff.'"><strong>'.$ff.'</strong><span style="font-size: 0.8em;"> ['.$dir.'] </span></li>'; 
		            }
		        };
	            	$one_level_back = dirname($dir);
	            	//$one_level_back = substr($dir, 0, -1);
	            	if(is_dir($dir.'/'.$ff)){ listFolderFiles($dir.'/'.$ff, $trimmed_dir); }
	            echo '</li>';
    	    }
    	}
    	
    	

    }
    echo '</ul>';
	}

	// DO WHAT WE NEED
	$do = $_POST['do'];
	switch ($do) {
	  	case "savefile":
	  		saveFile();
	        break;
		case "deletefile":
	        deleteFile();
	        break;
	    case "createdir":
	    	$newdir = $_POST['folderpath'];
	        createDir($newdir);
	        break;
	    case "listfiles":
	    	$newdir = $_POST['newdir'];
	        listFolderFiles($newdir);
	        break;
	    case "deletedir":
	    	$dirPath = $_POST['dirpath'];
	    	deleteDir($dirPath);
	    	break;
	}
}

// get userfolder if logged
function getCookie($cookie_name){
	if (isset($_COOKIE[$cookie_name])) {
		$cookie[$cookie_name] = $_COOKIE[$cookie_name];
			return $cookie[$cookie_name];
		}else {
			$cookie[$cookie_name] = 'Cookie "'.$cookie_name.'" isn\'t set.';
			return $cookie[$cookie_name];
		};
	}
?>