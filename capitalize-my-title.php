<?php
/**
 * @package Capitalize_My_Title
 * @version 1.0
 */
/*
Plugin Name: Capitalize My Title
Plugin URI: http://wordpress.org/plugins/capitalize-my-title
Description: Capitalize your blog titles automatically.
Author: Robert Kania
Version: 1.0
Author URI: http://capitalizemytitle.com/
*/

$captitleversion = '1.0';

//Default settings. Edit them using WP admin Control
$title_type = 'Enabled';

//Install options
add_option('CapMyTitle_type', $title_type, 'Allows guests to vote [Vote It Up]');
if (get_option('CapMyTitle_type') == '') {
	update_option('CapMyTitle_type', $title_type);
}

//Make variables available
if (get_option('CapMyTitle_type') != $title_type) {
	$title_type = get_option('CapMyTitle_type');
}

function CapMyTitle_options() {
	if (function_exists('add_options_page')) {
	add_options_page("Capitalize My Title", "Capitalize My Title", 8, "CapMyTitleconfig", "CapMyTitle_optionspage");
	}
}

function CapMyTitle_Updatecheck() {
global $captitleversion;
//Checks for an update
$fp = fsockopen("www.capitalizemytitle.com", 80, $errno, $errstr, 30) or die('');
if (!$fp) {
    echo "<p>Sorry, but the plugin cannot be checked if it is the latest revision. </p>\n";
} else {
    $out = "GET /wordpressplugin/capitalize-my-title/latest.txt HTTP/1.1\r\n";
    $out .= "Host: www.capitalizemytitle.com\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
$fitm = '';
    while (!feof($fp)) {
        $fitm .= fread($fp, 128);
    }
    fclose($fp);
}
      // strip the headers
      $pos      = strpos($fitm, "\r\n\r\n");
      $response = substr($fitm, $pos + 4);
	$response = (string) $response;
if ($response != $captitleversion) {
	echo '<p>A newer version is available - '.$response.'. Please <a href="https://wordpress.org/plugins/capitalize-my-title" title="Capitalize My Title">update</a>.</p>';
} else {
	echo '<p>You are currently using the latest version.</p>';
}
}




function CapMyTitle_optionspage() {
	switch ($task) {
	case '':
//Options page
?>
<div class="wrap">
<h2><?php _e('Capitalize My Title Options'); ?></h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<p><?php _e('You can configure whether Capitalize My Title is on via this page.'); ?></p>
<h3>Enable Title Capitalization</h3>

<input type="radio" name="CapMyTitle_type" id="CapMyTitle_type" value="Enabled" <?php if (get_option('CapMyTitle_type') == 'Enabled') { echo ' checked="checked"'; } ?> /><?php _e('Enabled'); ?><br />
<input type="radio" name="CapMyTitle_type" id="CapMyTitle_type" value="Disabled" <?php if (get_option('CapMyTitle_type') == 'Disabled') { echo ' checked="checked"'; } ?> /><?php _e('Disabled'); ?></p>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="CapMyTitle_type" />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" />
</p>

</form>
<p style="width:100px;">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
Please visit our online tool at <a href="http://capitalizemytitle.com">capitalizemytitle.com</a> or 
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"  style="margin-bottom:-10px;">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</p>
<br/>
<h3>Version</h3>
<?php CapMyTitle_Updatecheck(); ?>

</div>
<?php
}
}

//Runs the plugin
add_action('admin_menu', 'CapMyTitle_options');





//add_action( 'load-edit.php', 'capitalize_javascript' );

global $pagenow; 
if (! empty($pagenow) && ('post-new.php' === $pagenow || 'post.php' === $pagenow /*|| 'edit.php' === $pagenow*/))
    add_action('admin_enqueue_scripts', 'capitalize_javascript');

add_action( 'post-edit.php', 'capitalize_javascript' );


