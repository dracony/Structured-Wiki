<p>
Welcome. This wizard will gather the information needed to install the wiki. You will to 
enter all the information asked for in order to complete the wizard. Once the wizard is
complete the wiki will automatically be avialable. If for any reason you would need to 
change the settings in the future you may edit the config.php file.
</p>
<?php if ($configWrite === false) { ?>
<p>
The file (<?php echo $configFile; ?>) must be owned by the <?php echo get_current_user(); ?> user.
</p>
<?php } ?>
