<?php
/*
  Plugin Name: VWO - Wordpress
  Description: Adds VWO into Settings Menu. Ready to be used to add your VWO Account ID, now comes with the option to disable VWO without removing your account ID - perfect for debugging!
  Version: 1.0
  Author: Joel Macey
  License: GNU
*/

// DefineScript
$vwo_header_script = '
<!-- Start Visual Website Optimizer Asynchronous Code -->
<script type=\'text/javascript\'>var _vwo_code=(function(){
var account_id=VWO_ID,settings_tolerance=2000,library_tolerance=2500,use_existing_jquery=false,/* DO NOT EDIT BELOW THIS LINE */
f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById(\'_vis_opt_path_hides\');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement(\'script\');b.src=a;b.type=\'text/javascript\';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName(\'head\')[0].appendChild(b);},init:function(){settings_timer=setTimeout(\'_vwo_code.finish()\',settings_tolerance);var a=d.createElement(\'style\'),b=\'body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}\',h=d.getElementsByTagName(\'head\')[0];a.setAttribute(\'id\',\'_vis_opt_path_hides\');a.setAttribute(\'type\',\'text/css\');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);this.load(\'//dev.visualwebsiteoptimizer.com/j.php?a=\'+account_id+\'&u=\'+encodeURIComponent(d.URL)+\'&r=\'+Math.random());return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
</script>
<!-- End Visual Website Optimizer Asynchronous Code -->
';

//Run functions
add_action ('wp_head','vwo_headercode',1);
add_action ('admin_menu','vwo_plugin_menu');
add_action ('admin_init','vwo_register_mysettings');

//Adds Plugin Menu to admin
function vwo_plugin_menu() {
  add_options_page('Visual Website Optimizer', 'VWO', 'create_users', 'vwo_options', 'vwo_plugin_options');
}

//Registers Settings in WP and DB
function vwo_register_mysettings(){
  register_setting('vwo_options','vwo_id','intval');
  register_setting('vwo_options','vwo_disable');
}
//Places script in <head>
function vwo_headercode(){
  global  $vwo_header_script;
  $vwo_id = get_option('vwo_id');
  $vwo_disable = get_option('vwo_disable');
  if($vwo_disable==0){
    if($vwo_id){
      echo str_replace('VWO_ID', $vwo_id, $vwo_header_script);
    }
  }
}

//Admin HTML
function vwo_plugin_options() {
?>
<div class="wrap">
  <h2>Visual Website Optimizer</h2>
  <form method="post" action="options.php">
  <?php settings_fields('vwo_options'); ?>
  <table class="form-table">
    <tr>
      <th>Your VWO Account ID</th>
      <td><input type="text" name="vwo_id" value="<?php echo get_option('vwo_id'); ?>" placeholder="XXXXXX" /></td>
    </tr>
    <tr>
      <th>Disable VWO</th>
      <td><?php echo '<input type="checkbox" id="vwo_disable" name="vwo_disable" value="1" ' . checked(1, get_option('vwo_disable'), false) . '/>'; ?></td>
    </tr>
  </table>

  <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</div>
<?php
}
?>
