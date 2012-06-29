<?php
require_once 'Pic.php';
require_once 'functions.php';

class Pics {

    private $pics;

    static public function getTotalNumOfPages(){
    
        $sql = "SELECT id FROM pictures";
        return ceil( mysql_num_rows(mysql_query($sql)) / PICS_PER_PAGE);

        
    }
    static public function md5Exists($md5){
        
        if (empty($md5)) {
            return false;    
        }

        $sql = "SELECT md5 FROM pictures where md5 = '".$md5."'";    
        if ( mysql_num_rows(mysql_query($sql)) > 0){
            return true;    
        }

        return false;
    }

    public function __construct(){
        
        
    }

    public function getLatest($number){
        
        $limit = (int)$number; 

        $sql = " SELECT * FROM pictures ORDER BY insertDate DESC Limit ". $limit;
        $res = mysql_query($sql);
        
        $pics = array();

        while($row = mysql_fetch_assoc($res)) {
        
            $pic = new Pic();
            $pic->setId($row['id'])
                ->setFilename($row['filename'])
                ->setFileExtension($row['fileExtension'])
                ->setInsertDate($row['insertDate'])
                ->setUploader($row['uploader'])
                ->setSource($row['source'])
                ->setMd5($row['md5']);
            $pics[] = $pic;
            
        }
        return $pics;
        
    }
    public function getByPageNumber($number){
        
        $offset = (int)$number * PICS_PER_PAGE;

        $sql = " SELECT * FROM pictures ORDER BY insertDate DESC Limit ". $offset .",".PICS_PER_PAGE;
        $res = mysql_query($sql);
        
        $pics = array();

        while($row = mysql_fetch_assoc($res)) {
        
            $pic = new Pic();
            $pic->setId($row['id'])
                ->setFilename($row['filename'])
                ->setFileExtension($row['fileExtension'])
                ->setInsertDate($row['insertDate'])
                ->setUploader($row['uploader'])
                ->setSource($row['source'])
                ->getMd5($row['md5']);
            $pics[] = $pic;
            
        }
        return $pics;
        
    }

    public function getAll(){
    
        $sql = " SELECT * FROM pictures ORDER BY insertDate ASC";
        $res = mysql_query($sql);
        
        $pics = array();

        while($row = mysql_fetch_assoc($res)) {
        
            $pic = new Pic();
            $pic->setId($row['id'])
                ->setFilename($row['filename'])
                ->setFileExtension($row['fileExtension'])
                ->setInsertDate($row['insertDate'])
                ->setUploader($row['uploader'])
                ->setSource($row['source'])
                ->getMd5($row['md5']);
            $pics[] = $pic;
            
        }
        return $pics;
        
    }

    
}