function capitalize_javascript() {

	global $title_type;
		
	if ($title_type == "Enabled") {

?>
<script>

/*
   * Title Caps
   * 
   * Modified by Robert Kania November 2013 to include prepositions
   * Ported to JavaScript By John Resig - http://ejohn.org/ - 21 May 2008
   * Original by John Gruber - http://daringfireball.net/ - 10 May 2008
   * License: http://www.opensource.org/licenses/mit-license.php
   */
  
  (function(){
    var prepositions = [
      'a',
      'abaft',
      'aboard',
      'about',
      'above',
      'absent',
      'across',
      'afore',
      'after',
      'against',
      'along',
      'alongside',
      'amid',
      'amidst',
      'among',
      'amongst',
      'an',
      'apropos',
      'apud',
      'around',
      'as',
      'aside',
      'astride',
      'at',
      'athwart',
      'atop',
      'barring',                                                                                                                                                                                                                             
      'before',
      'behind',
      'below',
      'beneath',
      'beside',
      'besides',
      'between',
      'beyond',
      'but',
      'by',
      'circa',
      'concerning',
      'despite',
      'down',
      'during',
      'except',
      'excluding',
      'failing',
      'following',
      'for',
      'from',
      'given',
      'in',
      'including',
'inside',
      'into',
      'lest',
      'like',
      'mid',
      'midst',
      'minus',
      'modulo',
      'near',
      'next',
      'notwithstanding',
      'of',
      'off',
      'on',
      'onto',
      'opposite',
      'out',
      'outside',
      'over',
      'pace',
      'past',
      'per',
      'plus',
      'pro',
      'qua',
      'regarding',
      'round',
      'sans',
      'save',
      'since',
      'than',
      'through',
      'thru',
      'throughout',
      'thruout',
      'till',
      'times',
      'to',
      'toward',
      'towards',                                                                                                                                                                                                                             
      'under',
      'underneath',
      'unlike',
      'until',
      'unto',
      'up',
      'upon',
      'versus',
      'vs\.',
      'vs',
      'v\.',
      'v',
      'via',
      'vice',
      'with',
      'within',
      'without',
      'worth'
    ];
    var articles = [
      'a',
      'an',
      'the'
    ];
    var conjunctions = [
      'and',
      'but',
      'for',
      'so',
      'nor',
      'or',
      'yet'
    ];
  
    var punct = "([!\"#$%&'()*+,./:;<=>?@[\\\\\\]^_`{|}~-]*)";

    var all_lower_case = '(' + (prepositions.concat(articles).concat(conjunctions)).join('|') + ')';
    console.log('all lower case', all_lower_case);
    
    window.titleCaps = function(title){
      var parts = [], split = /[:.;?!] |(?: |^)["Ò]/g, index = 0;
      
      while (true) {
        var m = split.exec(title);
  
        parts.push( title.substring(index, m ? m.index : title.length)                                                                                                                                                                       
          .replace(/\b([A-Za-z][a-z.'Õ]*)\b/g, function(all){
            return /[A-Za-z]\.[A-Za-z]/.test(all) ? all : upper(all);
          })
          
          .replace(RegExp("\\b" + all_lower_case + "\\b", "ig"), lower)
          .replace(RegExp("^" + punct + all_lower_case + "\\b", "ig"), function(all, punct, word){
            return punct + upper(word);
          })
          .replace(RegExp("\\b" + all_lower_case + punct + "$", "ig"), upper));
        
        index = split.lastIndex;
        
        if ( m ) parts.push( m[0] );
        else break;
      }
      
      return parts.join("").replace(/ V(s?)\. /ig, " v$1. ")
        .replace(/(['Õ])S\b/ig, "$1s")
        .replace(/\b(AT&T|Q&A)\b/ig, function(all){
          return all.toUpperCase();
        });
    };
      
    function lower(word){
      return word.toLowerCase();
    }
      
    function upper(word){
      return word.substr(0,1).toUpperCase() + word.substr(1);
    }
  })();

  function expand() {
    window.the_rules.className = 'animated';
    window.see_rules.style.display = 'none';
    return false;
  }

function doGetCaretPosition (ctrl) {

    var CaretPos = 0;
    // IE Support
    if (document.selection) {

        ctrl.focus ();
        var Sel = document.selection.createRange ();

        Sel.moveStart ('character', -ctrl.value.length);

        CaretPos = Sel.text.length;
    }
    // Firefox support
    else if (ctrl.selectionStart || ctrl.selectionStart == '0')
        CaretPos = ctrl.selectionStart;

    return (CaretPos);

}


function setCaretPosition(ctrl, pos)
{

    if(ctrl.setSelectionRange)
    {
        ctrl.focus();
        ctrl.setSelectionRange(pos,pos);
    }
    else if (ctrl.createTextRange) {
        var range = ctrl.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }                                                                                                                                                                                                                                        
}

   

var update_text = function(evt) {
	if (document.getElementById('capitalizecheckbox').checked) {
    

      var the_input = evt.target;
      if (window.last !== the_input.value) {
        var prev_caret_position = doGetCaretPosition(the_input); 
        the_input.value = titleCaps(the_input.value);
        setCaretPosition(the_input, prev_caret_position);
        window.last = the_input.value;
      }
	  if (the_input.value.trim()) {
        show_img(evt);
      }
	}
    };
    var to_red = function(evt) {

      if (evt.which != 86) {
        if (evt.which <= 0 || evt.ctrlKey || evt.metaKey || evt.altKey) {
          return;
        } 
      }
 
      evt.target.style.color = '#333';
 
    };
	    var show_img = function(evt) {

		
		  evt.target.style.color = 'green';
    };
    
	function init() { 
	
	
		
		window.main_input = document.getElementsByName('post_title')[0];



		console.log("current title: " + window.main_input);
		
		document.getElementById("title").style.width="85%";
		
		var titlewrap = document.getElementById('titlewrap')  ;

	
		var toadd = document.createElement("div");
		toadd.setAttribute("id", "titlecheckbox");
		toadd.setAttribute("style", "margin-top: 5px; float:right;width:14%;height:38px;");
		toadd.setAttribute("align", "center");
		toadd.innerHTML =  '<input type="checkbox" name="capitalizecheckbox"  id="capitalizecheckbox" value="" checked><br/>Auto-capitalize';
			
		titlewrap.appendChild(toadd); 
		
		window.last = "";

		
		
		main_input.onkeyup = update_text;
		main_input.onkeydown = to_red;
		
	}
	
	window.onload = init;
  </script>
<?php
	}
}


?>
