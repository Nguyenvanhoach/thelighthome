<?php
/*Template Name: BDSNB Template*/
get_header();
echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/assets/css/jquery-ui.min.css" type="text/css" media="all">
<script src="'.get_template_directory_uri().'/assets/js/jquery.min.js"></script>';
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

<div class="wrap-page py-4 py-md-5">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="real-list">
					<div class="row mb-4">
						<div class="col-12">
								<h2>Bất động sản nổi bật<span>Có <strong class="red"><?php echo $postNo; ?></strong> bất động sản.</span></h2>
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
								$donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );		
								if($donvi_price_post) {
									$donvi_price_post = '/'.$donvi_price_post;
								}	 				        
					    	?>   
								<div class="post-vipdb my-3 border-bottom">
									<div class="row item">
										<div class="col-5 col-md-4 pr-0"><a href="<?php echo get_the_permalink() ?>" title="<?php echo  get_the_title() ?>"><div class="post-media mb-3"><div class="rounded overflow-hidden"><?php echo get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid','alt' => get_the_title(),'loading' => 'lazy'));?></div></div></a></div>
										<div class="col-7 col-md-8">
											<a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>"><h3 class="mb-3"><?php the_title();?></h3></a>  
											<?php echo '<div class="block-att d-flex flex-wrap align-items-center justify-content-between mb-2">';
												if($gia_post) {
													echo '<div><span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';
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
							<?php  endwhile;
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
<script>
  $(document).ready(function() {
    $wrapRangSlide = $('.wrap-rang-slide');
    if($wrapRangSlide.length) {     
      $price_min = $('.price-min').val();
      $price_max = $('.price-max').val();      
      $( "#slider-range" ).slider({
        range: true,
        min: parseInt($price_min),
        max: parseInt($price_max),
        values: [ parseInt($price_min), parseInt($price_max) ],
        slide: function( event, ui ) {
          // $( "#amount-to").val(ui.values[ 0 ]);
          // $( "#amount-right").val(ui.values[ 1 ]);
          //$( "#amount-to").html($( "#slider-range" ).slider("values", 0 ));
          var price_min = ui.values[0];
          $.ajax({
            url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
            type : 'POST',
            dataType:"html",
            data : {'action' : 'priceMin_action','price_min':price_min},
            success : function (result){
              $("#amount-to").html(result);
            }
          });
          var price_max = ui.values[1];
          $.ajax({
            url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
            type : 'POST',
            dataType:"html",
            data : {'action' : 'priceMax_action','price_max':price_max},
            success : function (result){
              $("#amount-right").html(result);
            }
          });

          // $('.mo-left').html(ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' VNĐ');
          //   $('.mo-right').html(ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' VNĐ');
          $('.price-min').val(ui.values[0]);
          $('.price-max').val(ui.values[1]);
        }
      });
        $( "#amount-to").html($( "#slider-range" ).slider("values", 0 ) + ' đồng');
        var price_max = $( "#slider-range" ).slider("values", 1 );
        $.ajax({
          url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
          type : 'POST',
          dataType:"html",
          data : {'action' : 'priceMax_action','price_max':price_max},
          success : function (result){
            $("#amount-right").html(result);
          }
        });
      $('.price-min').val($( "#slider-range" ).slider("values", 0 ));
      $('.price-max').val($( "#slider-range" ).slider("values", 1 ));
    }
  } );
  </script> 
<?php 
//echo register_info();

get_footer();
