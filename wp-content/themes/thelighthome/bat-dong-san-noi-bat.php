<?php
/*Template Name: BDSNB Template*/
get_header();
 $big = 999999999;
if ( get_query_var('paged') ) {
  $paged = get_query_var('paged'); 
} elseif ( get_query_var('page') ) { 
  $paged = get_query_var('page');
} else {
  $paged = 1;
}   
$post = array(
	'post_status'   => 'publish',
	'post_type' => 'post', 
	'posts_per_page' => '12', 
	'paged'          => $paged, 
	'meta_query' => array(
		array(
			'key'     => 'check_special',
			'value'   => 'on',
			'compare' => 'IN',
		),
	),
);
$getPost = new WP_Query( $post );
$postNo = $getPost->found_posts; ?>

<div class="wrap-page py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="real-list">
					<div class="row mb-4">
			            <div class="col-md-8">
			                <h2>Bất động sản nổi bật<span>Có <strong class="red"><?php echo $postNo; ?></strong> bất động sản.</span></h2>
			            </div>
			            <div class="col-md-4">
			            	<div class="d-flex">
				                <div class="send-alert ml-md-auto" data-toggle="modal" data-target="#send-alert-modal">
				                  <a href="#" title="Nhận tin bất động sản theo tiêu chí của bạn">
				                    <span>Nhận tin bất động sản theo tiêu chí của bạn</span>
				                    <i class="fa fa-bell-o" aria-hidden="true"></i>
				                  </a>
				                </div>				            		
			            	</div>
			            </div>
			        </div>	
					<?php 
					  if($getPost->have_posts()) {
					    while ( $getPost->have_posts() ) : $getPost->the_post();
							$postid = get_the_ID();          
							$dientich_post = get_post_meta( $postid, 'dientich_post', true );
							$gia_post = get_post_meta( $postid, 'gia_post', true );
							$address_post = get_post_meta( $postid, 'address_post', true );	
							$phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
							$phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);						        
					      	?>   
						      	<div class="post-vipdb my-3 border-bottom">
				                    <div class="row item">
				                        <div class="col-5 col-md-4 pr-0"><a href="<?php echo get_the_permalink() ?>" title="<?php echo  get_the_title() ?>"><div class="post-media mb-3"><div class="img-wrap rounded overflow-hidden"><?php echo get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid','alt' => get_the_title(),'loading' => 'lazy'));?></div></div></a></div>
				                        
				                        <div class="col-7 col-md-8">
				                          	<a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>"><h3 class="mb-3"><?php the_title();?></h3></a>  
				                            <?php 
					                            echo '<div class="block-att d-flex flex-wrap align-items-center justify-content-between mb-2">';
													if($gia_post) {
										            	echo '<div class="listing-price">'.$gia_post.'</div>';
										            }
										            echo '<div class="listing-info d-flex flex-wrap align-items-center">';
										            	if($phongngu_post) {
											            	echo '<div class="mx-1"><i class="fa fa-bed mr-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
											            }
											            if($phongtam_post) {
											            	echo '<div class="mx-1"><i class="fa fa-bath mr-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
											            }
											            if($dientich_post) {
											            	echo '<div class="mx-1"><i class="fa fa-object-group mr-1" aria-hidden="true"></i>'.$dientich_post.'</div>';
											            }
													echo '</div>';
												echo '</div>'; 
											?>
					                        <div class="description d-none d-md-block"><?php echo trim_text_to_words(get_the_content(), 350); ?></div>
				                        </div>   
			                      	</div>
			                    </div>   
					    	<?php          
					    endwhile;
					    //Reset Post Data
						}
					    wp_reset_postdata();
					?>	
				</div>	
				<?php //echo panigation(); 
				echo "<div class='paginations text-center my-4'>";		
					echo paginate_links( array(
						'base' => str_replace($big, '%#%', esc_url( get_pagenum_link($big ) ) ),
						'format' => '?paged=%#%',
						'prev_text'    => __('« <span class="hidden-xs">Trang trước</span>'),
						'next_text'    => __('<span class="hidden-xs">Trang tiếp theo</span> »'),
						'current' => max( 1, get_query_var('paged') ),
						'total' => $getPost->found_posts/12, //12 là post page
						) );
				    
				echo "</div>";
				?>		
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div><!-- .wrap -->
<?php 
echo register_info();
get_footer();
