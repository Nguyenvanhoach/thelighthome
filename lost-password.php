<?php
require( dirname(__FILE__) . '/wp-load.php' );

get_header();
?>
	<main class="main">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 center">
					<div class="block-2">
						<h3>Lấy Mật khẩu</h3>
						<div class="content-block">
		
		<?php
			$result = array('status' => 0);
			//require(get_template_directory_uri().'/PHPMailer-5.2.16/PHPMailerAutoload.php');		
			require(dirname(__FILE__).'/wp-content/themes/twentyseventeen/PHPMailer-5.2.16/PHPMailerAutoload.php');
			$mail  = new PHPMailer();
			$body = "";	
			$mail->IsSMTP();
			// $mail->SMTPDebug  = 1;
			$mail->SMTPAuth   = true;
			$mail->Host       = "smtp.gmail.com";
			$mail->SMTPSecure = 'tsl';//tsl
			$mail->Port       = 587;//587
			$mail->Username   = "automails123@gmail.com";
			$mail->Password   = "Khongthequen89";
			$mail->SetFrom('admin@gmail.com');
			$mail->Subject    = 'Change Password';	
			global $wpdb;
			$error = '';
			$success = '';

			// check if we're in reset form
			if( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) {
				
				$email = trim($_POST['email_login']);

				if( empty( $email ) ) {
					$error = 'Nhập vào địa chỉ Email cần thay đổi Mật khẩu';
				} else if( ! is_email( $email )) {
					$error = 'Địa chỉ Email của bạn không đúng.';
				} else if( ! email_exists( $email ) ) {
					$error = 'Địa chỉ Email của bạn không có trong hệ thống của chúng tôi.';
				} else {					
					$random_password = wp_generate_password( 12, false );
					$user = get_user_by( 'email', $email );
					$updatePass = wp_hash_password($random_password);var_dump($updatePass);
					$update_user = wp_update_user( array (
							'ID' => $user->ID,
							'user_pass' => $updatePass
						)
					);echo "sss";
					// if  update user return true then lets send user an email containing the new password
					if( $update_user ) {
						var_dump($updatePass);
						$mail->addAddress($email);
						//$mail->addCC('nguyenvanhoachtech@gmail.com');
						//$mail->addBCC('congnghethaydoicuocsong@gmail.com');
						$body = 'Your new password is: '.$random_password;
						$mail->MsgHTML($body);
						if(!$mail->Send()) {
							echo "Mailer Error: " . $mail->ErrorInfo;
							$result['msg'] = 'There is an error, please check your input and try again';
							$result['debug'] = $mail->ErrorInfo;
						} else {
							$result['status'] = 1;
							echo "Thay đổi mật khẩu thành công. Xin vui lòng kiểm tra hộp thư email của bạn để lấy mật khẩu!";
						}					
					} else {
						$error = 'Đã xảy ra sự cố khi cập nhật tài khoản của bạn.';
					}
				}
				if( ! empty( $error ) )
					echo '<p class="error"><strong>LỖI:</strong> '. $error .'</p>';

				if( ! empty( $success ) )
					echo '<p class="success">'. $success .'</p>';
			}
		?>	<!--html code-->
		<form method="post">
			<div class="form-group">
				<p><b>Hãy điền địa chỉ email của bạn. Bạn sẽ nhận được một liên kết để tạo mật khẩu mới qua email.</b></p>
			</div>
			<div class="form-group">
				<p><label for="email_login">E-mail:</label>
					<?php $email_login = isset( $_POST['email_login'] ) ? $_POST['email_login'] : ''; ?>
					<input class="form-control" type="text" name="email_login" id="email_login" value="<?php echo $email_login; ?>" /></p>
			</div>
			<div class="form-group">
				<p class="text-center">
					<input type="hidden" name="action" value="reset" />
					<input type="submit" value="Mật Khẩu Mới" class="btn btn-primary" id="submit" />
				</p>
			</div>
		</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php get_footer(); ?>