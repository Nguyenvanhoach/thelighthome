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
$big = 999999999;
if ( get_query_var('paged') ) {
  $paged = get_query_var('paged'); 
} elseif ( get_query_var('page') ) { 
  $paged = get_query_var('page');
} else {
  $paged = 1;
}   

if('tin_tuc' === get_post_type()){
	get_template_part( 'archive-catalog');
} else if ( is_tax() ) {
	$taxonomy 	= get_taxonomy ( get_query_var('taxonomy') );
	$taxonomy_name = $taxonomy->name;
	$term = get_term_by('slug',get_query_var('term') , $taxonomy_name);
	$term_name = $term->name;
	$term_id = $term->term_id;
	$getPost = array(
		'post_status'   => 'publish',
		'post_type' => 'post', 
		'posts_per_page' => 9,   
		'tax_query' => array(
			array(
					'taxonomy' => $taxonomy_name,
					'field' => 'term_id',
					'terms' => $term_id,
			) )
	);
	$all_post = new WP_Query($getPost);
	$postNo = $all_post->found_posts;
	
	?>
	<div class="container"><div class="wrap-crumbs my-3 my-md-4"><?php if(function_exists('breadcrumb')){breadcrumb();} ?></div></div>	
	<div class="wrap-page archive-area pb-4 pb-md-5">
		<div class="container">
			<div class="row">
				<div class="col-md-9 catalog">	
					<div class="real-list">
						<?php if($all_post->have_posts()) {
							echo '<h2 class="mb-3 mb-md-4">'.$term_name.'<span>Có <strong class="red">'.$postNo.'</strong> bất động sản.</span></h2>';
					    while ( $all_post->have_posts() ):
					    	$all_post->the_post();
								$postid = get_the_ID();          
								if ($postNo<2) {
									get_template_part( 'template-parts/content', get_post_format() );
								} else {
									$dientich_post = get_post_meta( $postid, 'dientich_post', true );
									$gia_post = get_post_meta( $postid, 'gia_post', true );								
									$donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );		
									if($donvi_price_post) {
										$donvi_price_post = '/'.$donvi_price_post;
									}	 							
									$address_post = get_post_meta( $postid, 'address_post', true ); 			
									$phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);					
									$phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
									
									echo '<div class="row item my-3">
										<div class="col-12 col-sm-4 pr-sm-0">';
											if ( has_post_thumbnail() ) {
												echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'"><div class="img-effect-1 mb-3"><div class="rounded overflow-hidden">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid','alt' => get_the_title(),'loading' => 'lazy')).'</div></div></a>';
											} else {
												echo '<div class="no-img"><span>NO IMAGE</span></div>';
											}
										echo '</div>
										<div class="col-12 col-sm-8">
											<a href="'.get_the_permalink().'" title="'.get_the_title().'"><h3 class="mb-2">'.get_the_title().'</h3></a>
											<div class="block-att mb-2">';
												if($gia_post) {
													echo '<div class="my-1 my-md-3"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';
												}
												echo '<div class="listing-info">';
													if($phongngu_post) {
														echo '<div class="my-1 my-md-3"><i class="fa fa-bed mr-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
													}
													if($phongtam_post) {
														echo '<div class="my-1 my-md-3"><i class="fa fa-bath mr-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
													}
													if($dientich_post) {
														echo '<div class="my-1 my-md-3"><i class="fa fa-object-group mr-1" aria-hidden="true"></i> Diện tích: '.$dientich_post.'</div>';
													}
													if($address_post) {
                            echo '<div class="my-1 my-md-3"><i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span></div>';
                          }		
												echo '</div>';
											echo '</div>';
										echo '</div>'; 
									echo '</div>'; 
								}
							endwhile;																			
							// the_posts_pagination( array(
							// 	'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
							// 	'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
							// 	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
							// ) );
							//echo panigation();
							echo "<div class='paginations text-center'>";	
								echo paginate_links( array(
									'base' => str_replace($big, '%#%', esc_url( get_pagenum_link($big ) ) ),
									'format' => '?paged=%#%',
									'prev_text'    => __('« <span class="hidden-xs">Trang trước</span>'),
									'next_text'    => __('<span class="hidden-xs">Trang tiếp theo</span> »'),
									'current' => max( 1, get_query_var('paged') ),
									'total' => $all_post->max_num_pages, //12 là post page $postNo /12
									) );
									
							echo "</div>";
						}	else {
							echo '<p class="font-weight-bold">Không có bất động sản nào</p>';
							//get_template_part( 'template-parts/content', get_post_format() );
						} ?>	
					</div>				
				</div>
				<div class="col-md-3">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div><!-- .wrap -->
