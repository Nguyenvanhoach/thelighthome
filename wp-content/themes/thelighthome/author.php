<?php 
	/*Template Name: Author Template*/
	get_header();	
	global $wpdb; 
	$curauth = $wp_query->get_queried_object();
	$authid = $curauth->ID;
	$avatar = get_user_meta($authid,'bdsttppic', true);
	$avatar_image =wp_get_attachment_image_src($avatar, 'medium');
	$phone = $curauth->phone;
	$user_email = $curauth->user_email;
	$address = $curauth->user_address;
	$website = $curauth->user_url;
	$user_info = get_userdata($authid);
	$roles_user = implode(', ', $user_info->roles);

	$post_user = array(
		'post_status'   => 'publish',
		'post_type' => 'post', 
		'posts_per_page' => '6',
		'paged'          => $paged,
		'role' => $roles,
		'author'        =>  $authid, 
		'meta_key'     => 'sort_loaitin',
		'orderby'       =>'meta_value',
		'order' => 'ASC',
    );
    $listpost_user = new WP_Query($post_user);
?>
<main class="main">
	<div class="wrap-page infor-author py-4 py-md-5">
		<div class="container">
			<div class="row">
				<div class="col-md-9">					
					<h1 class="entry-title">Thông tin môi giới</h1>
					<div class="row">
						<div class="col-4 col-md-3">
							<img src="<?php echo $avatar_image[0];?>" class="img-fluid center-block" alt="">
						</div>	
						<div class="col-8 col-md-9">
							<div class="detail-author">
								<div class="broke-name"><?php echo $curauth->display_name;?></div>
								<?php if($phone) {?>
									<div class="phone-member"><a href="tel:<?php echo $phone;?>"><?php echo $phone?></a></div>
								<?php } ?>
								<?php if($user_email) {?>
								<div class="email-member"><a title="bdsthanhthuyphat@gmail.com" href="mailto:<?php echo $user_email;?>"><?php echo $user_email;?></a></div>
								<?php } ?>
								<?php if($address) {?>
								<div class="address-member"><?php echo $address;?></div>
								<?php } ?>
								<?php if($website) {?>
								<div class="website-member"><a href="<?php echo $website;?>" target="_blank"><?php echo $website;?></a></div>
								<?php } ?>
							</div>							
						</div>	
					</div>
					<div class="list-moigioi">
						<h2 class="title-h2">Danh sách tin rao</h2>
						<div class="real-list">
							<?php if($listpost_user->have_posts()) {
				              while ( $listpost_user->have_posts() ) : $listpost_user->the_post();
				                $postid = get_the_ID();
				                $loaitinrao_post = get_post_meta( $postid, 'loaitinrao_post', true ); 
				                $post_author_id = get_post_field( 'post_author', $postid );   
				                $display_name = get_the_author_meta( 'display_name' , $post_author_id );  
				                $dientich_post = get_post_meta( $postid, 'dientich_post', true );
				                $content = get_the_content(); 
				                $gia_post = get_post_meta( $postid, 'gia_post', true );
				                if ($gia_post>=1000000000) {
				                  $gia_post = $gia_post / 1000000000;
				                }
				                $donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );
				                if($donvi_price_post<=0 && $gia_post <=0) {
				                  $donvi_price_post ='Thỏa thuận';
				                }else if($donvi_price_post<=1000000) {
				                  $donvi_price_post ='Triệu';
				                }else if($donvi_price_post<=1000000000) {
				                  $donvi_price_post ='Tỷ';
				                }
				                $address_post = get_post_meta( $postid, 'address_post', true ); 
				                $sort_loaitin = get_post_meta( $postid, 'sort_loaitin', true );
				                if ( has_post_thumbnail() ) {?>
				                    <div class="post-vipdb">
				                      <div class="row space-1 item">
				                        <div class="col-sm-2"><a href="<?php echo get_the_permalink() ?>" title="<?php echo  get_the_title() ?>"><?php echo get_the_post_thumbnail( $postid, 'thumbnail', array( 'class' => 'img-fluid' ) );?></a></div>
				                        <div class="col-sm-10">
				                          <a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>">
				                            <h3><?php the_title();?></h3>
				                            <div class="author">
				                              <i class="fa fa-user"></i>
				                              <span class="text-uppercase"><?php echo $display_name;?></span>
				                              <span class="datetime">
				                               <i class="fa fa-clock-o"></i><?php echo get_the_date();?>
				                              </span>
				                            </div>
				                            <div class="description"><?php echo substr(strip_tags($content), 0, 250);?>...</div>
				                            <div class="block-bottom">
				                              <span class="block-price">Giá:&nbsp;<span><?php echo $gia_post; ?> <?php echo $donvi_price_post;?></span></span>
				                              <span class="dientich">Diện tích:&nbsp;<strong class="color-primary"><?php echo $dientich_post;?> m2</strong></span>
				                              <?php if($address_post){?>Địa chỉ:&nbsp;<strong class="color-primary"><?php echo $address_post; ?></strong> <?php }?>
				                            </div>  
				                            </a>                
				                        </div>                  
				                      </div>
				                    </div>
				                  <?php } else {?>
				                    <div class="post-vipdb">
				                      <div class="row space-1 item">
				                        <div class="col-sm-2"><a href="<?php echo get_the_permalink() ?>" title="<?php echo  get_the_title() ?>"><div class="no-img"><span>NO IMAGE</span></div></a></div>
				                        <div class="col-sm-10">
				                          <a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>">
				                            <h3><?php the_title();?></h3>
				                            <div class="author">
				                              <i class="fa fa-user"></i>
				                              <span class="text-uppercase"><?php echo $display_name;?></span>
				                              <span class="datetime">
				                               <i class="fa fa-clock-o"></i><?php echo get_the_date();?>
				                              </span>
				                            </div>
				                            <div class="description"><?php echo substr(strip_tags($content), 0, 250);?>...</div>
				                            <div class="block-bottom">
				                              <span class="block-price">Giá:&nbsp;<span><?php echo $gia_post; ?> <?php echo $donvi_price_post;?></span></span>
				                              <span class="dientich">Diện tích:&nbsp;<strong class="color-primary"><?php echo $dientich_post;?> m2</strong></span>
				                              <?php if($address_post){?>Địa chỉ:&nbsp;<strong class="color-primary"><?php echo $address_post; ?></strong> <?php }?>
				                            </div>  
				                            </a>                
				                        </div>                  
				                      </div>
				                    </div>
				                <?php } 
				              endwhile;
				              echo "<div class='paginations text-center'>";
				                echo get_pagination($listpost_user);
				              echo "</div>";
				              //Reset Post Data
				              wp_reset_postdata();
				            } else {
				              echo "Chưa có bất động sản nào đăng tin";
				            }
				          ?> 
			          	</div>
					</div>
					<div class="list-user-another">						
						<?php if($account_type) {
							echo '<h2 class="title-h2">Các nhà mô giới khác <a class="view-user-another" href="https://batdongsanttp.vn/thanh-vien?account_type=doanh-nghiep" title="Xem thêm nhà môi giới khác">Xem thêm cá nhân môi giới</a></h2>';
						} else {
							echo '<h2 class="title-h2">Các nhà mô giới khác <a class="view-user-another" href="https://batdongsanttp.vn/thanh-vien" title="Xem thêm nhà môi giới khác">Xem thêm công ty môi giới</a></h2>';
						}?>
						<?php echo getUserAnother($roles_user,'6',$authid)?>
					</div>
				</div>
				<div class="col-sm-3">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>