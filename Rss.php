<?php

class Rss {

    private $pics;
    
    public function __construct(){
        
        $container = new Pics();
        $this->pics = $container->getLatest(10);
    }


    public function renderFeed(){
        echo $this->generateHead();
        echo $this->generateAllItems();
        echo $this->generateFooter(); 
    }

    private function generateHead(){
        
        $head = '
        <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
            <channel>
            <atom:link href="'.URL.'/rss.php" rel="self" type="application/rss+xml" />
            <title>Funny Pictures - shamelessly stolen from the interwebs</title>
            <description>Some site to procrastinate</description>
            <copyright>none whatsoever... none of these pics are my work</copyright>
        ';
        return $head;

    }
    private function generateAllItems(){
        $feed = '';
        foreach ($this->pics as $pic) {
                
            $feed .= '
                <item>
                    <title>
                        '.$pic->getInsertDate().'
                    </title>
                    <description><![CDATA[
                    '.$pic->generateHtmlWithAbsouluteLinks().'
                    ]]></description>
                    <link>'.URL.'pics/'.$pic->getFullFilename().'</link> 
                    <guid>'.URL.'pics/'.$pic->getFullFilename().'</guid>
                    <pubDate>'.$pic->getInsertDate('rfc').'</pubDate>
                </item>
            ';

        }
        return $feed;
    }
    private function generateFooter(){
        return '
            </channel>
            </rss>
        ';
    }
}
