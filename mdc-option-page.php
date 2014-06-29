<?php 
function mdc_option_page(){
	add_menu_page('MDC Theme Switcher', 'Theme Switcher', 'administrator', 'mdc-theme-switcher', 'mdc_theme_swicher_option_page', plugins_url( 'images/icon.png' , __FILE__ ), 61);
	// add_submenu_page('mdc-theme-switcher', 'MedhabiDotCom', 'MedhabiDotCom', 'administrator', 'medhabidotcom', 'medhabidotcom', '');
}
add_action('admin_menu', 'mdc_option_page');
function mdc_theme_swicher_option_page(){
	?>
<div class="wrap">
	<h2>MDC Theme Switcher Settings</h2>
	<?php if($_POST){
	update_option('display_text', $_POST['display_text']);
	update_option('enable_sticky', $_POST['enable']);
	update_option('credit_link', $_POST['credit_link']);
	update_option('themes_array', $_POST['themes_array']);
	update_option('sticky_position', $_POST['sticky_position']);
	?>
	<div class="updated settings-error" id="setting-error-settings_updated"> 
		<p><strong>Settings saved.</strong></p>
	</div>
	<?php } ?>
	<form action="" method="post">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="display_text">Display Text</label></th>
					<td><input type="text" class="regular-text" value="<?php echo get_option('display_text');?>" id="display_text" name="display_text" placeholder="Example: MDC Theme Switcher" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Enable Sticky Bar</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Enable Sticky Bar</span></legend>
							<label for="enable">
								<input type="checkbox" value="1" id="enable" name="enable" <?php if(get_option('enable_sticky') == 1){echo "checked";}?>>Tick to show the sticky bar on front-end.
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="sticky_position">Sticky Bar Position</label></th>
					<td>
						<select id="sticky_position" name="sticky_position">
							<option value="top" <?php if(get_option('sticky_position') == 'top'){echo "selected";}?>>Top</option>
							<option value="bottom" <?php if(get_option('sticky_position') == 'bottom'){echo "selected";}?>>Bottom</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Choose themes to select</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Choose themes to select</span></legend>
							<label for="themes">
							<?php
							$themes = get_themes();
							if(get_option('themes_array') == ''){
							foreach($themes as $theme):
							$stylesheet = strtolower(str_replace(" ","",$theme));
							?>
								<input type="checkbox" value="<?php echo $stylesheet;?>" id="enable" name="themes_array[]" /><?php echo $theme;?><br />
							<?php endforeach;
							}
							else{
							foreach($themes as $theme):
							$stylesheet = strtolower(str_replace(" ","",$theme));
							?>
								<input type="checkbox" value="<?php echo $stylesheet;?>" id="enable" name="themes_array[]" <?php if(in_array($stylesheet, get_option('themes_array'))){echo "checked";}?> /><?php echo $theme;?><br />
							<?php endforeach;
							
							}
							?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Credit Link</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"></legend>
								<label title="credit_yes">
									<input type="radio" value="yes" name="credit_link" <?php if(get_option('credit_link') == 'yes'){echo "checked";}?>> <span>Yes, keep a credit link</span>
								</label><br>
								<label title="credit_no">
									<input type="radio" value="no" name="credit_link" <?php if(get_option('credit_link') == 'no'){echo "checked";}?>> <span>No, don't keep a credit link!</span>
								</label><br>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
		</p>
	</form>
</div>
<div class="clear"></div>
	<?php
}

function medhabidotcom(){
	?>
	<div class="wrap">
		<h2>MedhabiDotCom</h2>
	</div>
	<?php

}
?>