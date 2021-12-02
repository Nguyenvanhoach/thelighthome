<?php
/*
Template Name: DangNhap
*/
get_header();
if(!is_user_logged_in()) {
?>
  <main class="main py-4 py-md-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <div class="block-2">
            <h3>Đăng nhập</h3>
            <div class="content-block">
              <!-- <p class="text-center">Đăng nhập sử dụng mạng xã hội</p>
              <ul class="social list-inline">
                <li><a title="facebook" href="<?php echo $login_url_fb ?>">
                  <i class="fa fa-facebook-square"></i>
                  Facebook
                </a></li>
                <li><a href="<?php echo $login_url_gg ?>" title="Google plus">
                  <i class="fa fa-google-plus-square"></i>
                  Google+
                </a></li>
              </ul> -->
              <form name="loginform" id="loginform" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
                <?php
                  $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
                  if ( $login === "failed" ) {  
                    echo '<p class="error text-center">Tên đăng nhập hoặc mật khẩu không đúng !</p>';  
                  } elseif ( $login === "empty" ) {  
                    echo '<p class="error text-center">Tên đăng nhập hoặc mật khẩu không được để trống !</p>';  
                  } elseif ( $login === "false" ) {  
                    echo '<p class="error text-center">Bạn đã đăng xuất !</p>';  
                  }
                  $redirect_to= site_url( $_SERVER['REQUEST_URI']);
                ?>
                <div class="form-group my-3">
                  <input id="user_login" class="form-control py-2" type="text" value="" name="log" placeholder="Tên Đăng Nhập*">
                </div>
                <div class="form-group my-3">
                  <input id="user_pass" type="password" value="" name="pwd" placeholder="Mật khẩu *" class="form-control py-2">
                </div>
                <div class="form-group d-flex justify-content-between my-3">
                  <a href="<?php bloginfo('url'); ?>/dang-ky/" title="Đăng ký tài khoản" style="font-weight: bold;">Đăng ký tài khoản</a>
                  <a href="<?php bloginfo('url'); ?>/lay-lai-mat-khau/" title="Quên mật khẩu?" style="font-weight: bold;">Quên mật khẩu?</a>
                </div>
                <div class="wrap-btn">
                  <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="Đăng nhập">
                  <input type="hidden" value="<?php echo esc_attr( $redirect_to ); ?>" name="redirect_to">
                  <input type="hidden" value="1" name="testcookie">
                </div>
              </form>               

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php } else {
  $current_user = wp_get_current_user();
  $userid = $current_user->ID;
  $user_meta=get_userdata($userid);
	$user_roles=$user_meta->roles[0]; 
  if($user_roles === 'administrator') {
    echo '<script>window.location = "'.get_bloginfo( 'url' ).'/wp-admin"</script>';
  } else {
    echo '<script>window.location = "'.get_bloginfo( 'url' ).'/thong-tin-ca-nhan"</script>';
  }
}
get_footer() ?>
