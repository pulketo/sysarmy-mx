<?php 
	session_start();
	require_once( 'commands.class.php' );
	$cmd = new cmd();	
	$cmd->execute($_REQUEST['command']);
?>

