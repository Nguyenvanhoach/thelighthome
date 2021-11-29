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

get_header(); 
$terms = get_terms(array('taxonomy' => 'danh-muc-tin-tuc','hide_empty' => false,)); 
?>
<div class="wrap-crumbs container my-3"><div id="crumbs" class="list-crumb text-capitalize"><a rel="nofollow" href="<?php echo get_bloginfo( 'url' ); ?>"><i class="fa fa-home mr-1"></i>Trang chủ</a> <i class="fa fa-angle-right mx-1" style="color: #646464;"></i> <span class="current">Tin tức</span></div></div>
<div class="wrap-page py-4 py-md-5">
	<div class="container">
		<div class="row">
			<div class="col-md-9 archive-tintuc">				
				<?php				
					if($terms) {	
						$category_ids = array();
						foreach ($terms as $term) {							
							$category_ids = $term->term_id;							
							$args=array(
								'post_type' => 'tin_tuc',
								'post_status' => 'publish',
								'posts_per_page'=> '6', 
								'tax_query' => array(
								    array(
								    'taxonomy' => 'danh-muc-tin-tuc',
								    'field' => 'term_id',
								    'terms' => $category_ids
								    )
								)
							);?>
							
							
							<?php 
							$my_query = new WP_Query($args);							
							if( $my_query->have_posts() ) {	
								echo '<h2 class="title-block d-flex flex-wrap align-items-center"><span class="text-uppercase">'.$term->name.'</span><a title="'.$term->name.'" href="'.esc_url(get_term_link($term)).'" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h2>';
								echo '<div class="row space-1">';
									while( $my_query->have_posts() ) {
										$my_query->the_post(); $content = get_the_content(); 
							            echo '<div class="col-6 col-md-4 col-lg-4 my-3">
							              <div class="item-real rounded h-100">
							                <a href="'.get_the_permalink().'" title="'.get_the_title().'" class="post-media d-block">
							                  	<div class="img-wrap overflow-hidden">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'w-100 img-fluid mx-auto d-block','alt' => get_the_title(), 'loading'=> 'lazy') ).'
							                  	</div>    
							                  	<div class="p-2 p-md-3 ">
								                  	<h4 class="title-real mb-15 text-capitalize mb-2">'. get_the_title() .'</h4>
								                  	<div class="date-post">
								                  		<i class="fa fa-clock-o"></i>&nbsp;'.get_the_date('d/m/Y').'&nbsp;
								                  		<span><i class="fa fa-lg fa-fw fa-eye"></i>&nbsp;'.getPostViews(get_the_ID()).'</span>
									                </div>
									            </div>              
							                </a>
							              </div>
							            </div>';
									}
								echo '</div>';
							}
						}
					} else {
						get_template_part( 'template-parts/post/content', 'none' );
					}
				?>
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div><!-- .wrap -->
<?php get_footer();
