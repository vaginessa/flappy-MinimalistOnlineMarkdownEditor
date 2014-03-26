<?php
function listFolderFiles($dir,$exclude){
    // check if we're logged in
    // if so, add the subfolder path (same as username)
    if (isset($_COOKIE['username_log'])) {
        $loggedas = $_COOKIE['username_log'];
        if ($loggedas !== "admin"){ $dir = $dir.'/'.$loggedas; }
    }else {
        $dir = $dir.'/public';
    };
    $ffs = scandir($dir);
    // show file list
    //echo '<strong>"'.$dir.'" folder.</strong>';
    echo "<ul class='list_files'>";
    foreach($ffs as $ff){
        if(is_array($exclude) and !in_array($ff,$exclude)){
            if($ff != '.' && $ff != '..'){
            if(!is_dir($dir.'/'.$ff)){
                $info = pathinfo($ff);
                $file_name =  basename($ff,'.'.$info['extension']);
                echo '<li>';
                // check for privileges, if logged show the delete button
                if (isset($loggedas)) {
                echo '<a href="#" onClick=\'deleteFile("'.$file_name.'", "'.$dir.'")\'>';
                echo '<svg version="1.1" id="delete_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="12px" height="12px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
    <polygon class="delete_icon_cross" points="17.778,4.343 15.657,2.222 10,7.879 4.343,2.222 2.222,4.343 7.879,10 2.222,15.657 4.343,17.778 10,12.121 
    15.657,17.778 17.778,15.657 12.121,10 "/></svg></a> - ';
                };
                echo '<a href="#" onClick=\'loadFile("'.$file_name.'", "'.$dir.'")\'>'.$ff.'</a>'; 
                } else {
                    if ($ff == "default"){ echo '<span style="color: red;">'; }
                    echo '<span onClick=\'chooseActiveFolder("'.$ff.'"); return false;\' id="'.$ff.'">';
                    echo '<li><strong>'.$ff.'</strong></li>';
                    echo '</span>';  
                    if ($ff == "default"){ echo '</span>'; } 
                }
                if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff,$exclude);
                echo '</li>';
            }
        }
    }
    echo '</ul>';
}
listFolderFiles('./saved',array('index.php', 'undefined.md', 'undefined'));
?>