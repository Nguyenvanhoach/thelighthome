<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap-page archive-area">	
	<div class="container">
		<div class="row">
			<div class="col-md-9 catalog py-4 py-md-5">
				<?php if ( have_posts() ) : 
					/* Start the Loop */
					while ( have_posts() ) : the_post(); 
						$content = get_the_content();
						echo '<div class="row my-3 my-md-4">
			                <div class="col-5 col-md-4 pr-0">
			                    <a href="'.get_the_permalink().'" title="'.get_the_title().'" class="post-media d-block">
			                        <div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'w-100 img-fluid mx-auto d-block img-h','alt' => get_the_title(), 'loading'=> 'lazy') ).'</div>
			                    </a>
			                </div>    
			                <div class="col-7 col-md-8">
			                	<div class="item">
			                      <a href="'.get_the_permalink().'" title="'.get_the_title().'">
			                        <h3 class="text-capitalize mb-2 mb-md-3">'.get_the_title().'</h3>
			                        <div class="descript d-none d-md-block">'.trim_text_to_words(get_the_content(), 300).'</div>
			                        <div class="descript d-md-none">'.trim_text_to_words(get_the_content(), 100).'</div>
			                      </a>
			                    </div>  
			                </div>
		                </div>';
		                echo '<div class="divide w-100"></div>';
	             		
	             endwhile;
	             echo panigation();
             	else :
					get_template_part( 'template-parts/post/content', 'none' );
				endif; ?>
			</div>
			<div class="col-sm-3 py-5">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div><!-- .wrap -->
<?php get_footer();