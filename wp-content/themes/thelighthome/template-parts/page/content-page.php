<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<?php the_title( '<h1 class="page-title text-uppercase pb-1 mb-4">', '</h1>' ); ?>
				<div class="entry-content bg-gray p-3 rounded">
					<?php
						the_content();
						// wp_link_pages( array(
						// 	'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
						// 	'after'  => '</div>',
						// ) );
					?>
				</div><!-- .entry-content -->
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</article><!-- #post-## -->
