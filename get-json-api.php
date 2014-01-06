<?php
/*
Plugin Name: Get Json Api
Plugin URI: http://plugin.digitalissimoweb.it/
Description: Retrieve the results of the API of a site that uses the plugin JSON API
Version: 0.1
Author: Digitalissimo
Author URI: http://www.digitalissimo.it
License: GPLv2 or later
*/

/*  Copyright 2013  Digitalissimo  (email : developer@digitalissimoweb.it)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
	
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include ("function/widget.php");
include ("function/shortcode.php");

//Jquery and Css
add_action('init', 'getjsonapi_install_jquery');
function getjsonapi_install_jquery() {
	global $post, $wp_locale;
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-cycle2', plugins_url('plugin/cycle/jquery.cycle2.min.js', __FILE__));
	wp_enqueue_script( 'jquery-cycle2-autoheight', plugins_url('plugin/cycle/jquery.cycle2.autoheight.min.js', __FILE__));
	wp_enqueue_style('get-json-api_css', plugins_url('css/get-json-api.css', __FILE__));
}




function getjsonapi_cycle($limit,$url){ 
	$timestamp = rand(0,time());
	echo '
	<div class="get-json-api-slideshow_' . $timestamp . '">
		<div class="cycle-slideshow" data-cycle-auto-height="container"></div>
		<div class="ui-icon-loading"></div>
		<div style="clear:both"></div>
	</div>
	';
	$script = getjsonapi_script($limit,"CYCLE",$timestamp,$url);
	
}

function getjsonapi_list($limit,$url){
	$timestamp = rand(0,time());
	echo '
	<div class="get-json-api-list_' . $timestamp . '">
		<ul></ul>
		<div class="ui-icon-loading"></div>
		<div style="clear:both"></div>
	</div>
	';
	$script = getjsonapi_script($limit,"LIST",$timestamp,$url);
}

function getjsonapi_script($limit,$type,$timestamp,$url){
	if ($url==""){
		_e ("Please, you type a url","getjsonapi");
	} else {
		switch ($type){
			case "CYCLE":
				$class = "get-json-api-slideshow";
			break;
			case "LIST":
				$class = "get-json-api-list";
			break;
			default:
				$class = "";
		}
		
		if (!preg_match("/^(http|ftp|https):/", $url)) {
			$url = 'http://'.$url;
		}
		$url .= (substr($url, -1) == '/' ? '' : '/');
		echo '
		<script>
			
			var serviceURL = "' . $url . '";
			getlist();
			
			function getlist() {
				jQuery.ajax({
					url:serviceURL + "?json=get_recent_posts&count=' . $limit . '",
					dataType:"jsonp",
					success:function(result){
						posts = result.posts;

						jQuery.each(posts, function(index, post) {
							title =  post.title;
							url = post.url;
							thumbs = post.attachments[0].url;
							';
							if ($type=="CYCLE")
								echo 'jQuery(".' . $class . '_' . $timestamp . ' .cycle-slideshow").cycle("add","<a href=\'" + url + "\' class=\'ui-link\' target=\'_new\'><img src=\'" + thumbs + "\' /></a>");';	   		
							else
								echo 'jQuery(".' . $class . '_' . $timestamp . ' ul").append("<li><a href=\'" + url + "\' class=\'ui-link\' target=\'_new\'>" + title + "</a></li>");
								';
						echo '});
						jQuery(".' . $class . '_' . $timestamp . ' .ui-icon-loading").remove();
					},
					error: function(request,error) 	{
						jQuery(".<?php echo $class;?>").append (error);
					}
				});
			}
			
		</script>';

	}
}
?>