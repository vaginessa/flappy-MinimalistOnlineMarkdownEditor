<?php
function listFolderFiles($dir,$exclude){
    $ffs = scandir($dir);
    echo '<ul class="ulli">';
    foreach($ffs as $ff){
        if(is_array($exclude) and !in_array($ff,$exclude)){
            if($ff != '.' && $ff != '..'){
            if(!is_dir($dir.'/'.$ff)){
            
            $info = pathinfo($ff);
            $file_name =  basename($ff,'.'.$info['extension']);

            echo '<li><a href="#" onClick="loadFromFile('.$file_name.')">'.$ff.'</a>'; 
            } else {
            echo '<li>'.$ff;   
            }
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff,$exclude);
            echo '</li>';
            }
        }
    }
    echo '</ul>';
}

listFolderFiles('./saved',array('index.php','edit_page.php'));
?>