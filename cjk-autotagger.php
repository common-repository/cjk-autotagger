<?php
/*
Plugin Name: CJK-AutoTagger
Description: This plugin wraps &lt;span lang=""&gt;&lt;/span&gt; tags around your CJK characters in post and pages automatically
Author: Thomas Tsoi
Version: 1.0
Author URI: http://www.thomastsoi.com/
Plugin URI: http://www.thomastsoi.com/software/cjk-autotagger/
*/


add_action('admin_menu', 'cjk_autotagger_menu');

function cjk_autotagger_menu() {
	if ( is_admin() ){ // admin actions
		//create new top-level menu
		add_submenu_page('options-general.php', 'CJK-AutoTagger Settings', 'CJK-AutoTagger', 'administrator', __FILE__, 'cjk_autotagger_settings');

		//call register settings function
		add_action( 'admin_init', 'register_mysettings' );
	} else {
	  // non-admin enqueues, actions, and filters
	}
}

function register_mysettings() {
	//register our settings
	register_setting( 'cjk-autotagger-settings-group', 'the_title' );
	register_setting( 'cjk-autotagger-settings-group', 'the_content' );
	register_setting( 'cjk-autotagger-settings-group', 'the_excerpt' );
	register_setting( 'cjk-autotagger-settings-group', 'comment_text' );
	register_setting( 'cjk-autotagger-settings-group', 'comment_excerpt' );
	register_setting( 'cjk-autotagger-settings-group', 'wp_title' );
	register_setting( 'cjk-autotagger-settings-group', 'category_description' );
	register_setting( 'cjk-autotagger-settings-group', 'lang_code' );
}

function cjk_autotagger_settings() {
	?>
	<div class="wrap">
	<h2>CJK-AutoTagger</h2>

	<form method="post" action="options.php">
	    <?php settings_fields( 'cjk-autotagger-settings-group' ); ?>
	   	    
	    <p>Wrap &lt;span lang=""&gt;&lt;/span&gt; around CJK (Chinese/Japanese/Korean) characters in the following items:</p>
	    
	    <p style="font-weight: bold; color: red;">Note that your WordPress must be configured to use UTF-8 for this plugin to work.</p>
	    	
	    <table class="form-table">
	        <tr valign="top">
	        <th scope="row">Posts/pages</th>
	        <td>
			    <label accesskey="T"><input type="checkbox" name="the_title" value="1" <?php echo get_option('the_title')?"checked":""; ?> />title</label> 
			    <label accesskey="C"><input type="checkbox" name="the_content" value="1" <?php echo get_option('the_content')?"checked":""; ?> />content</label> 
			    <label accesskey="E"><input type="checkbox" name="the_excerpt" value="1" <?php echo get_option('the_excerpt')?"checked":""; ?> />excerpt</label> 
	        </td>
	        </tr>
	         
	        <tr valign="top">
	        <th scope="row">Comments</th>
	        <td>
			    <label accesskey="M"><input type="checkbox" name="comment_text" value="1" <?php echo get_option('comment_text')?"checked":""; ?> />comment text</label> 
			    <label accesskey="X"><input type="checkbox" name="comment_excerpt" value="1" <?php echo get_option('comment_excerpt')?"checked":""; ?> />comment excerpt</label> 
	       	</td>
	        </tr>
	        
	        <tr valign="top">
	        <th scope="row">Others</th>
	        <td>
			    <label accesskey="B"><input type="checkbox" name="wp_title" value="1" <?php echo get_option('wp_title')?"checked":""; ?> />blog title</label>
			    <label accesskey="D"><input type="checkbox" name="category_description" value="1" <?php echo get_option('category_description')?"checked":""; ?> />category description</label>
	        </td>
	        </tr>
	        <tr valign="top">
	        <th scope="row">Language code</th>
	        <td>
			    <select name="lang_code">
				    <optgroup label="Chinese">
				    	<option value="zh-CN" <?php echo get_option('lang_code')=="zh-CN"?"selected":""; ?>>zh-CN: Chinese (PRC)</option>
				    	<option value="zh-HK" <?php echo get_option('lang_code')=="zh-HK"?"selected":""; ?>>zh-HK: Chinese (Hong Kong SAR)</option>
				    	<option value="zh-SG" <?php echo get_option('lang_code')=="zh-SG"?"selected":""; ?>>zh-SG: Chinese (Singapore)</option>
				    	<option value="zh-TW" <?php echo get_option('lang_code')=="zh-TW"?"selected":""; ?>>zh-TW: Chinese (Taiwan)</option>
				    </optgroup>
				    <optgroup label="Japanese">
			    	<option value="ja" <?php echo get_option('lang_code')=="ja"?"selected":""; ?>>ja: Japanese</option>
				    </optgroup>
				    <optgroup label="Korean">
			    	<option value="ko" <?php echo get_option('lang_code')=="ko"?"selected":""; ?>>ko: Korean</option>
				    </optgroup>
			    </select>
	        </td>
	        </tr>
	    </table>
	    
	    <p class="submit">
	    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	    </p>

	</form>
		
	<p>To style CJK and non-CJK (usually Latin) characters separately, follow the example below:</p>
	<div style="background: #ffffcc; border: 1px dashed orange; width: 500px; font: 12px Courier New; padding: 15px; margin: 10px;">
		<span style="color: green">// Style non-CJK characters</span><br>
		<b>#content</b> {<br>
			&nbsp;&nbsp;<span style="color: blue">font-family</span>: Arial, Verdana; <br>
			&nbsp;&nbsp;<span style="color: blue">font-size</span>: 12px;<br>
			&nbsp;&nbsp;}<br>
		<br>
		<span style="color: green">// Style CJK characters</span><br>
		<b>#content:lang(<?php echo get_option('lang_code')?get_option('lang_code'):"zh-HK"; ?>)</b> {<br>
			&nbsp;&nbsp;<span style="color: blue">font-family</span>: <span style="color: red">"Microsoft JhengHei"</span>, <span style="color: red">"MingLiu"</span>; <br>
			&nbsp;&nbsp;<span style="color: blue">font-size</span>: 14px;<br>
			&nbsp;&nbsp;}<br>
	</div>
	<p>For more information on styling with language codes, check out <a href="http://www.w3.org/International/questions/qa-css-lang">this reference from W3C</a>.</p>
	
	<div><b>For advanced users:</b> to auto-detect and &lt;span&gt;-wrap your custom strings in templates, use the following function:
		<div style="background: #ffffcc; border: 1px dashed orange; width: 500px; font: 12px Courier New; padding: 15px; margin: 10px;">
		<span style="color: black; font-style: italic;">string</span> <span style="font: 12px Courier New; color: blue; font-weight: bold;">cjk_autotagger</span>( string <span style="color: black; font-style: italic;">$string</span> [, string <span style="color: black; font-style: italic;">$lang_code</span> ] )
		</div>
	</div>
		
	<div><b>Example:
		<div style="background: #ffffcc; border: 1px dashed orange; width: 500px; font: 12px Courier New; padding: 15px; margin: 10px;">
		echo <span style="font: 12px Courier New; color: blue; font-weight: bold;">cjk_autotagger</span>(<span style="color: black;">$str</span>, <span style="color: red;">"zh-HK"</span>);
		</div>
	</div>
	</div>
	<?php 
} 


