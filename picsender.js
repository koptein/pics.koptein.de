// ==UserScript==
// @name       Picsender
// @namespace  http://www.koptein.de/
// @version    0.5
// @description  Sends Pics to pics.koptein.de
// @match      http://*/*
// @copyright  2012+, Christian Koptein
// @require http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js
// @require http://code.jquery.com/ui/1.8.21/jquery-ui.min.js
// ==/UserScript==

$(document).ready(function(){
    // jQuery CSS nachladen:
    
    var link = document.createElement('LINK');
    link.rel = 'stylesheet';
    link.href = 'http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css';
    link.type = 'text/css';
    document.body.insertBefore(link, null);
    
    
    var link ="";
    var img ="";
    // This key must be registered in the pull.php ajax Handler
    var sendkey ="";
    
    $('img').bind('click',function(e){
        if (e.shiftKey) {
            img = $(this).attr('src');
            
            if (img.indexOf('thumbs.4chan.org') != -1) {
                img = 'http:'+$(this).parent().attr('href');
               
            }
            var dialog_div ="<div title='New Picture' id='dialog'></dialog>";
            $(this).append(dialog_div);
            $('#dialog').dialog({
                modal: true,
                width: 850, 
                height: 500,
                buttons: {
                    'Send' : function(){
                        $('#dialog').html('<br><br><br><br><br><br><br><br><center><img src="http://pics.koptein.de/ajax-loader.gif"></center>');
                        $.ajax({
                            url: link,
                            success: function(){
                                $('#dialog').html('<br><br><br><br><br><br><br><br><center>OK</center>');
                            }
                        });
                        console.log(link);
                    },
                    'Close' : function(){
                        $(this).dialog('close');
                    }
                }
            });
            $('#dialog').html('<div style="float: left"><img style="max-width: 500px;" src="'+img+'"></div><div><input type="text" id="title"></div><div style="clear:both"></div>');
            link = 'http://pics.koptein.de/pull.php?debug=true&key=sendkey&pic='+escape(img);
            
            //console.log(link);
            //
            //return false;
        }
       
        
    });
    
});
