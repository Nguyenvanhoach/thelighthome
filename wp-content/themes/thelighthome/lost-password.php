<?php 
	/*Template Name: Register Email Template*/
	get_header();	
	global $wpdb; 
?>
<main class="main py-4 py-md-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-6">
				<div class="block-2">
					<h3>Lấy Mật khẩu</h3>
					<div class="content-block">
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
								<p>
									<input type="hidden" name="action" value="reset" />
									<input type="submit" name="btnSubmit" value="Mật Khẩu Mới" class="btn btn-primary" id="submit" />
								</p>
							</div>
						</form>
	<?php 	$error = '';
			$success = '';
	if( isset( $_POST['btnSubmit'] ) && !empty( $_POST['btnSubmit'] )) {
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
			$updatePass = wp_hash_password($random_password);
			$update_user = wp_update_user( array (
					'ID' => $user->ID,
					'user_pass' => $updatePass
				)
			);
			$nameUser =  $user->user_login;
			
			if( $update_user ) {
				$result = array('status' => 0);
				require(get_stylesheet_directory().'/PHPMailer-5.2.16/PHPMailerAutoload.php');

				$mail  = new PHPMailer();
				$body = "";		
				$mail->IsSMTP();
				$mail->CharSet = "UTF-8";
				// $mail->SMTPDebug  = 1;
				$mail->SMTPAuth   = true;
				$mail->Host       = "smtp.gmail.com";
				$mail->SMTPSecure = 'tsl';
				$mail->Port       = 587;
				$mail->Username   = "automails123@gmail.com";
				$mail->Password   = "Khongthequen89";
				$mail->SetFrom('admin@gmail.com');
				$mail->addAddress($email);
				$mail->addCC('automails123@gmail.com');
				$mail->Subject    = "Thay Đổi Mật Khẩu - ".get_bloginfo( 'name' )."";
				$body.="<div style='background-color:#ffffff;color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:13px;margin:0 auto;padding:0'>
				<table align='center' border='0' cellpadding='0' cellspacing='0' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;background-color:#f5f5f5;'>
				<tbody>
				  <tr>
				      <td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-left:40px' bgcolor='#e4e6ea'>

				      </td>
				  </tr>
				  <tr>
				      <td bgcolor='#f5f5f5' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
				          <table border='0' cellpadding='0' cellspacing='0' width='688' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
				              <tbody>
				              <tr>
				                  <td width='360' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding:10px 0 10px 10px'>
				                      <a href='".get_bloginfo( 'url' )."' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
				                          <img src='".get_template_directory_uri()."/assets/images/logo.png' style='border:0;max-width: 100%;height: auto' alt='Bât động sản thanh thủy phát'>
				                      </a>
				                  </td>
				                  <td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
				                      <a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
				                      </a>
				                  </td>
				                  <td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Về Chúng Tôi</a></td>
				                  <td width='30' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'>
				                      <a href='".get_bloginfo( 'url' )."/gioi-thieu/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif' target='_blank'>
				                      </a>
				                  </td>
				                  <td width='90' align='left' style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif'><a href='".get_bloginfo( 'url' )."/lien-he/' style='text-decoration:none;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px;display:inline-block' target='_blank'>Liên Hệ</a></td>
				              </tr>
				              </tbody>
				          </table>
				      </td>
				  </tr>
				  <tr>
				    <td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom: 30px'>
				      <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse:collapse' bgcolor='#ffffff'>
				          <tbody>
				            <tr>
				              <td bgcolor='#105aa6' width='600' height='80' valign='top'>
				                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='height:80px'>
				                  <tbody>
				                    <tr>
				                        <td width='100%' style='font-family:Arial,Helvetica,sans-serif;font-size:24px;color:#ffffff;text-align:center;padding:28px 0px 0px 38px;letter-spacing:-1px;vertical-align:top'>
				                            <span>MẬT KHẨU CỦA BẠN</span>
				                        </td>				                        
				                    </tr>
				                  </tbody>
				                </table>
				              </td>
				            </tr>
				            <tr>
				                <td>
				                    <table border='0' cellpadding='0' cellspacing='0' width='100%' bgcolor='#ffffff'>
				                        <tbody>
				                        <tr>
				                            <td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
				                            <td style='padding:0px 0 22px 0'>
				                                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:15px 0 0 0'>
				                                    <tbody>
				                                    <tr>
				                                        <td style='padding:14px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'><b>Xin Chào ".$nameUser." !</b></td>
				                                    </tr>
				                                    <tr>
				                                        <td style='padding:18px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>Bạn vừa mới bắt đầu yêu cầu đặt lại mật khẩu cho tài khoản của bạn trên website ".get_bloginfo( 'url' ).". Và mật khẩu của bạn đã được hệ thống chúng tôi cung cấp cho bạn với các dãy số tự động:</td>
				                                    </tr>
				                                    <tr>
				                                      <td style='padding:10px 10px 0 24px;text-align:center'><h3 style='font-size:15px;font-weight:bold;color:#105aa6;margin:20px 0 0 0;border-bottom:1px solid #ddd;padding-bottom:30px'><span style='background-color:#f5f5f5;padding:15px 20px;border: 1px solid #105aa6;'>".$updatePass."</span></h3></td>
				                                    </tr>
				                                    
				                                    <tr>
																							<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666;margin-top:30px;'>► Email hỗ trợ: <a href='mailto:".$mail_company."' target='_blank' title='".$mail_company."'> <span style='color:#0388cd'>".$mail_company."</span></a> hoặc</td>
																						</tr>
																						<tr>
																							<td style='padding:3px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'>► Tổng đài Chăm sóc khách hàng: <span style='font-weight:bold'>".$hotline."</span></td>
																						</tr>
																						<tr>
																							<td style='padding:16px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666'><span style='font-weight:bold'>".get_bloginfo( 'name' )."</span> trân trọng cảm ơn và rất hân hạnh được phục vụ Quý khách.</td>
																						</tr>
																						<tr>
																							<td style='padding:12px 10px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#666666;font-style:italic'>*Quý khách vui lòng không trả lời email này*.</td>
																						</tr>
				                                    </tbody>
				                                </table>
				                            </td>
				                            <td style='background-color:#105aa6;width:16px;height:100%;padding:0;margin:0;line-height:0;border:none'></td>
				                        </tr>
				                        </tbody>
				                    </table>
				                </td>
				            </tr>
				            <tr>
				                <td style='background-color:#105aa6;width:100%;height:15px'></td>
				            </tr>
				          </tbody>
				      </table>
				    </td>
				  </tr>
				</tbody>
				</table>
				<table border='0' cellpadding='0' cellspacing='0' width='600' align='center' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;'>
				  <tbody>
				    <tr>
				      <td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;padding-bottom:20px'>
				        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
				          <tbody>
										<tr>
											<td style='margin:0;font-family:Arial,Helvetica,sans-serif;padding:20px 0'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='padding:0;border-spacing:0px;table-layout:fixed;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif'>
													<tbody>
														<tr>
															<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:15px;line-height:20px'><b>CÔNG TY TNHH BẤT ĐỘNG SẢN THỦY PHÁT</b></td>
														</tr>
														<tr>
															<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Địa chỉ giao dịch:</b>&nbsp;34 Trần Văn Ơn, KP. Tây A , P. Đông Hòa, Dĩ An - Bình Dương - Việt Nam</td>
														</tr>
														<tr>
															<td style='padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;color:#333333;font-size:12px;line-height:20px'><b>Hotline:</b> 0933.109.099 | 0943.945.609 - Email: <b>batdongsanttp@gmail.com</b></td>
														</tr>				                   
													</tbody>
												</table>
											</td>
										</tr>
				          </tbody>
				        </table>
				      </td>
				    </tr>
				  </tbody>
				</table>
			</div>";
				$mail->MsgHTML($body);	
				// if  update user return true then lets send user an email containing the new password
			
				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
					$result['msg'] = 'There is an error, please check your input and try again';
					$result['debug'] = $mail->ErrorInfo;
				} else {
					$result['status'] = 1;
					echo '<script> window.alert("Mật khẩu của bạn đã thay đổi. Xin vui lòng kiểm tra Email để lấy lại mật khẩu. Và đăng nhập vào hệ thống của chúng tôi.");
					window.location = "'.get_bloginfo( 'url' ).'/wp-login.php"</script>';
				}
			}
		}
		if( ! empty( $error ) )
			echo '<p class="text-danger"><strong>LỖI:</strong> '. $error .'</p>';
		
	} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>