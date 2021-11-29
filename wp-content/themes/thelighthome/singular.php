<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<div class="wrap-crumbs container my-3"><?php if(function_exists('breadcrumb')){breadcrumb();} ?></div>
<div class="container pb-4">
	<div id="site-content" class="bg-gray border rounded p-3" role="main">
	
		<?php
	
		if ( have_posts() ) {
	
			while ( have_posts() ) {
				the_post();
	
				get_template_part( 'template-parts/content', get_post_type() );
			}
		}
	
		?>
	
	</div><!-- #site-content -->
	
	<?php //get_template_part( 'template-parts/footer-menus-widgets' ); ?>

</div>

<?php get_footer(); ?>
