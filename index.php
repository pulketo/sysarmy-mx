<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<HTML><HEAD><TITLE>sysarmy - Support for those who give support</TITLE>
		<link rel="shortcut icon" href="favicon.png" />
		<meta name='keywords' content='sysadmin, systems administrator, linux, unix, solaris, freebsd, openbsd, aix, hp-ux, system administrator' />
		<meta name='description' content='sysarmy - Argentinian SysAdmin Community.' />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!--[if IE 6]>n
		<html id="ie6" dir="ltr" lang="es-ES" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns" xmlns:fb="http://ogp.me/ns/fb">
		<![endif]-->
		<!--[if IE 7]>
		<html id="ie7" dir="ltr" lang="es-ES" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns" xmlns:fb="http://ogp.me/ns/fb">
		<![endif]-->
		<!--[if IE 8]>
		<html id="ie8" dir="ltr" lang="es-ES" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns" xmlns:fb="http://ogp.me/ns/fb">
		<![endif]-->
		
		
		<meta charset="UTF-8" />
		<meta property="fb:admins" content="todo" />
		<meta property="og:description" content="Manpage for the Mexican SysAdmin Community." />
		<meta property="og:image" content="todo" />
		<meta property="og:site_name" content="SysArmyMX" />
		<meta property="og:title" content="sysarmy - Support for those who give support" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="todo" />
		<link rel="stylesheet" type="text/css" href="styles.css" />
		
		<meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:site" content="todo">
                <meta name="twitter:creator" content="todo">
                <meta name="twitter:title" content="todo">
                <meta name="twitter:description" content="sysarmyMX is the Mexicano SysAdmin Community, who brings together all IT professionals for knowledge exchange and fun. /j us ! ##sysarmy-en @ freenode">
                <meta name="twitter:image:src" content="todo">

    <!-- jquery term -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link href="term/jquery.terminal-1.4.2.css" rel="stylesheet"/>
    <link href="term/css/monof55.css" rel="stylesheet"/>
    <script src="term/jquery.terminal-1.4.2.min.js"></script>
    <script src="term/jquery.mousewheel-min.js"></script>
    <script>
	jQuery.fn.simulateClick = function() {
	    return this.each(function() {
	        if('createEvent' in document) {
	            var doc = this.ownerDocument,
	                evt = doc.createEvent('MouseEvents');
	            evt.initMouseEvent('click', true, true, doc.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
	            this.dispatchEvent(evt);
	        } else {
	            this.click(); // IE Boss!
	        }
	    });
	}    
    jQuery(function($, undefined) {
    $('#term_demo').terminal(function(command, term) {
        term.pause();
        $.post('term/cmd.input.php', {command: command}).then(function(response) {
            var jsonResponse = jQuery.parseJSON(response);
            if (jsonResponse.action == "gotoblank"){               
                term.echo("opening... (click to open manually)"+$("#"+jsonResponse.message).attr('href')).resume();
                $( "#"+jsonResponse.message ).simulateClick('click');

            }
            if (jsonResponse.action == "goto"){               
                term.echo("opening... (click to open manually)"+$("#"+jsonResponse.message).attr('href')).resume();
                $( "#"+jsonResponse.message ).simulateClick('click');
            }
            if (jsonResponse.action == "echo"){               
                term.echo(jsonResponse.message).resume();
            }
            if (jsonResponse.action == "error"){               
                term.error(jsonResponse.message).resume();
            }
            if (jsonResponse.action == "exec"){
                switch(jsonResponse.message) {
                    case "freeze":
                        term.echo("freezed").resume();
                        term.freeze(true);
                        break;
                    case "unfreeze":
                        term.echo("unfreezed").resume();
                        term.freeze(false);
                        break;
//                  default:
                }                                
                term.error(jsonResponse.message).resume();
            }
        });
    }, {
        greetings: 
"",
        name: 'SysArmyMX',
        height: '95%',
        prompt: 'SysArmySH> '
    });
    });

    </script>
    <!-- jquery term --> 

</HEAD>
<BODY style="height:100%;">
<!--Analytics-->
<div id="term_demo" style="background:transparent;z-index:10000;position:fixed;top:30px;width:100%;">
</div> 
<script>
$( document ).ready(function() {
    jQuery("#term_demo").terminal().exec("login");
});
</script>
<div style="postion:fixed;top:0px;left:30px;" id="valid-urls">
	<ul>
		<li><a id="normaluser" href="//sysarmy.mx/index.html">html</a></li>		
		<li><a target="_BLANK" id="irc" href="//webchat.freenode.net/?channels=#sysarmymx">irc</a></li>
</div>
</HTML>
 

