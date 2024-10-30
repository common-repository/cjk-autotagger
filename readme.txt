=== Plugin Name ===
Plugin Name: CJK-AutoTagger
Contributors: tommasinino
Tags: Chinese, Japanese, Korean, unicode, language code, css, language, CJK
Requires at least: 2.7
Tested up to: 2.92
Author: Thomas Tsoi
Version: 1.0
Donate link: http://www.thomastsoi.com/

CJK-AutoTagger automatically wraps CJK characters in your site with `&lt;span lang=""&gt;&lt;/span&gt;` tags, so that you can style them separately.

== Description ==

Do you often mix Latin letters and Chinese, Japanese or Korean (CJK) characters in the same post or in the title? Did you find it difficult to style both types of characters satisfactorily using the same CSS style?

CJK-AutoTagger Automatically wraps CJK characters in your site with `<span lang=""></span>` tags, so that you can style them separately. You can choose what to &lt;span&gt;-wrap (refer to the screen shot) and what language code to use.

To style CJK and non-CJK (usually Latin) characters separately, follow the example below:

`// Style non-CJK characters
#content {
  font-family: Arial, Verdana; 
  font-size: 12px;
  }

// Style CJK characters
#content:lang(zh-HK) {
  font-family: "Microsoft JhengHei", "MingLiu"; 
  font-size: 14px;
  }`

For more information on styling with language codes, check out this reference from [W3C](http://www.w3.org/International/questions/qa-css-lang).

**For advanced users:** to auto-detect and &lt;span&gt;-wrap your custom strings in templates, use the following function: 

`string cjk_autotagger( string $string [, string $lang_code ] )`

Example: 

`echo cjk_autotagger($str, "zh-HK");`

== Installation ==

1. Upload the directory `cjk-autotagger` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure your plugin on the CJK-AutoTagger setting page under Settings

== Screenshots ==

1. CJK-AutoTagger Setting page.
