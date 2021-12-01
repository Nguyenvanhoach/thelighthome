<?php 
	/*Template Name: Quan Ly Tin Đang Template*/
	get_header();	//session_start();
	$page_slug = get_post_field( 'post_name');
	$date_now = date("d-m-Y");	
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$userid = $current_user->ID;
		$full_name_u = $current_user->display_name;
		$avatar = get_user_meta($current_user->ID,'bdsttppic', true);
		$avatar_image =wp_get_attachment_image_src($avatar, 'medium');
		$user_meta=get_userdata($userid);
		$user_roles=$user_meta->roles[0]; 
		?>
		<main class="main py-4 py-md-5">
			<div class="wrap-content-user">
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<div class="content-user">
								<div class="block-general">
									<h3><i class="fa fa-tasks"></i>&nbsp;Quản lý tin rao bán / cho thuê</h3>
									<div class="content-block p-3">
										<a style="color:#fff;margin:10px 0;" href="<?php bloginfo("url");?>/dang-tin" class="btn btn-primary" role="button">
											<i class="fa fa-pencil"></i> Viết bài
										</a>
										<div class="table-fluid">
										<table class="table table-bordered table-striped tble-post">
											<thead>
												<tr>
													<th class="text-center">STT</th>
													<th class="text-center">Mã tin</th>
													<th class="text-center">Tiêu đề</th>
													<th class="text-center">Trạng thái</th>
													<th class="text-center">Lượt xem</th>
													<th class="text-center">Công cụ</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$bdsttp = new WP_Query(array(
												'post_status' => array('publish', 'pending'),
												// 'meta_key' => 'dateend_post',
												// 'orderby' => 'dateend_post',
												// 'meta_type' => 'DATE',
												// 'order' => 'DESC',
												'orderby' => 'date',
								                'order'   => 'DESC',
												'author' => $userid,
												'paged' => get_query_var('paged'),
												'posts_per_page'=> 20));
												$stt_random='1';									
												?>
												<?php while ($bdsttp->have_posts()) : $bdsttp->the_post();													
													$postid = get_the_ID();
													$get_title = get_post($postid); 
													$datestart_post =  get_post_meta( $postid, 'datestart_post', true );
													$dateend_post =  get_post_meta( $postid, 'dateend_post', true );
													$dateend_post_date = date('d-m-Y', strtotime(str_replace('/', '-', $dateend_post)));

													if($user_roles ==='editor' || $user_roles ==='administrator') {
														if(strtotime($date_now) > strtotime($dateend_post_date)) { 
															$update_post_status = array( 'ID' => $postid, 'post_status' => 'publish' );
															wp_update_post($update_post_status);
														}
													} else {
														if(strtotime($date_now) > strtotime($dateend_post_date)) { 
															$update_post_status = array( 'ID' => $postid, 'post_status' => 'pending' );
															wp_update_post($update_post_status);
														}
													}
													
													?>
												<tr>
													<td class="text-center"><?php echo $stt_random; ?></td>
													<td class="text-center"><?php echo $postid; ?></td>
													<td class="text-center" style="width: 25%">
														<div class="media">
														<?php if (has_post_thumbnail()) {?>
														<div class="media-left">
															<a href="<?php the_permalink() ;?>" style="width: 60px;display: block">
																<?php echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' =>'media-object img-fluid')); ?>
															</a>
														</div>
														<?php }?>
														<div class="media-body text-left pl-2 text-capitalize">
															<a style="color: red;" target="_blank" href="<?php the_permalink() ;?>"><?php echo $get_title->post_title; ?></a>
														</div>
														</div>

													</td>
													<td class="text-center"><span><?php $stt = get_post_status($postid); if($stt=="publish"){ echo "Đã duyệt"; } else {echo "Chờ duyệt";  } ?></span></td>
													<td class="text-center"><?php  echo getPostViews(get_the_ID()); ?></td>
													<td class="text-center"><div class="tools"><a target="_blank" href="<?php bloginfo('url');?>/sua-tin?postid=<?php echo $postid; ?>" title="Chỉnh sửa: <?php the_title() ;?>"><i class="fa fa-fw fa-lg fa-pencil-square-o"></i></a><a onclick="return confirm(&quot;Bạn có chắc chắn muốn xóa tin này? &quot;);" href="<?php echo get_delete_post_link($postid); ?>" title="Xóa: <?php the_title() ;?>"><i class="fa fa-fw fa-lg fa fa-trash-o"></i></a>
													</div></td>
												</tr>

											<?php $stt_random=$stt_random+1; endwhile ; wp_reset_query() ;?>
											</tbody>
										</table>
									</div>
										<?php if (function_exists('wp_pagenavi')) { wp_pagenavi( array( 'query' => $bdsttp ) ); } ?>
				
									</div>
								</div>					
							</div>
						</div>
						<div class="col-md-3">
							<div class="slide-bar"> 
								<div class="block-bar"> 
									<h3>Trang Cá Nhân</h3> 
									<div class="profesional-img text-center">
										<?php if($avatar_image) { ?>
											<img src="<?php echo $avatar_image[0];?>" alt="<?php echo $user_login;?>" class="center-block img-fluid">  
										<?php } else {?>
											<i class="fa fa-user" aria-hidden="true"></i>
										<?php } ?>
									</div>
									<div class="full-name text-center font-weight-bold text-uppercase"><?php echo $current_user->display_name; ?></div>
								</div>                       
								<div class="block-bar">
									<h3>Quản Lý Tin đăng</h3>
									<ul class="list-unstyled">
									<li class="<?php if($page_slug==='quan-ly-tin-dang') echo"active"?>">
										<a href="<?php echo bloginfo('url').'/quan-ly-tin-dang'; ?>" title="Quản lý tin đăng">Quản lý tin đăng</a>
									</li>
									<li class="<?php if($page_slug==='dang-tin') echo"active"?>">
										<a href="<?php echo bloginfo('url').'/dang-tin'; ?>" title="Đăng tin">Đăng tin</a>
									</li>
									</ul>
								</div>   
								<div class="block-bar">
									<h3>Quản Lý Thông cá nhân</h3>
									<ul class="list-unstyled">
										<li class="<?php if($page_slug==='thong-tin-ca-nhan') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thong-tin-ca-nhan'; ?>" title="Thông tin cá nhân"><i class="fa fa-user mr-1"></i>Thông tin cá nhân</a>
										</li>
										<li class="<?php if($page_slug==='thay-doi-thong-tin') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thay-doi-thong-tin'; ?>" title="Thay đổi thông tin cá nhân"><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Thay đổi thông tin cá nhân</a>
										</li>
										<li class="<?php if($page_slug==='thay-doi-mat-khau') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thay-doi-mat-khau'; ?>" title="Thay đổi mật khẩu"><i class="fa fa-refresh mr-1"></i>Thay đổi mật khẩu</a>
										</li>
										<li class="<?php if($page_slug==='dang-xuat') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/dang-xuat'; ?>" title="Đăng Xuất"><i class="fa fa-sign-out mr-1"></i>Đăng Xuất</a>
										</li>
									</ul>
								</div>    
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	<?php } else {
		echo '<script>window.location = "'.get_bloginfo( 'url' ).'/wp-login.php"</script>';
	} 
get_footer(); 
?>
