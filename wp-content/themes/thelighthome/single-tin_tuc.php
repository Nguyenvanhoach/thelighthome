<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
get_header(); 
setPostViews(get_the_ID()); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-single wrap-page py-4 py-md-5">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h3 class="title-post text-capitalize mb-3 pb-2"><?php echo get_the_title();?></h3>
					<div class="content-taxomy">
						<?php the_content( sprintf(
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
							get_the_title()
						) ); ?>
					</div>				
					<?php if(function_exists('share_social')){echo share_social(); } ?>	
					
					<?php if(get_option('facebook') !='') {?>
						<div class="comment-fb">
							<div id="fb-root"></div>
							<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=215651349123280&autoLogAppEvents=1" nonce="cqxFH3YP"></script>
							<div class="fb-comments" data-width="100%" data-href="<?php echo get_option('facebook'); ?>" data-numposts="3"></div>
						</div>
					<?php } ?>
				    <?php echo related_taxomy_posts('5');?>	      
				</div>
				<div class="col-md-3"><?php get_sidebar(); ?></div>
			</div>
		</div>
    </div>	
</article><!-- #post-## -->

<?php get_footer();?>