function add_settings_link($links, $file) {  
	static $this_plugin;  
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);  
	if ($file == $this_plugin){  
		$settings_link = '<a href="admin.php?page=cjk-autotagger/cjk-autotagger.php">'.__("Settings", "cjk-autotagger").'</a>';  
		array_unshift($links, $settings_link);  
		}  
	return $links;  
} 

add_filter('plugin_action_links', 'add_settings_link', 10, 2 );

function cjk_autotagger($content, $lang_code = "") {
	$cjk_notag = get_post_custom_values('cjk_notag');
	if ($cjk_notag[0] != "1") {
		if ($lang_code == "")
			$lang_code = get_option('lang_code');
		$match = "/([".
			"\x{1100}-\x{11FF}"."|". // Korean Hangul Jamo
			"\x{3000}-\x{32FF}"."|". // CJK Symbols + Hirakana + Katakana
			"\x{3400}-\x{9FFF}"."|". // CJK Unified Ideographs + Extended A
			"\x{A960}-\x{A97F}"."|". // Korean Hangul Jamo Extended A
			"\x{AC00}-\x{D7AF}"."|". // Korean Hangul
			"\x{D7B0}-\x{D7FF}"."|". // Korean Hangul Jamo Extended B
			"\x{FF01}-\x{FFEF}". // Halfwidth kana and Fullwidth Latin
			"]+)/u";
		$replace = "<span lang=\"$lang_code\">\\1</span>";
		
		$content = preg_replace($match, $replace, $content);
	}
	return $content;
}

$lang_code = get_option('lang_code');

if (get_option('the_title') == "1") add_filter('the_title', 'cjk_autotagger');
if (get_option('the_content') == "1") add_filter('the_content', 'cjk_autotagger');
if (get_option('the_excerpt') == "1") add_filter('the_excerpt', 'cjk_autotagger');
if (get_option('comment_text') == "1") add_filter('comment_text', 'cjk_autotagger');
if (get_option('comment_excerpt') == "1") add_filter('comment_excerpt', 'cjk_autotagger');
if (get_option('wp_title') == "1") add_filter('wp_title', 'cjk_autotagger');
if (get_option('category_description') == "1") add_filter('category_description', 'cjk_autotagger');

?>