=== Compare Products for WooCommerce ===
Contributors: a3rev, nguyencongtuan
Tags: WooCommerce, WooCommerce Plugins, WooCommerce compare products, compare products plugin, compare products
Requires at least: 6.0
Tested up to: 6.6
Stable tag: 3.2.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add a World Class Compare Products Feature to your WooCommerce store today with the Compare Products for WooCommerce plugin.

== DESCRIPTION ==

The Compare Products extension for WooCommerce gives a product comparison feature that you'd only expect to find on the big corporate e-commerce sites.

Compare Products allows users to firstly add products to a compare widget basket, then at the click of a mouse the chosen products can be viewed in a state-of-the-art comparison table.

Chosen products are compared side-by-side, feature by feature, price-by-price. Discard products from the table at the click of a mouse as you hone in on the product that is the one for you. Save the comparison as a PDF or print it.

= KEY FEATURES =

* First launched in March 2012 and continually upgraded, tweaked and improved See [Changelog](https://wordpress.org/plugins/woocommerce-compare-products/changelog/)
* The compare products feature is proven to increase store sales
* Fully configurable - add any feature or specification you want to be compared for your products
* Add the compare feature on a product by product basis
* Full support for comparing product variations
* Option to show or don't show compare feature on product cards or product pages - very versatile
* Compare Widget - add items to the widget that works just like the WooCommerce Product Cart Widget
* Compare Widget and Compare Table pop-up fully synched. Remove an item from the compare table and it is auto removed from the widget 
* Compare table with horizontal scrolling comparison table allows many products to be compared at once.
* Save and Print options from the Compare table
* Full support for all modern browsers in desktop, laptop, tablet and mobile
* Works with any Theme that has the WooCommerce plugin installed and activated.
* Lightweight plugin - scripts only load on pages where the Compare feature is active


= PREMIUM VERSION =

If you require more features than the Free version has please checkout the Premium version

* [Premium Compare Products for WooCommerce](http://a3rev.com/shop/woocommerce-compare-products/)

= CONTRIBUTE =

When you download Compare Products for WooCommerce, you join our the a3rev Software community. Regardless of if you are a WordPress beginner or experienced developer if you are interested in contributing to the future development of this plugin head over to the Compare Products[GitHub Repository](https://github.com/a3rev/woocommerce-compare-products-lite) to find out how you can contribute.

Want to add a new language? You can contribute via [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/woocommerce-compare-products)


== Screenshots ==

1. screenshot-1.png

2. screenshot-2.png

3. screenshot-3.png

4. screenshot-4.png

== Installation ==

= Minimum Requirements =

* PHP version 7.4 or greater is recommended
* MySQL version 5.6 or greater is recommended

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't even need to leave your web browser. To do an automatic install of WooCommerce Compare Products, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New. Search Compare Products for WooCommerce and click install. Or download the plugin from wordpress.org and click the upload sub nav item and use the WordPress plugins uploader to upload the plugin from your computer and unpack it and install it for you.

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favourite FTP application.

1. Download the plugin file to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installations wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.


== Usage ==

1. On your WordPress admin dashboard find the WC Compare menu item.

2. Go to the Settings & Style sub menu and set up how the Compare feature shows on your Product Pages.

3. Go to the Category and Features tab and Assign the Features to a Compare category.

4. Go to each Product and activate the Compare feature and set it.

5. Edit or deactivate the Compare feature for any products edit page.

6. Celebrate the extra sales Compare Products brings you !

== Frequently Asked Questions ==

= When can I use this plugin? =

You can use this plugin when you have installed the WooCommerce plugin.


== Changelog ==

= 3.2.1 - 2024/07/13 =
* This release has various tweaks for compatibility with WordPress 6.6 and WooCommerce 8.9.3. Also a couple of bug fixes.
* Tweak - Tested for compatibility with WordPress 6.6
* Tweak - Tested for compatibility with WooCommerce 8.9.3
* Tweak - Validate and correct block.json based schema from WordPress Block
* Fix - Validate post variable
* Fix - Correct postId variable

= 3.2.0 - 2023/12/14 =
* This feature release adds a Compare Block for full compatibility with Block Themes FSE and WooCommerce 8.4.0
* Feature - Define new Compare Products List block
* Tweak - Tested for compatibility with WooCommerce 8.4

= 3.1.4 - 2023/11/27 =
* This mainetnace release has a bug fix for the Compare Feature tab on Product Page Block Template.
* Fix - Show Compare feature tab on Product Page Single Block Template.

= 3.1.3 - 2023/11/22 =
* This maintenance release has plugin framework updates for compatibility with PHP 8.1 onwards, plus backward compatibility to WooCommerce 6.0.
* Tweak - Remove backward compatibility for WooCommerce versions less than 6.0
* Framework - Set parameter number of preg_match function from null to 0 for compatibility with PHP 8.1 onwards
* Framework - Validate empty before call trim for option value

= 3.1.2 - 2023/10/30 =
* This maintenance release has a Code Tweak for compatibility with WordPress 6.4 and WooCommerce 8.2
* Tweak - Tested for compatibility with WordPress 6.4
* Tweak - Tested for compatibility with WooCommerce 8.2
* Tweak - Call add action to 'enqueue_block_assets' instead of 'enqueue_block_editor_assets' for enqueue style inside iframe of Gutenberg.

= 3.1.1 - 2023/09/14 =
* This maintenance release has a fatal error fix that came in with the 3.1 release
* Fix - Remove call A3Rev\WCCompare\Hook_Backbone classname that is not included into the free version of the plugin
* Props - WordPress user @freechelmi for reporting the bug.

= 3.1.0 - 2023/09/06 =
* This feature release adds a "Product Compare" Button Block for use with Gutenberg templates. Also compatibility with WooCommerce 8.0.3 and WordPress 6.3
* Feature - Define new "Product Compare" Button block to show Compare Button on Gutenberg Block templates.
* Tweak - Test for compatibility with WooCommerce 8.0.3
* Tweak - Test for compatibility with WordPress 6.3.0
* Fix - New Product Compare Button Block resolves issues that the Compare shortcode has with Gutenberg templates.

= 3.0.2 - 2023/07/28 =
* This maintenance release has a bug fix for compatibility with WooCommerce 7.9 and WordPress 6.2.2 or higher.
* Tweak - Test for compatibility with WordPress 6.2.2
* Fix - validate if $product is WC_Product or not before call get_id() from shortcode [woocommerce_compare_attributes_table]. For compatibility with WC 7.9.0

= 3.0.1 - 2023/07/26 =
* This maintenance release has a bug fix for compatibility with WooCommerce 7.9.0
* Tweak - Test for compatibility with WooCommerce 7.9.0
* Fix - Put second argument when call woocommerce_add_to_cart_redirect from Comparison Page. For work compatibility with WC 7.9.0

= 3.0.0 - 2023/04/25 =
* This release has compatibility with WordPress 6.2.0, WooCommerce 7.6.0 plus declared compatibility with WooCommerce HPOS.
* Tweak - Test for compatibility with WordPress 6.2
* Tweak - Test for compatibility with WooCommerce 7.6.0
* Tweak - Test and declare plugin compatibility with WooCommerce HPOS Custom Tables.

= 2.9.0 - 2023/01/03 =
* This feature release removes the fontawesome lib and replaces icons with SVGs plus adds Default Topography option to font controls and has compatibility with WooCommerce 7.2
* Feature - Convert icon from font awesome to SVG
* Feature - Update styling for new SVG icons
* Tweak - Test for compatibility with WooCommerce 7.2
* Plugin Framework - Update typography control from plugin framework to add support for Default value
* Plugin Framework - Default value will get fonts set in the theme.
* Plugin Framework - Change generate typography style for change on typography control
* Plugin Framework - Remove fontawesome lib

= 2.8.3 - 2022/11/01 =
* This maintenance release has a security vulnerability patch, plus compatibility with WordPress major version 6.1.0 and WooCommerce version 7.0
* Tweak - Test for compatibility with WordPress 6.1
* Tweak - Test for compatibility with WooCommerce 7.0
* Tweak - Optimize mobile style for comparison table display
* Security - This release has a patch for a security vulnerability

= 2.8.2 - 2022/05/25 =
* This release fixes a bug with the just released version 2.8.1
* Fix - Do not call update_google_map_api_key from construct of Admin UI

= 2.8.1 - 2022/05/24 =
* This maintenance release is for compatibility with WordPress major version 6.0 and WooCommerce version 6.5.1. It and includes various code tweaks and tweaks to harden security.
* Tweak - Test for compatibility with WordPress 6.0
* Tweak - Add filter on generate_border_style_css
* Tweak - Add filter on generate_border_corner_css
* Tweak - Test for compatibility with WooCommerce 6.5
* Framework – Upgrade Plugin Framework to version 2.6.0
* Security - Various code hardening tweaks.
* Security - Escape all $-variable
* Security - Sanitize all $_REQUEST, $_GET, $_POST
* Security - Apply wp_unslash before sanitize

= 2.8.0 - 2022/01/22 =
* This release has a new Google Fonts API Validation feature plus compatibility with WordPress 5.9 and WooCommerce 6.1.1
* Feature - Add Ajax Validate button for Google Fonts API, for quick and easy Validation of API key.
* Dev - Add dynamic help text to Google Font API field
* Tweak - Test for compatibility with WooCommerce 6.1
* Tweak - Test for compatibility with WordPress 5.9
* Framework - Update a3rev Plugin Framework to version 2.5.0

= 2.7.10 - 2021/11/20 =
* This maintenance release has check for compatibility with PHP version 8.x and WooCommerce 5.9
* Tweak - Test for compatibility with PHP 8.x
* Tweak - Test for compatibility with WooCommerce 5.9

= 2.7.9 - 2021/07/20 =
* This maintenance release has code tweaks for compatibility with WordPress Major version 5.8, WooCommerce version 5.5.1 and some Security Hardening.
* Tweak - Test for compatibility with WordPress 5.8
* Tweak - Test for compatibility with WooCommerce 5.5.1
* Security - Add more variable, options and html escaping

= 2.7.8 - 2021/03/19 =
* This maintenance release updates 23 deprecated jQuery functions for compatibility with the latest version of jQuery in WordPress 5.7
* Tweak - Update JavaScript on plugin framework for compatibility with latest version of jQuery and resolve PHP warning event shorthand is deprecated.
* Tweak - Replace deprecated .change( handler ) with .on( 'change', handler )
* Tweak - Replace deprecated .change() with .trigger('change')
* Tweak - Replace deprecated .focus( handler ) with .on( 'focus', handler )
* Tweak - Replace deprecated .focus() with .trigger('focus')
* Tweak - Replace deprecated .click( handler ) with .on( 'click', handler )
* Tweak - Replace deprecated .click() with .trigger('click')
* Tweak - Replace deprecated .select( handler ) with .on( 'select', handler )
* Tweak - Replace deprecated .select() with .trigger('select')
* Tweak - Replace deprecated .blur( handler ) with .on( 'blur', handler )
* Tweak - Replace deprecated .blur() with .trigger('blur')
* Tweak - Replace deprecated .resize( handler ) with .on( 'resize', handler )
* Tweak - Replace deprecated .submit( handler ) with .on( 'submit', handler )
* Tweak - Replace deprecated .scroll( handler ) with .on( 'scroll', handler )
* Tweak - Replace deprecated .mousedown( handler ) with .on( 'mousedown', handler )
* Tweak - Replace deprecated .mouseover( handler ) with .on( 'mouseover', handler )
* Tweak - Replace deprecated .mouseout( handler ) with .on( 'mouseout', handler )
* Tweak - Replace deprecated .keydown( handler ) with .on( 'keydown', handler )
* Tweak - Replace deprecated .attr('disabled', 'disabled') with .prop('disabled', true)
* Tweak - Replace deprecated .removeAttr('disabled') with .prop('disabled', false)
* Tweak - Replace deprecated .attr('selected', 'selected') with .prop('selected', true)
* Tweak - Replace deprecated .removeAttr('selected') with .prop('selected', false)
* Tweak - Replace deprecated .attr('checked', 'checked') with .prop('checked', true)
* Tweak - Replace deprecated .removeAttr('checked') with .prop('checked', false)

= 2.7.7 - 2021/03/08 =
* This maintenance release has tweaks for WordPress 5.7 and WooCommerce 5.1 plus it adds a classname to compare product image classname for excluding images from lazy load if there is a conflict with image load.
* Tweak - Test for compatibility with WordPress 5.7
* Tweak - Test for compatibility with WooCommerce 5.1.0
* Tweak - Support classname ‘compare_product_image’ for image loaded on Comparison page, so other plugin if have apply lazy load but not work, they can add that classname to exclude from lazy load list

= 2.7.6 - 2021/01/13 =
* This maintenance release is for compatibility with WooCommerce major version 4.9.0.
* Tweak - Test for compatibility with WooCommerce 4.9.0

= 2.7.5 - 2020/12/30 =
* This is an important maintenance release that updates our scripts for compatibility with the latest version of jQuery released in WordPress 5.6
* Tweak - Update JavaScript on plugin framework for work compatibility with latest version of jQuery
* Fix - Replace .bind( event, handler ) by .on( event, handler ) for compatibility with latest version of jQuery
* Fix - Replace :eq() Selector by .eq() for compatibility with latest version of jQuery
* Fix - Replace .error() by .on( “error” ) for compatibility with latest version of jQuery
* Fix - Replace :first Selector by .first() for compatibility with latest version of jQuery
* Fix - Replace :gt(0) Selector by .slice(1) for compatibility with latest version of jQuery
* Fix - Remove jQuery.browser for compatibility with latest version of jQuery
* Fix - Replace jQuery.isArray() by Array.isArray() for compatibility with latest version of jQuery
* Fix - Replace jQuery.isFunction(x) by typeof x === “function” for compatibility with latest version of jQuery
* Fix - Replace jQuery.isNumeric(x) by typeof x === “number” for compatibility with latest version of jQuery
* Fix - Replace jQuery.now() by Date.now() for compatibility with latest version of jQuery
* Fix - Replace jQuery.parseJSON() by JSON.parse() for compatibility with latest version of jQuery
* Fix - Remove jQuery.support for compatibility with latest version of jQuery
* Fix - Replace jQuery.trim(x) by x.trim() for compatibility with latest version of jQuery
* Fix - Replace jQuery.type(x) by typeof x for compatibility with latest version of jQuery
* Fix - Replace .load( handler ) by .on( “load”, handler ) for compatibility with latest version of jQuery
* Fix - Replace .size() by .length for compatibility with latest version of jQuery
* Fix - Replace .unbind( event ) by .off( event ) for compatibility with latest version of jQuery
* Fix - Replace .unload( handler ) by .on( “unload”, handler ) for compatibility with latest version of jQuery

= 2.7.4 - 2020/12/10 =
* Tweak - Test for compatibility with WooCommerce 4.8.0

= 2.7.3 - 2020/12/08 =
* This maintenance release has tweaks and a fix for compatibility with WordPress major version 5.6, WooCommerce 4.7.1 and PHP 7.4.8
* Tweak - Test for compatibility with PHP 7.4.8
* Tweak - Test for compatibility with WooCommerce 4.7.1
* Tweak - Test for compatibility with WordPress 5.6
* Fix - Add \ before WC() inside namespace file for it to call to correct WC() of WooCommerce

= 2.7.2 - 2020/08/08 =
* This maintenance release is for compatibility with WordPress major version 5.5 and WooCommerce 4.3.1.
* Tweak - Test for compatibility with WordPress 5.5
* Tweak - Test for compatibility with WooCommerce 4.3.1

= 2.7.1 - 2020/04/01 =
* This maintenance release is for compatibility with WordPress 5.4, WooCommerce 4.0.1, Travis CI build unit test for compliance with WordPress PHP coding standards and PHP tweaks for compatibility with PHP v 7.0 to 7.4
* Tweak - Test for compatibility with WordPress 5.4
* Tweak - Test for compatibility with WooCommerce 4.0.1
* Tweak - Plugin Framework fully refactored to Composer for cleaner code and faster PHP code on admin panels
* Tweak - Update plugin for compatibility with new version of plugin Framework
* Fix - Update global ${$this- to $GLOBALS[$this to resolve 7.0+ PHP warnings
* Fix - Update global ${$option to $GLOBALS[$option to resolve 7.0+ PHP warnings
* Fix - Update less PHP lib that use square brackets [] instead of curly braces {} for Array, depreciated in PHP 7.4
* Fix - Validate to not use get_magic_quotes_gpc function that are depreciated in PHP 7.4

= 2.7.0 - 2019/11/16 =
* This feature release has a lot including compatibility with WooCommerce 3.8.0, WordPress 5.3 PHP upgrade to Composer PHP Dependency Manger, a full security review and update and a new compare table shortcode feature.
* Feature - Plugin fully refactored to Composer for cleaner and faster PHP code
* Feature - Support shortcode [woocommerce_compare_attributes_table product_id=‘’] with parameter product_id of Product you want to show, or leave it blank to use id of current product page
* Tweak - Test for compatibility with WordPress 5.3.0
* Tweak - Test for compatibility with WooCommerce 3.8.0
* Tweak - Remove the hard coded PHP error_reporting display errors false from compile sass to css
* Dev - Replace file_get_contents with HTTP API wp_remote_get
* Dev - Ensure that all inputs are sanitized and all outputs are escaped

= 2.6.8 - 2019/06/29 =
* This is a maintenance upgrade to fix a potentially fatal error conflict with sites running PHP 7.3 plus compatibility with WordPress v 5.2.2 and WooCommerce 3.6.4
* Tweak - Test for compatibility with WooCommerce 3.6.4
* Tweak - Test for compatibility with WordPress 5.2.2
* Fix - PHP warning continue targeting switch is equivalent to break for compatibility on PHP 7.3

= 2.6.7 - 2019/04/26 =
* This maintenance update has tweaks for compatibility with WordPress 5.2.0 and WooCommerce 3.6.0 major new versions whilst maintaining backward compatibility
* Tweak - Test for compatibility with WordPress 5.2.0
* Tweak - Test for compatibility with WooCommerce 3.6.2
* Tweak - Support for backward compatibility with WooCommerce v 3.5

= 2.6.6 - 2018/12/29 =
* This maintenance update is for compatibility with WordPress 5.0.2, WooCommerce 3.5.3 and PHP 7.3. It also includes performance updates to the plugin framework.
* Tweak - Editor sidebar global Compare Attribute Fields metabox works with both Gutenberg and Classic Editor
* Tweak - Test for compatibility with WordPress 5.0.2 and WordPress 4.9.9
* Tweak - Test for compatibility with WooCommerce 3.5.3
* Tweak - Create new structure for future development of Gutenberg Blocks
* Framework - Performance improvement.  Replace wp_remote_fopen  with file_get_contents for get web fonts
* Framework - Performance improvement. Define new variable `is_load_google_fonts` if admin does not require to load google fonts
* Credit - Props to Derek for alerting us to the framework google fonts performance issue
* Framework - Register style name for dynamic style of plugin for use with Gutenberg block
* Framework - Update Modal script and style to version 4.1.1
* Framework - Update a3rev Plugin Framework to version 2.1.0
* Framework - Test and update for compatibility with PHP 7.3

= 2.6.5 - 2018/08/07 =
* This maintenance update comprises code tweaks and 2 bug fixes for compatibility with WooCommerce 3.4.4, WordPress 4.9.8 and WooCommerce Quotes and Orders 3.x
* Tweak - Filters for Add to Cart button on the Comparison table that allow 3rd party plugins to filter those. 
* Tweak - Filters for View Cart link on Comparison table that allow 3rd party plugins to filter those. 
* Tweak - Test for compatibility with WordPress 4.9.8
* Tweak - Test for compatibility with WooCommerce 3.4.4
* Tweak - Test for compatibility with WooCommerce Quotes and Orders v 3.x
* Tweak - Update place card links from admin menu to point at appropiate area on a3 Dashboard
* Framework - Update a3rev Plugin Framework to version 2.0.7
* Fix - Show the Add to Cart button on the Table Comparison.
* Fix - Show Attribute Comparison Data when create or edit attribute

= 2.6.4 - 2018/07/26 =
* This maintenance update fixes a bug with image display in compare pop up plus compatibility with WooCommerce v 3.4.4 and WordPress v 4.9.7
* Tweak - Test for compatibility with WooCommerce 3.4.4
* Tweak - Test for compatibility with WordPress 4.9.7
* Fix - Table style to resolve issue with some images distorting in the pop up comparison table.

= 2.6.3 - 2018/05/26 =
* This maintenance update is for compatibility with WordPress 4.9.6 and WooCommerce 3.4.0 and the new GDPR compliance requirements for users in the EU 
* Tweak - Test for compatibility with WooCommerce 3.4.0
* Tweak - Test for compatibility with WordPress 4.9.6
* Tweak - Check for any issues with GDPR compliance. None Found
* Framework - Update a3rev Plugin Framework to version 2.0.3

= 2.6.2 - 2018/02/13 =
* Maintenance Update. Under the bonnet tweaks to keep your plugin running smoothly and is the foundation for new features to be developed this year 
* Framework - Update a3rev Plugin Framework to version 2.0.2
* Framework - Add Framework version for all style and script files
* Tweak - Update for full compatibility with a3rev Dashboard plugin
* Tweak - Change hook tag name from add_to_cart_fragments to woocommerce_add_to_cart_fragments for compatibility with WC 3.3.0. Backward compatibility with WC 3.2.6
* Tweak - Test for compatibility with WordPress 4.9.4
* Tweak - Test for compatibility with WooCommerce 3.3.1

= 2.6.1 - 2017/10/13 =
* Tweak - Tested for compatibility with WooCommerce 3.2.0
* Tweak - Tested for compatibility with WordPress 4.8.2
* Tweak - Added support for the new WC 'tested up to' feature to show this plugin has been tested compatible with WC updates

= 2.6.0 - 2017/06/07 =
* Feature - Launched WooCommerce Compare Products public Github Repository
* Tweak - Tested for compatibility with WordPress major version 4.8.0
* Tweak - Tested for compatibility with WooCommerce version 3.0.7
* Tweak - Include bootstrap modal script into plugin framework
* Tweak - Update a3rev plugin framework to latest version

= 2.5.4 - 2017/04/27 =
* Tweak - Tested for full compatibility with WooCommerce version 3.0.4
* Tweak - Tested for full compatibility with WordPress version 4.7.4
* Tweak - Change global $$variable to global ${$variable} for compatibility with PHP 7.0
* Tweak - Change call direct to Product properties with new functions that are defined on WC v3.0
* Tweak - Called action for save data of plugin after WC data is saved on new CRUD
* Tweak - Change priority for save_post action so that it is called after WooCommerce save the product data, to get the correct data on WC v3.0
* Tweak - Sort script for correct position on Comparison Product page
* Tweak - Update style for show checkbox and radiobox input on Product Meta Box
* Tweak - Update a3 Revolution to a3rev Software on plugins description
* Tweak - Added Settings link to plugins description on plugins menu
* Fix - Get correct url for product variations
* Fix - Add to Cart button show on Comparison Product page

= 2.5.3 - 2016/11/17 =
* Tweak - Hook 'add_admin_menu' to 'plugin_loaded' from Plugin Framework
* Tweak - Use h1 instead of h2 tag for page title on Dashboard page from Plugin Framework
* Tweak - Test for full compatibility with WooCommerce version 2.6.8
* Dev - Define new 'Row' and 'Column' control type to support multiple columns on Dashboard page for Plugin Framework
* Dev - Define new 'Ajax Multi Submit' control type with Progress Bar showing and Statistic for Plugin Framework
* Dev - Define new 'Ajax Submit' control type with Progress Bar showing for Plugin Framework
* Dev - Update plugin framework styles and scripts support for new control types
* Fix - Check 'disable_grid_view_compare' and 'grid_view_button_position' keys exist when first install the plugin
* Fix - Remove 'min-width: auto' from radio and checkbox control on Compare Attribute Fields box so checkboxes can show

= 2.5.2 - 2016/10/22 =
* Tweak - Set min-width for checkbox and radio button on product meta of comparison.
* Tweak - Tested for full compatibility with WooCommerce version 2.6.6
* Fix - Show correct value of custom attribute instead of label on Widget, Comparison and Manager Product pages.

= 2.5.1 - 2016/10/01 =
* Tweak - Update text domain for full support of translation with new name for translate file is 'woocommerce-compare-products'
* Tweak - Tested for full compatibility with WordPress version 4.6.1
* Tweak - Tested for full compatibility with WooCommerce version 2.6.4
* Fix - Headers already sent warning. Delete trailing spaces at bottom of php file

= 2.5.0 - 2016/07/29 =
* Feature - Plugin framework Mobile First focus upgrade
* Feature - Massive improvement in admin UI and UX in PC, tablet and mobile browsers
* Feature - Introducing opening and closing Setting Boxes on admin panels.
* Feature - Added Plugin Framework Customization settings. Control how the admin panel settings show when editing.
* Feature - Includes a script to automatically combine sub category tables into the Tabs main table when upgrading
* Feature - Added Option to set Google Fonts API key to directly access latest fonts and font updates from Google
* Feature - Added full support for Right to Left RTL layout on plugins admin dashboard.
* Feature - Added 'Line Height' option into Typography control of plugin framework
* Feature - Support show/hide Compare button on Product Cards
* Tweak - Major overhaul of the admin panel Description and Help text
* Tweak - Update select type of plugin framework for support group options
* Tweak - Update plugin framework style for support 'Line Height' option of Typography control
* Tweak - Update Typography Preview script for apply 'Line Height' value to Preview box
* Tweak - Update the generate_font_css() function with new 'Line Height' option
* Tweak - Replace all hard code for line-height inside custom style by new dynamic 'Line Height' value
* Tweak - Tested for full compatibility with WooCommerce version 2.6.3
* Tweak - Tested for full compatibility with WordPress version 4.5.3

= 2.4.2 - 2016/06/30 =
* Tweak - Update style of plugin framework to latest version so that it does not conflict with Sort & Display when both have category meta on Category Edit page
* Tweak - Tested for full compatibility with WooCommerce major version 2.6.0
* Tweak - Tested for full compatibility with WooCommerce version 2.6.1
* Tweak - Tested for full compatibility with WordPress version 4.5.3
* Fix - Use 'wc_add_to_cart_params' instead of 'woocommerce_params' as a variable of script for work compatibility on WC 2.6.1

= 2.4.1 - 2016/05/10 =
* Tweak - Update 'product-compare.php' template file
* Tweak - Tested for full compatibility with WordPress version 4.5.2
* Tweak - Tested for full compatibility with WooCommerce version 2.5.5
* Fix - Update comparison table style, set label column have position is absolute instead of fixed for broken comparison table in mobile
* Fix - Update comparison table script, check if mobile then make less wide for label column and product column for broken comparison table in mobile
* Credit - Thanks to Zhivko Mikov for reporting the comparison table bug in mobile a3rev.com/forums/topic/problem-with-compare-page-on-mobile-devices/

= 2.4.0 - 2016/04/07 =
* Feature - Define new 'Background Colour' type on plugin framework with ON | OFF switch to disable background or enable it
* Feature - Define new function - hextorgb() - for convert hex colour to rgb colour on plugin framework
* Feature - Define new function - generate_background_color_css() - for export background style code on plugin framework that is used to make custom style
* Tweak - Update core style and script of plugin framework for support Background Colour type
* Tweak - Saved the time number into database for one time customize style and Save change on the Plugin Settings
* Tweak - Replace version number by time number for dynamic style file are generated by Sass to solve the issue get cache file on CDN server
* Tweak - Define new 'strip_methods' argument for Uploader type, allow strip http/https or no
* Tweak - Register fontawesome in plugin framework with style name is 'font-awesome-styles'
* Tweak - Update plugin framework to latest version
* Tweak - Apply style and script for new term.php page on WordPress 4.5
* Tweak - Tested for full compatibility with WordPress major version 4.5
* Tweak - Tested for full compatibility with WooCommerce version 2.5.5

= 2.3.1 - 2016/01/07 =
* Tweak - Bumped the Required WordPress version for plugin compatibility up to WordPress version 4.1 to be in line with WooCommerce
* Fix - Update the categories list to get all categories in same order that is set in WooCommerce Product Categories for sites that have large number of nested categories
* Credit - Thanks to Jawad Ahmed for [reporting the bug](https://a3rev.com/forums/topic/documentation-2/) and access to his install to find and fix

= 2.3.0 - 2015/12/19 =
* Feature - Added full support for Right to Left RTL layout on plugins admin dashboard
* Tweak - Tested for full compatibility with WordPress major version 4.4
* Tweak - Tested for full compatibility with WooCommerce version 2.4.12
* Tweak - Change old Uploader to New UI of Uploader with Backbone and Underscore from WordPress
* Tweak - Update the uploader script to save the Attachment ID and work with New Uploader
* Tweak - Change call action from 'wp_head' to 'wp_enqueue_scripts' and use 'wp_enqueue_style' function to load dynamic style for better compatibity with minify feature of caching plugins
* Tweak - Change call action from  'wp_head' to 'wp_enqueue_scripts' to load  google fonts
* Tweak - Updated a3 Plugin Framework to the latest version
* Tweak - Change the heading on Plugin Settings from h2 to h1 with new WordPress v4.4 UI
* Fix - Show correct position of Compare button on above or below with Add to Cart on Card at Shop page instead of left or right with Add to Cart button

= 2.2.11 - 2015/09/09 =
* Fix - Hook into new action tag 'woocommerce_product_after_variable_attributes' to show the Compare Data on variations are loaded by new UI of WC 2.4 at Product Edit page
* Fix - Hook into new action tag 'woocommerce_save_product_variation' to save the Compare Data of variations on WC 2.4
* Fix - Updated MySQL query on Product Manager admin page to show product of current language instead of show products of all languages (Pro Version)

= 2.2.10 - 2015/09/04 =
* Tweak - Tested and tweaked for full compatibility with WooCommerce Version 2.4.6

= 2.2.9 - 2015/08/20 =
* Tweak - include new CSSMin lib from https://github.com/tubalmartin/YUI-CSS-compressor-PHP-port into plugin framework instead of old CSSMin lib from http://code.google.com/p/cssmin/ , to avoid conflict with plugins or themes that have CSSMin lib
* Tweak - make __construct() function for 'Compile_Less_Sass' class instead of using a method with the same name as the class for compatibility on WP 4.3 and is deprecated on PHP4
* Tweak - change class name from 'lessc' to 'a3_lessc' so that it does not conflict with plugins or themes that have another Lessc lib
* Tweak - Tested for full compatibility with WooCommerce Version 2.4.4
* Tweak - Tested for full compatibility with WordPress major version 4.3.0
* Fix - Update Add to Cart feature on Comparison Page to work on WooCommerce 2.4.4
* Fix - Make __construct() function for 'WC_Compare_Widget' class instead of using a method with the same name as the class for compatibility on WP 4.3 and is deprecated on PHP4
* Fix - Check 'request_filesystem_credentials' function, if it does not exists then require the core php lib file from WP where it is defined
* Fix - Change to tabler_border['color'] option name for fix 'PHP Notice:  Undefined index: table_border_colour'

= 2.2.8 - 2015/06/27 =
* Tweak - Tested for full compatibility with WooCommerce Version 2.3.11
* Tweak - Updated legacy API url for when a site admin has set index.php permalinks

= 2.2.7 - 2015/06/04 =
* Tweak - Tested for full compatibility with WooCommerce Version 2.3.10
* Tweak - Tested for full compatibility with WordPress Version 4.2.2
* Tweak - Security Hardening. Removed all php file_put_contents functions in the plugin framework and replace with the WP_Filesystem API
* Tweak - Security Hardening. Removed all php file_get_contents functions in the plugin framework and replace with the WP_Filesystem API
* Fix - Update dynamic stylesheet url in uploads folder to the format <code>//domain.com/</code> so it's always is correct when loaded as http or https

= 2.2.6 - 2015/05/05 =
* Tweak - Tested for full compatibility with WordPress Version 4.2.1
* Fix - Removed check_ajax_referer() call on frontend for compatibility with PHP caching plugins. Was returning -1 to js success call-back.

= 2.2.5 - 2015/04/23 =
* Fix - Move the output of <code>add_query_arg()</code> into <code>esc_url()</code> function to fix the XSS vulnerability identified in WordPress 4.1.2 security upgrade

= 2.2.4 - 2015/04/21 =
* Tweak - Tested and Tweaked for full compatibility with WordPress Version 4.2.0
* Tweak - Tested and Tweaked for full compatibility with WooCommerce Version 2.3.8
* Tweak - Update style of plugin framework. Removed the [data-icon] selector to prevent conflict with other plugins that have font awesome icons
* Tweak - Changed <code>dbDelta()</code> function to <code>$wpdb->query()</code> for creating plugin table database.

= 2.2.3 - 2015/03/19 =
* Tweak - Tested and Tweaked for full compatibility with WooCommerce Version 2.3.7
* Tweak - Tested and Tweaked for full compatibility with WordPress Version 4.1.1

= 2.2.2 - 2015/02/13 =
* Tweak - Maintenance update for full compatibility with WooCommerce major version release 2.3.0 with backward compatibility to WC 2.2.0
* Tweak - Tested fully compatible with WooCommerce just released version 2.3.3
* Tweak - add filter to 'woocommerce_add_to_cart_fragments' to apply Compare Button for WC 2.3
* Tweak - Changed WP_CONTENT_DIR to WP_PLUGIN_DIR. When an admin sets a custom WordPress file structure then it can get the correct path of plugin
* Tweak - Added Link to new plugins a3 Lazy Load and a3 Portfolio to the Free WordPress plugins list in yelow sidebar.

= 2.2.1 - 2015/01/27 =
* Tweak - Audit, test and tweak for 100% compatibility with WooCommerce 2.2.10
* Tweak - Audit, test and tweak for 100% compatibility with WordPress Version 4.1
* Fix - Sass compile path not saving on windows xampp.
* Fix - Auto checked if the site has old version of Lite database and if so run update database structure during upgrade to latest version.

= 2.2.0 - 2014/09/18 =
* Feature - Converted all front end CSS #dynamic {stylesheets} to Sass #dynamic {stylesheets} for faster loading.
* Feature - Convert all back end CSS to Sass.

= 2.1.9.6 - 2014/09/13 =
* Tweak - Tested 100% compatible with WooCommerce 2.2.2
* Tweak - Tested 100% compatible with WordPress Version 4.0
* Tweak - Added WordPress plugin icon

= 2.1.9.5 - 2014/09/03 =
* Tweak - Tested fully compatible with WooCommerce 2.2 back to 2.1
* Tweak - use wc_get_product() function instead of get_product() function when site is using WooCommerce Version 2.2
* Tweak - Updated google font face in plugin framework.

= 2.1.9.4 - 2014/07/03 =
* Tweak - Updated plugins description and dashboard text for details about plugin upgrade version.
* Tweak - Checked for full compatibility with WooCommerce Version 2.1.12

= 2.1.9.3 - 2014/06/12 =
* Feature -  On upgrade to Pro version All Compare Categories, Compare Features and input terms created in the Lite Version are auto converted to WooCommerce Product Categories, Product Attributes and Terms if they do not already exist.
* Tweak - On upgrade to Pro version Categories and Features sub menu changes to Categories and Attributes.
* Tweak - On upgrade to Pro version all Lite Version create and edit Compare Categories and Compare features code is removed.
* Tweak - On upgrade to Pro Version all Lite Version Un-Assigned Compare features code is removed.
* Tweak - Updated chosen js script to latest version 1.0.1 on the a3rev Plugin Framework
* Tweak - Updated chosen js script to latest version 1.0.1 on the a3rev Plugin Framework
* Tweak - Changed add_filter( 'gettext', array( $this, 'change_button_text' ), null, 2 ); to add_filter( 'gettext', array( $this, 'change_button_text' ), null, 3 );
* Tweak - Update change_button_text() function from ( $original == 'Insert into Post' ) to ( is_admin() && $original === 'Insert into Post' )
* Tweak - Added support for placeholder feature for input, email , password , text area types.
* Tweak - Updated plugins wordpress.org description text.
* Tweak - Updated plugins admin Yellow sidebar text.
* Tweak - Tested 100% compatible with WooCommerce version 2.1.11
* Tweak - Tested 100% compatible with WordPress version 3.9.1

= 2.1.9.2 - 2014/05/07 =
* Tweak - Update the compare widget. Added load items to cart by ajax to solve the problem of cart items being cached by caching plugins
* Tweak - set DONOTCACHEPAGE constant for Comparison page to prevent caching of current items in widget.
* Tweak - Updated Framework help text font for consistency.
* Tweak - Added remove_all_filters('mce_external_plugins'); before call to wp_editor to remove extension scripts from other plugins.
* Tweak - Tested 100% compatible with WooCommerce version 2.1.8
* Tweak - Tested 100% compatible with WordPress version 3.9

= 2.1.9.1 - 2014/02/04 =
* Fix - Undefined index: _woo_compare_category in class-wc-compare-metabox.php

= 2.1.9 - 2014/01/16 =
* Feature - Upgraded plugins code for 100% compatibility with soon to be released WooCommerce version 2.1 and backwards to version 2.0
* Tweak - Clean up on deletion feature now entirely removes compare categories, features from database and product meta keys.
* Tweak - Added description text to the top of each Pro Version yellow border section

= 2.1.8 - 2013/12/31 =
* Feature - Upgraded the plugin to the newly developed a3rev admin panel app interface.
* Feature - a3rev Plugin Framework admin interface 100% Compatibility with WordPress v3.8.0 with backward compatibility.
* Feature - a3rev framework admin interface 100% iOS and Android compatible.
* Feature - Dashboard switches and sliders use Vector based display that shows when WordPress version 3.8.0 is activated.
* Feature - All plugin .jpg icons and images use Vector based display for full compatibility with new WordPress version.
* Feature - New admin UI features check boxes replaced by switches, some dropdowns replaced by sliders.
* Feature - Added 4 new border display types, Grove, Ridge, Inset, Outset
* Feature - Button Corner style - Rounded - Can now set a rounded value for each corner of the button to create many different button styles.
* Feature - New Border / Button shadow features. Create shadow external or internal, set wide of shadow.
* Feature - Replaced colour picker with new WordPress 3.6.0 colour picker.
* Feature - Added choice of 350 Google fonts to the existing 17 websafe fonts in all new single row font editor.
* Feature - New on page instant previews for Fonts editor, create border and shadow style.
* Feature - Added intuitive triggers for settings. When switched ON a features corresponding feature settings show, when OFF they hide.
* Feature - Added House keeping function to settings. Clean up on Deletion.  Option - Choose if you ever delete this plugin it will completely remove all tables and data it created.
* Tweak - Moved plugin settings from WooCommerce menu to its own menu item on the wp-admin sidebar.
* Tweak - Changed plugins menu item name from Product Comparison to WC Compare.
* Tweak - Added main sub menu items, Category & Feature | Product Manager | Settings & Style
* Tweak - Yellow sidebar on Pro Version Menus does not show in Mobile screens to optimize admin panel screen space.
* Tweak - Numerous admin description text tweaks and typo fix ups.
* Tweak - Tested 100% compatible with WP 3.8.0
* Tweak - Tested 100% compatible with WooCommerce Version 2.0.20

= 2.1.7 - 2013/11/07 =
* Tweak - added esc_attr() to text input fields to support hyphen character
* Tweak - Tested plugin for full compatibility with lastest WordPress version 3.7.1 and WooCommerce 2.0.19
* Fix - Plugins admin script and style not loading in Firefox with SSL on admin. Stripped http// and https// protocols so browser will use the protocol that the page was loaded with.

= 2.1.6 - 2013/08/20 =
* Tweak - Tested for full compatibility with WordPress v3.6.0
* Tweak - Added PHP Public Static to functions in Class. Done so that Public Static warnings don't show in WP__DEBUG mode.
* Tweak - Dashboard Yellow sidebar info and added link to the Pro Version 7 day FREE trail offer.

= 2.1.5 - 2013/06/15 =
* Fix - Compare Features Tab on Product Page, Enable / Disable function. The 2 functions worked but the opposite of what they where supposed to.
* Tweak - Updated support URL link to the plugins wordpress.org support forum.

= 2.1.4 - 2013/04/26 =
* Fix - Text colour pickers not saving and displaying the hex number and hex colour in Font Colour, Font Link Colour and Font Hover colour selectors after editing and updating. The bug affected all font colour setting that use theme colours on install. These are the settings show an empty colour selector field on install.

= 2.1.3 - 2013/04/23 =
* Fix - External / Affiliates link on Compare Window is now backward compatible from WooCommerce Version 2.0. Was showing fatal Error for older versions.

= 2.1.2 - 2013/04/17 =
* Tweak - Added when install and activate plugin link redirects to WooCommerce Compare Products admin panel instead of the wp-plugins dashboard.
* Fix - Compare Feature search, search term is no longer case sensitive.
* Fix - Updated all JavaScript functions so that the plugin is compatible with jQuery Version1.9 and backwards to version 1.6. WordPress still uses jQuery version 1.8.3. In themes that use Google js Library instead of the WordPress jQuery then there was trouble because Google uses the latest jQuery version 1.9. There are a number of functions in jQuery Version 1.9 that have been depreciated and hence this was causing errors with the jQuery function in the plugin.

= 2.1.1 - 2013/04/10 =
* Fix - Compare on screen widow not opening in IE9. Missed an _ in command and IE9 don't recognize space. Thanks to Nicola from yithemes.com for picking that up
* Fix - Added correct Chosen script URL so admin panel uses plugin chosen script instead of defaulting to WooCommerce Chosen script.
* Fix - Added correct Tool Tip tipTip minimum script file .min so admin panel uses plugin Tool Tip script instead of defaulting to WooCommerce script.

= 2.1.0 - 2013/04/09 =
* Feature - Added Compare Categories functionality for Lite Version - previously only available in the Pro Version upgrade.
* Feature - Replaced Compare Fancybox and Lightbox pop-up fly out with Comparisons page opening in a new browser window. WooCommerce Version 2.0 uses new WordPress PrettyPhoto as the pop-up tool and in testing we found supporting 3 pop-up scripts, PrettyPhoto, Fancybox and Lightbox was very buggy and troublesome. Removed all 3 pop-up scripts and replaced with open in browser window.
* Feature - Added 2 Comparison widow opening options. Option 1. Show the product Comparison in an on-screen pop-up window or Option 2. Show Comparisons in a new window.
* Feature - Added Comparison Table Fixed Features Title column. Products in comparison table scroll left under a fixed Features Title column - always see what product features are being compared.
* Feature - Added Comparison Table scrolls horizontal and vertical via the window scrollers and not by scrollers on an inner container.
* Feature - Completely reworked the Print Product Comparison function. The Print function now prints the entire tall of 3 products Comparison columns regardless of the tall of the columns.
* Feature - In-Plugin Custom Styling - Style every element of the compare feature that front end users see and interface with all without touching the theme or plugin code.
* Feature - Added Activate / Deactivate the Compare Feature on single product pages.
* Feature - Added full custom Compare Button and Linked Text style options.
* Feature - Added Product page 'successfully added' to compare icon. Auto shows after button is clicked. Default icon is a green tick, includes option to remove or upload a custom icon.
* Feature - Added 'View Compare' feature. Just like the 'View Cart' feature. Fully customizable Button or Linked Text. Ideal for full wide product pages that have no sidebar.
* Feature - Widget Style main tab. Full custom styling of everything that the plugin outputs in the Compare WordPress widget. (Pro Version Feature)
* Feature - Added option to set the position that the Compare feature shows relative to the 'add to cart' button (Above | Below) independent of Product page settings.
* Feature - Added Activate / Deactivate Compare Feature option on Grid View (Shop page, Product Categories and Product Tag archives pages)
* Feature - Added Grid View 'successfully added' to compare icon. Auto shows after button is clicked. Default icon is a green tick, includes option to remove or upload a custom icon.
* Feature - Comparison Page main tab. In this upgrade we launch full table customization features.
* Feature - Added all new Page Header image uploader script to replace the old and clunky show image by URL from WordPress media library.
* Tweak - Product Page Main tab.  Full custom layout and style features for the compare feature on product pages under 4 new sub tabs.
* Tweak - Theme updates and changing a theme does not affect the layout and styles you create for your Compare feature because it is all in the plugin, independent of any theme.
* Tweak - Removed the old Settings tab and replaced with 4 new tabs, Product Page | Widget Style | Grid View Style | Comparison Page
* Tweak - Separated all Product page and Grid View page layout and style settings for fine grain control of how the feature shows on any theme.
* Tweak - Added Shortcode now shows as an image in the page visual text editor instead of the shortcode [product_comparison_page]. Added set page from the admin panel.
* Tweak - Added customize Comparison page Header background colour, body background colour and the Comparison Empty Window Message text font and style.
* Tweak - Added chosen script for select Compare categories on add and edit Compare features.
* Tweak - Tested and optimization in Windows XP, IE 7, IE8, Windows 7, IE8 and IE9 and Windows 8, IE10 and IE10 Desktop.
* Tweak - Tested and optimization for all 3 Windows operating systems - for these legacy browsers - Firefox, Safari, Chrome and Opera.
* Tweak - Tested and optimization for Apple OS X operating systems. Snow leopard, Lion and Mountain Lion using these legacy Browsers - Firefox, Safari, Chrome and Opera
* Tweak - Tested and optimization for Apple IOS Mobile Safari in iPhones and all iPads.
* Tweak - Tested and optimization for Android Browser on all models of these manufacturers tablets that use the Android operating system - Amazon Kindle Fire, Google Nexus 7, Samsung Galaxy Note, Samsung Galaxy Tab 2
* Tweak - Tested and optimization for Android Browser on all models of these manufacturers phone that use the Android operating system (to many to list) mobile phones that support - Samsung Galaxy, Motorola, HTC, Sony and LG
* Tweak - Tested and optimization for Opera Mobile - Samsung Galaxy Tablet and Mobiles HTC Wildfire. Nokia 5800, Samsung Galaxy S II, Motorola Droid X and Motorola Atrix 4G
* Tweak - Compare product page meta only shows open if the feature is activated.
* Tweak - Moved the Un-Assigned Compare Features on Features tab to the top of Compare categories for ease of use.
* Tweak - Updated admin error messages that displays when creating a Compare Category or Feature that already exists.
* Tweak - Updated admin error message that displays when plugin cannot connect to a3API on the Amazon cloud upon activation of the license.
* Tweak - Jumped version from 2.0.4 to 2.1.0 to keep in synch with Pro Version.
* Tweak - Updated plugin wiki docs to include new custom styling and layout features.
* Fix - Full WP_DEG run. All Uncaught exceptions fixed.
* Fix - Bug for users who have https: (SSL) on their sites wp-admin but have http on sites front end. This was causing a -1 to show when products added to Compare Widget wp-admin with SSL applied only allows https: but the url of admin-ajax.php is http: and it is denied hence returning the ajax -1 error. Fixed by writing a filter to recognize when https is configured on wp-admin and parsing correctly.

= 2.0.4 - 2013/02/25 =
* Feature - Added PrettyPhoto pop-up tool script for the Compare products pop-up.
* Tweak - All plugin code updated to be 100% compatible with WooCommerce version 2.0 and backwards.
* Tweak - Updated plugin description and some support URL links.

= 2.0.3 - 2013/01/08 =
* Tweak - Added support for Chinese Characters
* Tweak - UI tweak - changed the order of the admin panel tabs so that the most used Features tab is moved to first tab.
* Tweak - Added links to all other a3rev wordpress.org plugins from the Features tab
* Tweak - Updated Support and Pro Version link URL's on wordpress.org description, plugins and plugins dashboard. Links were returning 404 errors since the launch of the all new a3rev.com mobile responsive site as the base e-commerce permalinks is changed.

= 2.0.2 - 2012/12/14 =
* Fix - Updated depreciated custom database collator $wpdb->supports_collation() with new WP3.5 function $wpdb->has_cap( 'collation' ). æSupports backward version compatibility.
* Fix - When Product attributes are auto created as Compare Features, if the Attribute has no terms then the value input field is created as Input Text - Single line instead of a Checkbox.
* Fix - On Compare Products admin tab, ajax not able to load the products list again after saving a product edit

= 2.0.1 - 2012/08/14 =
* Tweak - attributes terms where auto created as Compare Feature input type 'dropdown' (single select). Changed to input type 'check box' (multi-select)
* Tweak: Set database table name to be created the same as WordPress table type
* Tweak - Change localization file path from actual to base path
* Tweak - Corrected typo on Compare pop-up window
* Documentation - Added comprehensive extension documentation to the [a3rev wiki](http://docs.a3rev.com/user-guides/woocommerce/compare-products/).
* Localization - Added Turkish translation (thanks to ManusH & Keremidi)
* Video - Added demo video to extensions home page

= 2.0 - 2012/08/03 =
* Feature - All Product Categories and Sub Categories are auto created as Compare Categories when plugin is activated. Feature is activated on upgrade.
* Feature - All Product Parent Variations auto added to Master Category as Compare Features when the plugin is first activated.
* Feature - When Product Categories or Sub categories are created they are auto created as Compare categories. The plugin only listens to Create new so edits to Product categories are ignored.
* Feature: When parent product variations are created they are auto created as Compare Features. Child product variations and edits are ignored.
* Feature - Complete rework of admin user interface - Combined Features and Categories tabs into a single tab - Added Products Tab. Greatly enhanced user experience and ease of use.
* Feature - Added Features search facility for ease of finding and editing Compare Features.
* Tweak - Moved Create New Categories and Features to a single edit on-page assessable from an 'add new' button on Features tab.
* Tweak - Added support for use of special characters in Feature Fields.
* Tweak - Added support for use of Cyrillic Symbols in Feature Fields.
* Tweak - Added support for use of sup tags in Feature Fields.
* Tweak - Language file added to support localization Ð looking for people to do translations.
* Tweak - Created plugin documents on a3rev wiki.
* Tweak - Replaced all Category Edit | Delete icons with WordPress link text. Replace edit icon on Product Update table with text link.
* Tweak - Edited Product update table to fit 100% wide on page so that the horizontal scroll bar does not auto show.
* Tweak - Edited the way that Add Compare Features shows on product edit page - now same width as the page content.
* Tweak - Show Compare Featured fields on products page - added support for theme table css styling.
* Tweak - Adding padding between Product name and the Clear All - Compare button in sidebar widget.
* Tweak - Added yellow Pro update frame and dialogue box so its clear what features are activated on upgrade.
* Tweak - Create script to facilitate seamless upgrade from Version 1.04 to Major upgrade Version 2.0
* Tweak - Created and added WooCommerce Compare Products video to Wordpress plugins page
* Fix - Can't create Compare Feature if user does not have a default value set in SQL. Changed INSERT INTO SQL command output to cater for this relatively rare occurrence.

= 1.0.5 - 2012/05/22 =
* Feature - Set Compare Button position above or below and padding from the WooCommerce Add to Cart Button.
* Fix - This feature is a workaround for site owners who use the WooCommerce Premium Catalog Visibility extension that removes the WooCommerce hook that Compare needs to show the button. Set the Compare button to show below the Add to Cart button in your theme and it will still show when that plugin removes the cart functionality.

= 1.0.4 - 2012/04/17 =
* Tweak - Re-designed admin panel style for improve UX and in line with the PRO version
* Tweak - Changed blue border in pop-up screen to square corners and gray colour.
* Tweak - Change alignment of Compare button to 'align right' in sidebar widget.
* Tweak - Code re-organized into folders with all files commented on and appropriate names as per WordPress Coding standards.
* Fix - Print this page feature not working on Fly-Out screen
* Fix - Column alignment problem on Features admin panel on smaller screens.

= 1.0.3 - 2012/04/05 =
* Tweak - Compare Settings page now on 2 tabs - SETTINGS | FEATURES in the same style as WooCommerce setting page for familiarity and greater ease of use.

= 1.0.2 - 2012/04/04 =
* Feature - Add default WooCommerce Fancybox  Fly-Out screen option. Retained Lightbox and now have option to use Fancybox or Lightbox to power Fly-Out window.
* Tweak - Greatly improved the layout and ease of use of the single page admin panel.
* Tweak - Added comprehensive admin page plugin setup instructions and added Tool Tips
* Tweak - Changed Fly-Out window from - include( '../../../wp-config.php') to show content using wp_ajax
* Tweak - Run WP_DEBUG and fix plugins 'undefined...' errors
* Tweak - Removed fading update messages and animation and replaced with default wordpress 'updated' messages.
* Tweak - Replace custom ajax handlers  with wp_ajax and wp_ajax_nopriv
* Tweak - Add pop up window when deleting feature fields to ask you to check if you are sure?
* Fix - Auto add Compare Widget to sidebar when plugin is activated.
* Fix - Feature Unit of Measurement is added in brackets after Feature Name and if nothing added it does not show.
* Fix - Use $woocommerce->add_inline_js for inline javascript to add it to the footer (after scripts/fancybox are loaded) to prevent errors

= 1.0.1 - 2012/03/22 =
* Tweak - Remove validation script never use for this plugin

= 1.0.0 - 2012/03/15 =
* First working release of the modification


== Upgrade Notice ==

= 3.2.1 =
This release has various tweaks for compatibility with WordPress 6.6 and WooCommerce 8.9.3. Also a couple of bug fixes.

= 3.2.0 =
This feature release adds a Compare Block for full compatibility with Block Themes FSE and WooCommerce 8.4.0

= 3.1.4 =
This mainetnace release has a bug fix for the Compare Feature tab on Product Page Block Template

= 3.1.3 =
This maintenance release has plugin framework updates for compatibility with PHP 8.1 onwards, plus backward compatibility to WooCommerce 6.0.

= 3.1.2 =
This maintenance release has a Code Tweak for compatibility with WordPress 6.4 and WooCommerce 8.2

= 3.1.1 =
This maintenance release has a fatal error fix that came in with the 3.1 release

= 3.1.0 =
This feature release adds a "Product Compare" Button Block for use with Gutenberg templates. Also compatibility with WooCommerce 8.0.3 and WordPress 6.3

= 3.0.2 =
This maintenance release has a bug fix for compatibility with WooCommerce 7.9 and WordPress 6.2.2 or higher.

= 3.0.1 =
This maintenance release has a bug fix for compatibility with WooCommerce 7.9.0

= 3.0.0 =
This release has compatibility with WordPress 6.2.0, WooCommerce 7.6.0 plus declared compatibility with WooCommerce HPOS.

= 2.9.0 =
This feature release removes the fontawesome lib and replaces icons with SVGs plus adds Default Topography option to font controls and has compatibility with WooCommerce 7.2

= 2.8.3 =
This maintenance release has a security vulnerability patch, plus compatibility with WordPress major version 6.1.0 and WooCommerce version 7.0

= 2.8.2 =
This release fixes a bug with the just released version 2.8.1

= 2.8.1 =
This maintenance release is for compatibility with WordPress major version 6.0 and WooCommerce version 6.5.1. It and includes various code tweaks and tweaks to harden security.

= 2.8.0 =
This release has a new Google Fonts API Validation feature plus compatibility with WordPress 5.9 and WooCommerce 6.1.1

= 2.7.10 =
This maintenance release has check for compatibility with PHP version 8.x and WooCommerce 5.9

= 2.7.9 =
This maintenance release has code tweaks for compatibility with WordPress Major version 5.8, WooCommerce version 5.5.1 and some Security Hardening.

= 2.7.8 =
This maintenance release updates 23 deprecated jQuery functions for compatibility with the latest version of jQuery in WordPress 5.7

= 2.7.7 =
This maintenance release has tweaks for WordPress 5.7 and WooCommerce 5.1 plus it adds a classname to compare product image classname for excluding images from lazy load if there is a conflict with image load.

= 2.7.6 =
This maintenance release is for compatibility with WooCommerce major version 4.9.0

= 2.7.5 =
This is an important maintenance release that updates our scripts for compatibility with the latest version of jQuery released in WordPress 5.6

= 2.7.4 =
* This maintenance release is for compatibility with WooCommerce 4.8.0

= 2.7.3 =
This maintenance release has tweaks and a fix for compatibility with WordPress major version 5.6, WooCommerce 4.7.1 and PHP 7.4.8

= 2.7.2 =
This maintenance release is for compatibility with WordPress major version 5.5 and WooCommerce 4.3.1.

= 2.7.1 =
This maintenance release is for compatibility with WordPress 5.4, WooCommerce 4.0.1, Travis CI build unit test for compliance with WordPress PHP coding standards and PHP tweaks for compatibility with PHP v 7.0 to 7.4

= 2.7.0 =
This feature release has a lot including compatibility with WooCommerce 3.8.0, WordPress 5.3 PHP upgrade to Composer PHP Dependency Manger, a full security review and update and a new compare table shortcode feature.

= 2.6.8 =
This is a maintenance upgrade to fix a potentially fatal error conflict with sites running PHP 7.3 plus compatibility with WordPress v 5.2.2 and WooCommerce 3.6.4

= 2.6.7 =
This maintenance update has tweaks for compatibility with WordPress 5.2.0 and WooCommerce 3.6.0 major new versions whilst maintaining backward compatibility

= 2.6.6 =
This maintenance update is for compatibility with WordPress 5.0.2, WooCommerce 3.5.3 and PHP 7.3. It also includes performance updates to the plugin framework.

= 2.6.5 =
This maintenance update comprises code tweaks and 2 bug fixes for compatibility with WooCommerce 3.4.4, WordPress 4.9.8 and WooCommerce Quotes and Orders 3.x

= 2.6.4 =
This maintenance update fixes a bug with image display in compare pop up plus compatibility with WooCommerce v 3.4.4 and WordPress v 4.9.7

= 2.6.3 =
Maintenance Update. Compatibility with WooCommerce 3.4.0, WordPress 4.9.6 and the new GDPR compliance requirements for users in the EU

= 2.6.2 =
Maintenance Update. This version updates the Plugin Framework to v 2.0.2, adds full compatibility with a3rev Dashboard, WordPress v 4.9.4 and WooCommerce v 3.3.1

= 2.6.1 =
Maintenance Upgrade. Tweaks for compatibility with WooCommerce 3.2.0 and WordPress 4.8.2

= 2.6.0 =
Feature Update. 2 code tweaks for compatibility with WordPress major version 4.8.0 and WooCommerce version 3.0.7 plus launch of public Github repo for source code

= 2.5.4 =
Major Maintenance Update. 6 major code tweaks and 2 bug fixes for compatibility with WooCommerce 3.0.4 and backwards to v2.6.0 and WordPress 4.7.4

= 2.5.3 =
Maintenance Update. 2 code tweaks, 4 plugin framework developer tweaks and 2 bug fixes for full compatibility with WooCommerce version 2.6.8

= 2.5.2 =
Maintenance Update. 1 Tweak and 1 bug fix for full compatibility with WooCommerce version 2.6.6

= 2.5.1 =
Maintenance Update. 1 tweak for text domain for translations plus 1 bug fix and full compatibility with WordPress v 4.6.1 and WooCommerce v 2.6.4

= 2.5.0 =
Major Feature Upgrade. A complete rebuild of the plugins Settings & Style admin interface to bring the Free version into line with the premium version. 9 new features and 6 Tweaks

= 2.4.2 =
Maintenance Update. 1 Bug Fix and 1 Tweak for full compatibility with WooCommerce version 2.6.1 and WordPress version 4.5.3

= 2.4.1 =
Maintenance Upgrade. 1 Tweak and 2 bug fixes for full compatibility with WooCommerce v 2.5.5 and WordPress v 4.5.2

= 2.4.0 =
Feature Upgrade. 3 new features, 6 Tweaks and 2 bug fixes for full compatibility with upcoming WordPress major version 4.5.0 and WooCoomerce 2.5.5

= 2.3.1 =
Maintenance Update. 1 bug fix for sites that have large nested WooCommerce Product Categories

= 2.3.0 =
Feature Upgrade. 1 new feature plus 6 code tweaks and 1 bug fix for compatibility with WordPress major version 4.4 and WooCommerce Version 2.4.12

= 2.2.11 =
Maintenance Upgrade. 3 bug fixes for full compatibility with WooCommerce version 2.4 attributes and variations tags and WPML version 3.2.7 (Pro Version)

= 2.2.10 =
Maintenance Upgrade. Tweaked for full compatibility with WooCommerce 2.4.6

= 2.2.9 =
Major Maintenance Upgrade. 5 Code Tweaks plus 4 bug fixes for full compatibility with WordPress v 4.3.0 and WooCommerce v 2.4.4

= 2.2.8 =
Maintenance Upgrade. One custom permalinks tweak plus and full compatibility with WooCommerce 2.3.10 and WordPress 4.2.2

= 2.2.7 =
Important Maintenance Upgrade. 2 x major a3rev Plugin Framework Security Hardening Tweaks plus 1 https bug fix and full compatibility with WooCommerce 2.3.10 and WordPress 4.2.2

= 2.2.6 =
Maintenance Update. 1 Bug fix for full compatibility with PHP caching plugins and full compatibility with WordPress version 4.2.1

= 2.2.5 =
Important Security Patch! - please run this update now. Fixes XSS vulnerability declared and patched in WordPress Security update v 4.1.2

= 2.2.4 =
Maintenance upgrade. Code tweaks for full compatibility with WordPress 4.2.0 and WooCommerce 2.3.8

= 2.2.3 =
Upgrade now for full compatibility with WooCommerce Version 2.3.7 and WordPress version 4.1.1

= 2.2.2 =
Upgrade now for full compatibility with WooCommerce major version release 2.3.0 with backward compatibility to WooCommerce v 2.2.0

= 2.2.1 =
Important Upgrade. Please upgrade now for full compatibility with WooCommerce 2.2.10 and WordPress 4.1 including an important plugin database upgrade.

= 2.2.0 =
Major Version upgrade! Full front end conversion to Sass #dynamic {stylesheets}. Admin panel full conversion from CSS to Sass.

= 2.1.9.6 =
Upgrade now for full compatibility with WordPress v4.0 and WooCommerce v2.2.2

= 2.1.9.5 =
Upgrade now for full compatibility with soon to be released WooCommerce Version 2.2 backwards to version 2.1

= 2.1.9.4 =
Update your plugin now with tweaks for full compatibility with WooCommerce Version 2.1.12

= 2.1.9.3 =
Upgrade now for 10 code Tweaks and 100% Compatility with WooCommerce version 2.1.11 and WordPress version 3.9.1

= 2.1.9.2 =
Upgrade now for Tweaks that prevent caching plugins caching Compare Widget and Comparison table content. Also 100% Compatility with WC v2.1.8 and WP 3.9

= 2.1.9.1 =
Upgrade now for undefined index bug fix that surfaced in version 2.1.9

= 2.1.9 =
Update now for full compatibility with soon to be released WooCommerce version 2.1 - backward compatible to version 2.0

= 2.1.8 =
Major Upgrade. Plugin converted to the a3rev plugin framework. 100% WP 3.8.0 and Woo 2.0.20 compatible. 14 x new * Features, 7 x * Tweaks.

= 2.1.7 =
Upgrade now for full compatibility with WP 3.7.1 and WooCommerce 2.0.19 plus 2 bug fixes.

= 2.1.6 =
Upgrade your plugin now for full compatibility with WordPress 3.6.0

= 2.1.4 =
Install this upgrade to fix colour picker bug in your plugin

= 2.1.3 =
Upgrade now to fix a backward compatibility issue with External / Affiliate Links.

= 2.1.2 =
This update includes 1 new activation feature and 2 fixes.
