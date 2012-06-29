<?php 
class Page {
    
    private $offset;
    private $pageNumber;
    private $pics;

    public function __construct($pageNumber){
        $this->setPagenumber($pageNumber);

        $container = new Pics();
        $this->pics = $container->getByPageNumber($this->pageNumber);

    }

    public function setPagenumber($number) {
        $this->pageNumber = (int)$number;
        return $this;
    }
    

    public function renderPage(){
    
        echo $this->generateHeader();
        echo $this->generateBody();
        echo $this->generateFooter();
        
    }

    private function generateHeader(){
        $ret ="
            <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
                   'http://www.w3.org/TR/html4/loose.dtd'>
            <html>
            <head>
                <meta http-equiv='Content-Type' content='text/html;charset=utf-8' >
                <title>
                    pics.koptein.de - fun fun fun
                </title>
            </head>
            <link href='style.css' rel='stylesheet' type='text/css'>
            <link rel='alternate' type='application/rss+xml' title='rss feed' href='".URL."/rss.php' />
            <body>
            <div id='page'>
            <div id='header'><a href='".URL."'><span style='color: #f666;'>pics</span>.koptein.de</a> <a href='rss.php'><img src='rss.png'></a>
            </div>
        ";
        return $ret;
    }
    private function generateBody(){
        foreach ($this->pics as $pic) {
            echo "<div class='picture'>";
            $pic->draw();
            echo "</div>";
        } 
    }
    private function generateFooter(){
        $ret = "";

        if ($this->pageNumber < Pics::getTotalNumOfPages()-1){
            $ret .= $this->generateNextLink();    
        }

        $ret .= "
            </div> ".$this->addPiwikCode()."
            </body>
            </html>
            ";
        return $ret;
    }

    private function generateNextLink() {
        $next = $this->pageNumber+1; 
        $ret = "<div class='picture'><a href='?page=".$next."'>MOAR!</a></div>";

        return $ret;
    }
    private function addPiwikCode(){
    ?>
        <!-- Piwik --> 
        <script type="text/javascript">
        var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.whatsmyipv6.org/" : "http://piwik.whatsmyipv6.org/");
        document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
        </script><script type="text/javascript">
        try {
            var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 7);
            piwikTracker.trackPageView();
            piwikTracker.enableLinkTracking();
        } catch( err ) {}
        </script><noscript><p><img src="http://piwik.whatsmyipv6.org/piwik.php?idsite=7" style="border:0" alt="" /></p></noscript>
        <!-- End Piwik Tracking Code -->
    <?php
    }
}
