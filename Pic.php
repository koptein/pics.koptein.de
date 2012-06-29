<?php

class Pic {

    private $filename;
    private $id;
    private $fileExtension;
    private $insertDate;
    private $source;
    private $uploader;
    private $md5;

    public function setFilename( $filename ){
    
        $this->filename = $filename;
        return $this;
        
    }
    public function setId( $id ){
    
        $this->id = $id;
        return $this;
        
    }
    public function setUploader( $uploader ){
    
        $this->uploader = $uploader;
        return $this;
        
    }


    public function setFileExtension( $ext ){
    
        $this->fileExtension = $ext;
        return $this;
        
    }
    public function setInsertDate( $insertdate ){
    
        $this->insertDate = $insertdate;
        return $this;
        
    }
    public function setSource($source) {
        $this->source = $source;
        return $this;
    }
    public function setMd5($md5) {
        $this->md5 = $md5;
        return $this;
    }
    public function __construct() {
        
    }
    public function getMd5(){
        return $this->md5;    
    }

    public function getSource(){
        return $this->source;
    }
    public function getFilename(){
        return $this->filename;    
    }
    public function getUploader(){
        return $this->uploader;    
    }
    public function getId(){
        return $this->id;    
    }
    public function getFileExtension(){
        return $this->fileExtension;    
    }
    public function getInsertDate($format = false){
        if (empty($this->insertDate)){
            return date('Y-m-d H:i:s');
        }
        if ($format === false){
            return $this->insertDate;    
        }
        else if ($format == 'rfc'){
            return date('D, d M Y H:i:s O',strtotime($this->insertDate));
        }
    }

    public function save(){
        
        if ((int)$this->getId()>0){
            //Update;
            $sql =  " UPDATE pictures SET  ".
                    " filename='" .$this->getFilename() . "',".
                    " fileExtension='" .$this->getFileExtension() . "',".
                    " insertDate='" .$this->getInsertDate() . "',".
                    " uploader='" .$this->getUploader() . "',".
                    " md5='" .$this->getMd5() . "',".
                    " source='" .$this->getMd5() . "'" . 
                    " WHERE id = " .$this->getId() ;
            mysql_query($sql);
        }
        else {
            //Insert;
            $sql = " INSERT INTO pictures (id , filename, fileExtension, insertDate, uploader, md5, source)  VALUES ('" . 
               $this->getId(). "','" . 
               $this->getFilename() . "','" .
               $this->getFileExtension() . "','" . 
               $this->getInsertDate() . "','" . 
               $this->getUploader() . "','" . 
               $this->getMd5() . "','" . 
               $this->getSource() . "')";
            mysql_query($sql);
            // Fail silently
        }


    }
    public function exists(){
        $sql = "SELECT filename FROM pictures WHERE filename LIKE '" .$this->getFilename()."'";
        $res = mysql_query($sql);
        if (mysql_num_rows($res)) {
            return true;    
        }
        else return false;
    }
    public function getFullFilename() {
        
        return $this->getFilename().".".$this->getFileExtension();

    }
    public function draw() {
        
        echo $this->generateHtml();

    }
    public function generateHtml(){
        $link ="<div class='picinfos'>".$this->generateInfos()." </div>";
        $link .= "<div class='piclink'><a href='pics/".$this->getFullFilename()."'>" . 
                "<img class='actual_picture' src='pics/thumbs/".$this->getFullFilename()."'> </a></div><div class='clear'></div>";
    return $link; 
    }

    public function generateHtmlWithAbsouluteLinks(){
        $link ="<div class='picinfos'>".$this->generateInfos()." </div>";
        $link .= "<div class='piclink'><a href='".URL."pics/".$this->getFullFilename()."'>" . 
                "<img class='actual_picture' src='".URL."pics/thumbs/".$this->getFullFilename()."'> </a></div><div class='clear'></div>";
    return $link; 
    }
    private function generateInfos(){
        
        $text = "Online Seit: ".date('d.m.Y',strtotime($this->getInsertDate()))." <br>";
        $text .= "Uploader: ".$this->getUploader()." <br>";
        $text .= "Quelle: <a href='".$this->getSource()."' target='_blank'>Link</a> <br>";
        
        return $text;
    }


}

