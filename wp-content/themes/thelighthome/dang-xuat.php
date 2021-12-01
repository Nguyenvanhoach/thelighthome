<?php
	/*
	Template Name: Log Out
	*/
	session_start();
	session_destroy();
    unset($_SESSION['logged_fb_in']);
    unset($_SESSION['logged_gg_in']);
    //header('location:'. bloginfo('url'));
    echo "<script>window.location = '/';</script>";  
?>