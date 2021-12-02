<?php 
	/*Template Name: Thay doi thong tin Template*/
	get_header();	
	session_start();
	$page_slug = get_post_field( 'post_name');
	wp_enqueue_media();
	if(is_user_logged_in()){
		$current_user = wp_get_current_user();
		global $wp_roles;
		$user_login = $current_user->user_login;		
		$avatar = get_user_meta($current_user->ID,'bdsttppic', true);
		$avatar_image =wp_get_attachment_image_src($avatar, 'medium');
		$error = array();  
		
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
			/* Update user password. */
			if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
				if ( $_POST['pass1'] == $_POST['pass2'] )
					wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
				else
					$error[] = __('Mật mã bạn nhập không khớp. Mật khẩu của bạn không được cập nhật.', 'profile');
			}
			/* Update user information. */
			if ( !empty( $_POST['url'] ) )
				wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
			if ( !empty( $_POST['email'] ) ){
				if (!is_email(esc_attr( $_POST['email'] )))
					$error[] = __('Email bạn đã nhập không hợp lệ. vui lòng thử lại.', 'profile');
				elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->id )
					$error[] = __('Email này đã được một người dùng khác sử dụng. thử một cái khác.', 'profile');
				else{
					wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
				}
			}
			if ( !empty( $_POST['display_name'] ) )
				update_user_meta( $current_user->ID, 'display_name', esc_attr( $_POST['display_name'] ) );
			if ( !empty( $_POST['phone'] ) )
				update_user_meta($current_user->ID, 'phone', esc_attr( $_POST['phone'] ) );
			if ( !empty( $_POST['description'] ) )
				update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
			/* Redirect so the page will show updated info.*/
		/*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
			if ( count($error) == 0 ) {
				//action hook for plugins and extra fields saving
				do_action('edit_user_profile_update', $current_user->ID);
				wp_redirect( get_permalink() );
				//exit;
			}
		}		
		?>
		<main class="main py-4 py-md-5">
			<div class="wrap-content">
				<div class="container">
					<div class="row">
						<div class="col-md-9 mb-3 mb-md-0">
							<div class="content-list">
								<h2><?php echo get_the_title();?></h2> 
								<p>&nbsp;</p>                
								<form method="post" id="adduser" action="<?php the_permalink(); ?>">
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Tên đăng nhập <b class="color-red">*</b>:</label>
										</div>
										<div class="col-md-8">
											<input type="text" disabled="true" name="" value="<?php echo $current_user->user_login;?>" class="form-control" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Email <b class="color-red">*</b>:</label>
										</div>
										<div class="col-md-8">
											<input type="text" name="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" class="form-control" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Mật khẩu:</label>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="pass1" type="password" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Nhập lại mật khẩu:</label>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="pass2" type="password" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Họ và tên:</label>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="display_name" type="text" value="<?php the_author_meta( 'display_name', $current_user->ID ); ?>" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Điện thoại:</label>
										</div>
										<div class="col-md-8">
											<input name="phone" type="text" value="<?php the_author_meta( 'phone', $current_user->ID ); ?>" class="form-control" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Website:</label>
										</div>
										<div class="col-md-8">
											<input name="url" type="text" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" class="form-control" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="color-primary font-weight-bold">Thông tin tiểu sử:</label>
										</div>
										<div class="col-md-8">
											<textarea name="description" rows="3" cols="50" class="form-control"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
										</div>
									</div>                   

									<?php 
										//action hook for plugin and extra fields
										do_action('edit_user_profile',$current_user); 
									?>
									<p class="form-submit text-right">
										<?php //echo $referer; ?>
										<input name="updateuser" type="submit" id="updateuser" class="btn btn-primary" value="<?php _e('Cập Nhật Thông Tin', 'profile'); ?>" />
										<?php wp_nonce_field( 'update-user' ) ?>
										<input name="action" type="hidden" id="action" value="update-user" />
									</p><!-- .form-submit -->
								</form>

								<?php if ( count($error) > 0 ) echo '<p class="text-danger">' . implode("<br />", $error) . '</p>'; ?>
							
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
		<script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script>
		            
	<?php } else {
		echo '<script>window.location = "'.get_bloginfo( 'url' ).'/wp-login.php"</script>';
	} 
get_footer(); ?>
<script src="<?php echo get_template_directory_uri();?>/uploadavatar.js"></script>
