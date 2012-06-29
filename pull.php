<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db.php');
require_once('Pics.php');
require_once('functions.php');

// Valid pull-keys:
// Keys are used to authorize the picsender.js Greasemonkeyscript 
// and assign a username to the given Key
// A Ajax-Request to this script without a valid key will not work,
// The key is a unsalted md5hash

$keys = array(
   "Username" => "d41d8cd98f00b204e9800998ecf8427e",
   "Username2" => "3103b91849ccf069e16fd672e72b8483"
    );


if (isset($_GET['pic'])) {
    $_GET['pic'] = urldecode($_GET['pic']);
    if (empty($_GET['key']) || !in_array($_GET['key'],$keys)){
        die('no valid key found');
    }
    else {
        $uploader = array_search($_GET['key'], $keys);
    }
    $extension = "";
    
    $url = explode(".",$_GET['pic']);

    $extension = array_pop($url);
    $name = array_pop(explode('/',array_pop($url)));

    
    
    if (isValid($_GET['pic']) ) {
        // Gif Exception: gif images that ran rough resize look ugly 
        
        

        $pic = new Pic();
        $pic->setFilename($name)
            ->setFileExtension($extension)
            ->setSource($_GET['pic'])
            ->setUploader($uploader);
        $link = $_GET['pic'];
        $pull = 'wget '.$link . '  -O '.ABSOLUTE_PATH.'pics/'.$name.'.'.$extension;
        exec($pull);
        # Special Mode for 9gag pics: They have a footer which is 30px high: 
        # Crop that shit away!
        if (stristr($_GET['pic'],'cloudfront.net')){
            crop9gag(ABSOLUTE_PATH.'pics/'.$name.'.'.$extension);
        }
        debug('ext: ' .$extension);
        
        list($width, $height) = getimagesize(ABSOLUTE_PATH.'pics/'.$name.'.'.$extension);
        if ($extension == 'gif'){
            debug('gif detected');
            
            debug('width: ' .$width);
            debug('height: ' .$height);
            if ($width <= 500){
                // simply copy the file 
                exec('cp '. ABSOLUTE_PATH.'pics/'.$name.'.'.$extension . ' ' . ABSOLUTE_PATH.'pics/thumbs/'.$name.'.'.$extension);
            }
        }
        else {
            makeThumb($name.'.'.$extension);
        }
        if (!$pic->exists()){
            $hash = md5_file(ABSOLUTE_PATH.'pics/'.$name.'.'.$extension);
            if (!Pics::md5Exists($hash)){
                $pic->setMd5($hash);
                $pic->save();
            }
            else{
                echo "File Exists, dont repost";    
            } 
        }
    }
}
