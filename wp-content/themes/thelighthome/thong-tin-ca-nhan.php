<?php 
	/*Template Name: Thong Tin Ca Nhan Template*/
	get_header();	
	session_start();
	$page_slug = get_post_field( 'post_name');
	if(is_user_logged_in()){
		$current_user = wp_get_current_user();
		$user_login = $current_user->user_login;
		
		$avatar = get_user_meta($current_user->ID,'bdsttppic', true);
		$avatar_image =wp_get_attachment_image_src($avatar, 'medium');
		$page_slug = get_post_field( 'post_name');
		?>

		<main class="main py-4 py-md-5">
			<div class="wrap-content">
				<div class="container">
					<div class="row">
						<div class="col-md-9 mb-3 mb-md-0">
							<div class="content-list">
								<h2><?php echo get_the_title();?></h2> 
								<div class="row form-group">
									<div class="col-md-4">
										<label class="color-primary font-weight-bold">Tên Đăng Nhập:</label>
									</div>
									<div class="col-md-8">
										<strong><?php echo $user_login; ?></strong>
									</div>
								</div>	
								<div class="row form-group">
									<div class="col-md-4">
										<label class="color-primary font-weight-bold">Họ Và Tên:</label>
									</div>
									<div class="col-md-8">
										<strong><?php echo $current_user->display_name; ?></strong>
									</div>
								</div>		
								<div class="row form-group">
									<div class="col-md-4">
										<label class="color-primary font-weight-bold">Email:</label>
									</div>
									<div class="col-md-8">
										<strong><?php echo $current_user->user_email; ?></strong>
									</div>
								</div>		
								<div class="row form-group">
									<div class="col-md-4">
										<label class="color-primary font-weight-bold">Điện Thoại:</label>
									</div>
									<div class="col-md-8">
										<strong><?php echo $current_user->phone; ?></strong>
									</div>
								</div>	
								<div class="row form-group">
									<div class="col-md-4">
										<label class="color-primary font-weight-bold">Địa Chỉ:</label>
									</div>
									<div class="col-md-8">
										<strong><?php echo $current_user->user_address; ?></strong>
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
get_footer(); ?>