<?php
function listFolderFiles($dir,$exclude){
    if (isset($_COOKIE['username_log'])) {
        $loggedas = $_COOKIE['username_log'];
        $dir = $dir.'/'.$loggedas;
        $ffs = scandir($dir);
    }else{
        $ffs = scandir($dir);
    };

    echo '<h3>"'.$dir.'" folder.</h3>';
    echo '<ul class="list_files">';
    foreach($ffs as $ff){
        if(is_array($exclude) and !in_array($ff,$exclude)){
            if($ff != '.' && $ff != '..'){
            if(!is_dir($dir.'/'.$ff)){
                $info = pathinfo($ff);
                $file_name =  basename($ff,'.'.$info['extension']);
                // check for privileges
                echo '<li>';
                    if (isset($loggedas)) {
                        echo '<a href="#" onClick=\'deleteFile("'.$file_name.'", "'.$loggedas.'")\'>';
                        echo '<svg version="1.1" id="delete_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="12px" height="12px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
<polygon class="delete_icon_cross" points="17.778,4.343 15.657,2.222 10,7.879 4.343,2.222 2.222,4.343 7.879,10 2.222,15.657 4.343,17.778 10,12.121 
    15.657,17.778 17.778,15.657 12.121,10 "/>
</svg>';
                        echo '</a> - ';
                    };
                echo '<a href="#" onClick=\'loadFromFile("'.$file_name.'")\'>'.$ff.'</a>'; 
            } else {
                echo '<li>'.$ff;   
            }
                //if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff,$exclude);
                //echo '</li>';
            }
        }
    }
    echo '</ul>';
}
listFolderFiles('./saved',array('index.php','edit_.php', 'admin'));
?>