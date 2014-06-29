<?php
/*
	Plugin Name: MDC Theme Switcher
	Description: This plugin allows to switch and preview between available themes. It adds a sticky bar to front-end with a dropdown list of themes. Can be accessible to non-admin or hide.
*/
//===session enable for WP starts===//
add_action('init', 'simpleSessionStart', 1);
add_action('wp_logout', 'simpleSessionDestroy');
add_action('wp_login', 'simpleSessionDestroy');
function simpleSessionStart() {
    if(!session_id())session_start();
}
function simpleSessionDestroy() {
    session_destroy ();
}
function simpleSessionGet($key, $default='') {
    if(isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } else {
        return $default;
    }
}
function simpleSessionSet($key, $value) {
    $_SESSION[$key] = $value;
}
//===session enable for WP ends===//

//===add stylesheet starts===//
function mdc_custom_css(){
	?>
	<link rel="stylesheet" href="<?php echo plugins_url();?>/mdc-theme-switcher/css/style.css" />
	<style>
	.mdc_sticky_bar{
	<?php if(get_option('sticky_position') == 'top'){?>
		top: 0px;
	<?php if(is_user_logged_in()){?>
		margin-top: 32px;
	<?php }?>
	<?php } else{ ?>
		bottom: 0px
	<?php }?>
	}
	</style>
	<?php
}
add_action('wp_head', 'mdc_custom_css');
//===add stylesheet ends===//

//===dropdown theme list starts===//
function mdc_themes_dropdown(){
$themes = get_option('themes_array');
?>
<form action="" method="get" class="mdc_form">
	<select name="theme" onchange="this.form.submit();">
		<option>-- Select A Theme --</option>
		<?php foreach($themes as $theme):?>
		<option value="<?php echo strtolower(str_replace(" ","",$theme));?>"><?php echo $theme;?></option>
		<?php endforeach;?>
	</select>
</form>
<?php
}
add_shortcode('mdc_theme_swicher', 'mdc_themes_dropdown');
add_filter('widget_text', 'do_shortcode'); 
//add sticky bar
function mdc_sticky_bar(){
?>
<div class="mdc_sticky_bar">
	<div class="mdc_logo mdc_col mdc_left">
		<h3 class="mdc_h3"><?php echo get_option('display_text');?></h3>
	</div>
	<div class="mdc_selector mdc_col mdc_left">
		<?php mdc_themes_dropdown(); ?>
	</div>
	<div class="mdc_credit mdc_col mdc_left">
		<?php if(get_option('credit_link') == 'yes'){?>
		<p>Powered by <a href="http://medhabi.com" target="_blank">MedhabiDotCom</a></p>
		<?php }?>
	</div>
</div>
<?php
}
if(get_option('enable_sticky') == 1){
	add_action('wp_footer', 'mdc_sticky_bar');
}

//reload page once
function mdc_reload_once(){
?>
<script type="text/javascript">
(function()
{
  if( window.localStorage )
  {
    if( !localStorage.getItem( 'firstLoad' ) )
    {
      localStorage[ 'firstLoad' ] = true;
      window.location.reload();
    }
    else
      localStorage.removeItem( 'firstLoad' );
  }
})();
</script>
<?php
}
//change theme
function mdc_change_theme(){
	if($_GET['theme']){
		$_SESSION['theme'] = $_GET['theme'];
	}
	if($_SESSION['theme']){
		switch_theme($_SESSION['theme']);
		add_action('wp_head', 'mdc_reload_once');
	}
	elseif(empty($_SESSION['theme'])){
		switch_theme('twentytwelve');
		add_action('wp_head', 'mdc_reload_once');
	}
}
if(!is_admin()){
	add_action('init', 'mdc_change_theme');
}

//include option page
include "mdc-option-page.php";