<?php } else { //$postNo = $wp_query->found_posts;  
	$getCatalog = get_category( get_query_var( 'cat' ) );
	// $obj = get_queried_object();
	// echo '<pre>';
	// print_r( $obj );
	// echo '</pre>';
	$nameCatalog = $getCatalog->name;
	$cat_slug =  $getCatalog->slug;
	$cat_id = $getCatalog->cat_ID;
	$parentCatalog = $getCatalog->parent;
	$cat_str;
	if($parentCatalog == 64) {
		$cat_str = str_replace("can-ban-", "", $cat_slug);
	} else {
		$cat_str = str_replace("cho-thue-", "", $cat_slug);
	}
	$getPost = array(
		'category__in' => array($cat_id),
		'tax_query' => array(
		  	'relation' => 'OR',
		  array(
		   'taxonomy' => 'loaibds',
		   'field' => 'slug',
		   'terms' => $cat_str
		  )
		),
		'post_status'   => 'publish',
		'post_type' => 'post', 
		'posts_per_page' => '12', 
		'paged'          => $paged, 
	);
	$all_post = new WP_Query($getPost);
	//ép string sang int $postNo = (int)($all_post->found_posts); 
	$postNo = $all_post->found_posts;

	?>
	<div class="container"><div class="wrap-crumbs my-3 my-md-4"><?php if(function_exists('breadcrumb')){breadcrumb();} ?></div></div>
	<div class="wrap-page archive-area pb-4 pb-md-5">
		<div class="container">
			<div class="row">
				<div class="col-md-9 catalog">	
					<div class="real-list">
						<h2 class="mb-3 mb-md-4"><?php echo $nameCatalog;?><span>Có <strong class="red"><?php echo $postNo; ?></strong> bất động sản.</span></h2>
						<?php if($all_post->have_posts()) {
					    while ( $all_post->have_posts() ):
					    	$all_post->the_post();
								$postid = get_the_ID();          
								if ($postNo<2) {
									get_template_part( 'template-parts/content', get_post_format() );
								} else {
									$dientich_post = get_post_meta( $postid, 'dientich_post', true );
									$gia_post = get_post_meta( $postid, 'gia_post', true );								
									$donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );		
									if($donvi_price_post) {
										$donvi_price_post = '/'.$donvi_price_post;
									}	 							
									$address_post = get_post_meta( $postid, 'address_post', true ); 			
									$phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);					
									$phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
									
									echo '<div class="row item my-3">
										<div class="col-12 col-sm-4 pr-sm-0">';
											if ( has_post_thumbnail() ) {
												echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'"><div class="img-effect-1 mb-3"><div class="rounded overflow-hidden">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid','alt' => get_the_title(),'loading' => 'lazy')).'</div></div></a>';
											} else {
												echo '<div class="no-img"><span>NO IMAGE</span></div>';
											}
										echo '</div>
										<div class="col-12 col-sm-8">
											<a href="'.get_the_permalink().'" title="'.get_the_title().'"><h3 class="mb-2">'.get_the_title().'</h3></a>
											<div class="block-att mb-2">';
												if($gia_post) {
													echo '<div class="my-1 my-md-3"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';
												}
												echo '<div class="listing-info">';
													if($phongngu_post) {
														echo '<div class="my-1 my-md-3"><i class="fa fa-bed mr-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
													}
													if($phongtam_post) {
														echo '<div class="my-1 my-md-3"><i class="fa fa-bath mr-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
													}
													if($dientich_post) {
														echo '<div class="my-1 my-md-3"><i class="fa fa-object-group mr-1" aria-hidden="true"></i> Diện tích: '.$dientich_post.'</div>';
													}
													if($address_post) {
                            echo '<div class="my-1 my-md-3"><i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span></div>';
                          }		
												echo '</div>';
											echo '</div>';
										echo '</div>'; 
									echo '</div>'; 
								}
							endwhile;
																			
							// the_posts_pagination( array(
							// 	'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
							// 	'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
							// 	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
							// ) );
							//echo panigation();
							echo "<div class='paginations text-center'>";	
								echo paginate_links( array(
									'base' => str_replace($big, '%#%', esc_url( get_pagenum_link($big ) ) ),
									'format' => '?paged=%#%',
									'prev_text'    => __('« <span class="hidden-xs">Trang trước</span>'),
									'next_text'    => __('<span class="hidden-xs">Trang tiếp theo</span> »'),
									'current' => max( 1, get_query_var('paged') ),
									'total' => $all_post->max_num_pages, //12 là post page $postNo /12
									) );
									
							echo "</div>";
						}	else {
							echo '<p class="font-weight-bold">Không có bất động sản nào</p>';
						} ?>	
					</div>				
				</div>
				<div class="col-md-3">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div><!-- .wrap -->
<?php }
//echo register_info();
get_footer();
