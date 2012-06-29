<?php

function printr($var) {
    
    echo "<pre>\n";
    print_r($var);
    echo "</pre>\n";
    
}

function debug($msg){
    if ($_REQUEST['debug']){
        printr($msg);    
    }
}

function isValid($url) {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);

}

function makeThumb($file) {
    $absFilePath = ABSOLUTE_PATH.'pics/'.$file;
    debug("file: " . $file);
    if (file_exists($absFilePath) ){
        debug( "converting ".$absFilePath); 
        $convertLine =" convert -thumbnail 500\> " .$absFilePath . "  pics/thumbs/".$file ;

        debug( $convertLine );
        exec ($convertLine);
    }
}

function crop9gag($absolutePath){
    if (file_exists($absolutePath)){
        $convertLine =" convert " .$absolutePath . " -gravity South  -chop  0x40 ".$absolutePath;    
        debug($convertLine);
        exec($convertLine);
    }    
}


?>
