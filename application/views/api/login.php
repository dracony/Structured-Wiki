<?php
$output = array('auth'=>Session::get('auth', false), 'username'=>Session::get('username', false));

ob_start();
include(Misc::find_file('views', 'pageTopBar'));
$topBar = ob_get_clean();
$output['bar'] = $topBar;

echo json_encode($output);
?>
