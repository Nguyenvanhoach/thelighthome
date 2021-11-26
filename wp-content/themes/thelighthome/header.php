<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
session_start();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="Shortcut Icon" href="<?php echo get_template_directory_uri();?>/assets/images/favicon.ico" type="image/x-icon">
<meta name="description" content="<?php bloginfo('description'); ?>" />

<?php wp_head(); 
	if (is_home() || is_front_page()) {?>
        <meta property="og:image" content="<?php echo get_template_directory_uri();?>/assets/images/banner.jpg"> 
    <?php } 
?>
<script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script>
</head>

<body <?php body_class(); ?>>
	<header class="header">
    	<div class="header-top py-3">
			<div class="container">				
				<div class="d-flex flex-wrap justify-content-end align-items-center">
					<?php if(get_option('mail_company') !='') {
						echo '<a class="pr-2 pr-md-3 border-r" href="mailto:'.get_option('mail_company').'" title="Email: '.get_option('mail_company').'"><i class="fa fa-envelope-o pr-1 pr-md-1 icon" aria-hidden="true"></i> <strong>'.get_option('mail_company').'</strong></a>';
					}?>					
					<?php if(get_option('phone_company') !='') {
						echo '<a class="pr-sm-2 pr-md-3 border-r" href="tel:'.get_option('phone_company').'" title="Hotline: '.get_option('phone_company').'"><i class="icon fa fa-phone pr-1 pr-md-1"></i> <strong>'.get_option('phone_company').'</strong></a>';
					}?>				
					<ul class="nav m-0 pl-2 pl-md-3 social d-none d-sm-flex">
						<?php if(get_option('facebook') !='') {echo'<li class="nav-item mb-0 pr-1 pr-md-2 text-center"><a target="_blank" class="d-block" href="'.get_option('facebook').'" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></i></a></li>';}?>
		                <?php if(get_option('twitter') !='') {echo'<li class="nav-item mb-0 pr-1 pr-md-2 text-center"><a target="_blank" class="d-block" href="'.get_option('twitter').'" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></i></a></li>';}?>
		                <?php if(get_option('linkedin') !='') {echo'<li class="nav-item mb-0 pr-1 pr-md-2 text-center"><a target="_blank" class="d-block" href="'.get_option('linkedin').'" title="Linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></i></a></li>';}?>
		                <?php if(get_option('pinterest') !='') {echo'<li class="nav-item mb-0 pr-1 pr-md-2 text-center"><a target="_blank" class="d-block" href="'.get_option('pinterest').'" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></i></a></li>';}?>
		                <?php if(get_option('youtube') !='') {echo'<li class="nav-item mb-0 pr-1 pr-md-2 text-center"><a target="_blank" class="d-block" href="'.get_option('youtube').'" title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li>';}?>
					</ul>
				</div>
			</div>
		</div>
		<div class="header-middle">
			<div class="container">
				<nav class="navbar navbar-expand-lg px-0 p-md-0">
					<h1 class="logo m-0"><span class="text-logo"><?php bloginfo('description'); ?></span><a class="d-block wrap-logo" href="<?php bloginfo('url'); ?>" title="<?php echo get_bloginfo( 'name' ); ?>"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/assets/images/logo.png" class="img-fluid d-block" alt="<?php echo get_bloginfo( 'name' ); ?>"></a></h1>		
					<button class="navbar-toggler btn-m ml-auto d-md-none" type="button" data-toggle="collapse" data-target="#menu-primary" aria-controls="menu-primary" aria-expanded="false" aria-label="Toggle navigation"><span></span><span></span><span></span>
        			</button>	
					<div id="menu-primary" class="navbar-collapse collapse ml-auto justify-content-end pt-4 pt-md-0">
						<?php if ( has_nav_menu( 'primary' ) ) : ?><?php wp_nav_menu( array('theme_location' => 'primary','menu_id'        => 'top-menu','menu_class' => 'navbar-nav',) ); ?>   <?php endif; ?>
					</div>					
				</nav>
			</div>
		</div>
    </header><!-- /header -->
    <main class="main">
