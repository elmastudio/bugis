
Changelog:
------------------------------------------------------------------------------------------------------------


Version 1.1.4 - March 13th 2017
-------------------------------------------------
- New: Support for the One Click Demo Import plugin.


Version 1.1.3 - Dec 9th 2015
-------------------------------------------------
- Bugfix: update of deprecated code (see functions.php)
- Bugfix: update of  (see functions.php, header.php)
- Bugfix: update of code in head (see header.php)
- Bugfix: Update of social icons widget code (see functions.php)
- Bugfix: Update of theme options page code (see inc/theme-options.php)
- Note: Favicons are now uploaded via the Customizer (see Customizer / Site title)


Version 1.1.2 - April 3rd 2014
-------------------------------------------------
- Bugfix: Updated jquery.fitvids.js in folder "js" to fix Chrome font bug
- Enhancement: Deleted deprecated add_custom_background (see functions.php)
- Enhancement: Update of deprecated code in inc/theme-options.php


Version 1.1 - September 2th 2012
---------------------------------
- HiDPI (Retina) optimized images (see images / x2 and style.css, rtl.css)
- Google Webfonts import via functions.php instead of style.css (see functions.php, 17-25)
- Updated the code for load_theme_textdomain (see functions.php., 9-12)
- Included jQuery via the jQuery version included with WordPress (deleted code in functions.php and included header.php, 51)
- Updated the FitVids.js script (see js/jquery.fitvids.js)
- Updated the custom.js (see js/jquery.fitvids.js)
- Optimized post format icons implementation (see content.php, content-post-format files, content-single.php and style.css, 502-531)
- Changed author info box settings to be included only on standard posts (see content-single.php, 31-33 and 44)
- Apple Touch Icon theme option (see header.php, 43-47 and includes/theme-options.php)
- Print styles included directly at the bottom of style.css (deleted print.css in header.php, 37)
- Added headline to search results (see search.php, 13-15)
- CSS for Disqus Disqus Comment System WordPress plugin (style.css, 1817, 2024, 2300 )
- New option to hide sub menu on mobile devices (see includes / theme-options.php)
- Improved styles of image attachment in responsive Design (see style.css, image.php)
- Support for the "Responsive Slider" WordPress plugin (see style.css, from 1872, theme-options.php)
- Optimized styles for Smart Archives Reloaded Plugin (see style.css, from 1771)
- New theme translations for Dutch and Brazilian Portuguese (see languages folder)
- Updates for the German language files (see languages / de_DE.po, de_DE.mo)


Version 1.0.4 - October 14th 2011
---------------------------------
1.  Added outline:none; style.css reset (to remove dotted line on focus in Firefox).
2.  Updated jQuery to new version 1.6.4 (see functions.php line 37).
3.  Call html5 enabling script from googles online version (header.php line 47).
4.  Included WP Pagenavi plugin code mit if abfragen(in archive.php, author.php, category.php, tag.php, index.php and search.php).
		Now no additional code is needed after activation the WP Pagenavi plugin.
5.  Added new Google+ button code in sharebtn.php (also included the Google+ Javascript code in footer.php).
6.  Changed tweet button JavaScript code to footer.php.
7.  Fixed bug showing not all post format icons in search results.
8.  Optimized focus styles for forms (see style.css line 1081 and line 1759)
9.  Included FitVids 1.0 JavaScript for elastic, embedded videos (see functions.php line 55, custom.js line 47 and jquery.fitvids.js in "js").
10. Added Soundcloud, Pinterest and a target="_blank" option to Social Links Widgets. Also replaced RSS and RSS comments to show up at last icons.
11. Included list-styles for standard text widget (see style.css 1315)
12. Optimized the rtl.css for RTL language support


Version 1.0.3 - 6th August 2011
-------------------------------
1. Bugfix in editor-style.css to show bold and italic text styles.
2. Bugfix for WordPress image gallery in IE8 (added width:100% for #content .gallery in style.css
	 line 839)
3. Bugfixes for Bugis Shortcodes: Updated style.css line 1060-1177 and functions.php line 244-366.
	 Now the link="..." for the button shortcodes work and the multicolumns don't break when many
	 columns are added on one page.
4. Enabled blockquote styles for pages: changed #content .post blockquote p to #content blockquote p
	(style.css line 597)
5. Added spacing for multiple blockquotes.
6. Included custom.js and plusone.js into head (intead of footer), due to possible problems with other
	 WordPress plugins.
7. Added #___plusone_0 in style.css to fix the Google+ button position.
8. Added 500px.com icon to the Social Links Widget.


Version 1.0.2 - 15th July 2011
-------------------------------
1. included the search page navigation (older/newer posts) in search.php line 19 to 25
2. added RSS Feed and RSS for Comments icon to the Social Links Widget
3. included print.css for a print friendly version of the site contents
4. included editor-style.css and editor-style-rtl.css for styles in TinyMCE editor
5. simplyfied the code in content-single.php (line 11-15) to get the posts post-format icon
6. included the template-file sharebtn.php and simplified the code in the content-....php files
	 with a get_template_part function


Version 1.0.1 - 8th July 2011
-------------------------------
1. removed width 72% in style.css on #main-nav to allow longer blog titles
2. fixed comment navigation styles
3. Update of jQuery to version 1.6.2 in functions.php
4. changed jQuery SmoothScrool in custom.js to jquery-smooth-scroll plugin
	(https://github.com/kswedberg/jquery-smooth-scroll)
5. added Google+ to the Social Links Widget and to the Share-Button option on posts
6. added Outlines styles on form input fields
7. CSS opacity fix for transparent images in IE8


Version 1.0 - 6th July 2011
-----------------------------
- Bugis theme release



------------------------------------------------------------------------------------------------------------
Social Icons used for Social Links widget: Icons by Gedy Rivera: http://lifetreecreative.com/icons/
