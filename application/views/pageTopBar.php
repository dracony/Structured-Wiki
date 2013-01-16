
<?php if (Session::get('auth', false) === false) { ?>
    <span class='btnLoginDialog'>Login</span>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <span class='.register_btn'>Register</span>
<?php } else { ?>
    <?php if (false === true) { ?>
        <span class='btnEditTemplates'>Edit Templates</span>
        &nbsp;&nbsp;|&nbsp;&nbsp;
    <?php } ?>
        <span class='btnUserPage'>Weclome <?php echo Session::get('username', ''); ?></span>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <span class='btnLogout'>Logout</span>
<?php } ?>
