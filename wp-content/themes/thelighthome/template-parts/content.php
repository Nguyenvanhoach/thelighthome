<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
$postid = get_the_ID();
$post_author_id = get_post_field( 'post_author', $postid );   
$display_name = get_post_meta($postid,'tenlienhe_post',true);
if($display_name == '') {
	$display_name ='Thelighthome';
}
$phoneAuthor = get_post_meta($postid,'phone_post',true); 
if($phoneAuthor == '') {
	$phoneAuthor ='0983155353';
}
$emailAuthor = get_post_meta($postid,'user_email_post',true); 
if($emailAuthor == '') {
	$emailAuthor ='thelighthomevn@gmail.com';
}
$loai_bds = get_the_terms( $postid, 'loaibds' );
$loaibds = $loai_bds[0]->name;
$khuvuc = get_the_terms( $postid, 'khuvucbds' );
$city_id = get_post_meta( $postid, 'city_post', true );	
$tbl_city = "{$wpdb->prefix}tinh_thanhpho";
$citydb = $wpdb->get_row("SELECT matp,name FROM $tbl_city WHERE matp = $city_id", ARRAY_A);		
$city_post = $citydb['name'];
$address_post = get_post_meta( $postid, 'address_post', true );
$dientich_post = get_post_meta( $postid, 'dientich_post', true );
$gia_post = get_post_meta( $postid, 'gia_post', true );
$donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );
if($donvi_price_post) {
	$donvi_price_post = '/'.$donvi_price_post;
}
$sotang_post = get_post_meta( $postid, 'sotang_post', true );	
$phongngu_post = get_post_meta( $postid, 'phongngu_post', true );
$phongtam_post = get_post_meta( $postid, 'phongtam_post', true );
$tienichkemtheo_post = get_post_meta( $postid, 'tienichkemtheo_post', true );
$dacdiemxahoi_post = get_post_meta( $postid, 'dacdiemxahoi_post', true );
$phaply_post = get_post_meta( $postid, 'phaply_post', true );	
$gallery_images = get_post_meta($postid, 'tdc_gallery_id',true);
$bd_post = get_post_meta($postid,'bd_post',true);
$video_post = get_post_meta($postid,'video_post',true);
$huongnha_post = get_post_meta($postid,'huongnha_post',true);	
$huongbancong_post = get_post_meta($postid,'huongbancong_post',true);	
$duongvao_post = get_post_meta($postid,'duongvao_post',true);	
$mattien_post = get_post_meta($postid,'mattien_post',true);	
$noithat_post = get_post_meta($postid,'noithat_post',true);
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="content-single">
		<div class="row item mb-4">	
			<div class="col-md-9 col-lg-8">
				<?php 
					if($gallery_images) { 
						echo '<div data-gallery class="gallary-img"><div class="slider-for mb-3">';
							foreach ($gallery_images as $image) { 
								echo '<div class="img-cover cursor-pointer getimg" data-image-id="" data-toggle="modal" data-image="'.wp_get_attachment_url($image, 'large').'"	data-target="#image-gallery"><img src="'.wp_get_attachment_url($image, 'large').'" alt="'.get_the_title().'" class="img-fluid mx-auto d-block" loading="lazy"></div>';
							}
							echo '</div><div class="slider-nav text-center">';
								foreach ($gallery_images as $image) { 
									echo '<div class="item px-1 px-lg-2"><div class="border-1 p-1 fix-h-thumb d-flex align-items-center"><img src="'.wp_get_attachment_url($image, 'large').'" class="img-fluid d-block mx-auto" alt="'.get_the_title().'" loading="lazy"></div></div>';
								}
						echo '</div></div>';
					} else { echo get_the_post_thumbnail( $postid, '', array('class' => 'img-fluid img-fit', 'loading' => 'lazy')); }
				?>
			</div>    
			<div class="col-md-3 col-lg-4 d-none d-md-block">
				<div class="contact-author p-3 p-md-2 p-lg-3 ">
					<h3 class="text-center text-uppercase title-contact mb-4"><span>Liên hệ</span></h3>
					<div class="media mb-3 align-items-center">
						<div class="media-avatar mr-2 mr-lg-3">
							<img src="<?php echo get_template_directory_uri();?>/assets/images/support.jpg" alt="<?php echo $display_name;?>" class="img-fluid rounded" loading="lazy">
						</div>
						<div class="user-detail">
							<h4><a class="text-uppercase" href="<?php echo site_url().'/author/'.get_the_author_meta( 'user_nicename' , $post_author_id ); ?>" title="<?php echo $display_name;?>"><?php echo $display_name;?></a></h4>
							<div class="call-hotline mb-3">
								<a class="btn px-0 mx-auto py-1" href="tel:<?php echo $phoneAuthor; ?>"><i class="fa-lg fa-fw fa fa-phone" aria-hidden="true"></i>&nbsp;<?php echo $phoneAuthor; ?></a>
							</div>
						</div>
					</div>
					<?php thongdiep(); ?>
				</div>                    
			</div>              
	  </div>
		<div class="descript-post">
			<h3 class="title-post pb-1 mb-4"><?php echo get_the_title();?></h3>
			<div class="detail-attr mb-4">
				<h4 class="title-block mb-4"><span class="text-capitalize">Thông tin cơ bản</span></h4>
				<div class="inner-detail-attr px-4 pt-4 pb-2">		      		
					<div class="row">
						<div class="col-md-6 col-lg-4">
							<div class="media mb-3 pb-1">
								<div class="attr-name pr-2">
									<strong>Mã BĐS:</strong>
								</div>
								<div class="media-body text-right">
									<?php echo $postid; ?>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="media mb-3 pb-1">
								<div class="attr-name pr-2">
									<strong>Ngày đăng:</strong>
								</div>
								<div class="media-body text-right">
									<?php echo get_the_time('d-m-Y'); ?>
								</div>
							</div>
						</div>
						<?php if($loaibds) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Thể loại:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $loaibds; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($khuvuc) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Khu vực:</strong>
									</div>
									<div class="media-body text-right">
										<?php foreach($khuvuc as $kv) {
											echo $kv->name; 
										}	?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($address_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Địa chỉ:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $address_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($gia_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Giá tiền:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo '<strong>'.price($gia_post) .'</strong><span class="text-lowercase">'.$donvi_price_post.'</span>'; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($dientich_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Diện tích:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $dientich_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($sotang_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Số tầng:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $sotang_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($phongngu_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Số phòng ngủ:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $phongngu_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($phongtam_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Số phòng tắm:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $phongtam_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($huongnha_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Hướng nhà:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $huongnha_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($huongbancong_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Hướng ban công:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $huongbancong_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($duongvao_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Đường vào:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $duongvao_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($mattien_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Mặt tiền:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $mattien_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($noithat_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Nội thất:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $noithat_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if($tienichkemtheo_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Tiện ích kèm theo:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $tienichkemtheo_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($dacdiemxahoi_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Đặc điểm xã hội:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $dacdiemxahoi_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if($phaply_post) { ?>
							<div class="col-md-6 col-lg-4">
								<div class="media mb-3 pb-1">
									<div class="attr-name pr-2">
										<strong>Pháp lý:</strong>
									</div>
									<div class="media-body text-right">
										<?php echo $phaply_post; ?>
									</div>
								</div>
							</div>
						<?php } ?>	      		
					</div>	      	
				</div>
			</div>
			<div class="row mb-4">
				<div class="col-12 content-des-post">
					<h4 class="title-block mb-2"><span class="text-capitalize">Tổng quan</span></h4>
					<?php echo the_content(); ?>
				</div>	        
			</div>
			
			<?php if($video_post){ 
				$youtube_id = getYouTubeVideoId($video_post);
				echo '<div class="video mb-3"><h4 class="title-block mb-2 text-capitalize">Xem Video</h4><div class="content-video"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div></div>';
				?>	      
			<?php }?>
			<?php if($bd_post){?>
				<div class="mapbd mb-3">
					<h4 class="title-block mb-2 text-capitalize">Xem bản đồ</h4>
					<div class="content-map">
						<input autocomplete="on" id="pac-input" class="controls" type="hidden" value="<?php echo $bd_post;?>" placeholder="<?php echo $bd_post;?>">	            	
					</div>
           <!-- <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script> -->
					<script type="text/javascript">
						jQuery(document).ready(function ($) {
							var addr = '<?php echo $bd_post; ?>';
							var embed= '<iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q='+ encodeURIComponent(addr) + '&t=&z=15&ie=UTF8&iwloc=&output=embed" style="border:0" allowfullscreen="" loading="lazy"></iframe>';  
							$('.mapcanvas').html(embed);
						});
					</script>
					<div class="mapcanvas"></div>	     
				</div>
			<?php } else {?>
				<div class="mapbd">
					<h4 class="title-block mb-2 text-capitalize">Xem bản đồ</h4>
					<div class="content-map">
						<input autocomplete="on" id="pac-input" class="controls" type="hidden" value="<?php echo $address_post;?>" placeholder="<?php echo $address_post;?>">	            	
					</div>
					<!-- <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script> -->
					<script type="text/javascript">
						jQuery(document).ready(function ($) {
							var addr = '<?php echo $address_post; ?>';
							var embed= '<iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q='+ encodeURIComponent(addr) + '&t=&z=15&ie=UTF8&iwloc=&output=embed" style="border:0" allowfullscreen="" loading="lazy"></iframe>';  
							$('.mapcanvas').html(embed);
						});
					</script>
					<div class="mapcanvas"></div>	     
				</div>
			<?php }?>
			<div class="d-flex flex-wrap align-items-center mb-4 mb-md-0">
				<?php if(function_exists('share_social')){ echo share_social(); } ?>
			</div>
			<?php if(get_option('facebook') !='') {?>
				<div class="comment-fb">
					<div id="fb-root"></div>
					<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=215651349123280&autoLogAppEvents=1" nonce="cqxFH3YP"></script>
					<div class="fb-comments" data-width="100%" data-href="<?php echo get_option('facebook'); ?>" data-numposts="3"></div>
				</div>
			<?php } ?>
			
			<div class="col-12 d-md-none">
				<div class="contact-author p-3 p-md-2 p-lg-3 ">
					<h3 class="text-center text-uppercase title-contact mb-4"><span>Liên hệ</span></h3>
					<div class="media mb-3 align-items-center">
						<div class="media-avatar mr-2 mr-lg-3">
							<img src="<?php echo get_template_directory_uri();?>/assets/images/support.jpg" alt="<?php echo $display_name;?>" class="img-fluid rounded">
						</div>
						<div class="user-detail">
							<h4><a class="text-uppercase" href="<?php echo site_url().'/author/'.get_the_author_meta( 'user_nicename' , $post_author_id ); ?>" title="<?php echo $display_name;?>"><?php echo $display_name;?></a></h4>
							<div class="call-hotline text-center">
								<a class="btn px-0 mx-auto py-1" href="tel:<?php echo $phoneAuthor; ?>"><i class="fa-lg fa-fw fa fa-phone" aria-hidden="true"></i>&nbsp;<?php echo $phoneAuthor; ?></a>
							</div>
						</div>
					</div>
					<?php thongdiep(); ?>
				</div>                    
			</div> 		
			
			<?php echo related_posts('16');?>	      	
		</div>
	</div>	
</article><!-- .post -->

<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-body p-0">
				<button type="button" class="btn btn-close d-flex align-items-center justify-content-center" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<img id="image-gallery-image" class="img-fluid mx-auto d-block" src="">
				<button type="button" class="btn btn-secondary btn-arrow btn-prev" id="show-previous-image"><i class="fa fa-arrow-left"></i></button>
				<button type="button" id="show-next-image" class="btn btn-secondary btn-arrow btn-next"><i class="fa fa-arrow-right"></i></button>
			</div>
		</div>
	</div>
</div>
