<?php
/*
Template Name: Register
*/
get_header(); ?>
<script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php 
  $err = ''; 
  $success = '';
  $errcaptacha = '';   
  global $wpdb;
  if(isset($_POST['dangky'])) {   
    $password = $wpdb->escape(trim($_POST['password']));
    $confirmpassword = $wpdb->escape(trim($_POST['confirmpassword']));
    $email = $wpdb->escape(trim($_POST['email']));
    $username = $wpdb->escape(trim($_POST['name-register']));
    $hovaten = $wpdb->escape(trim($_POST['hovaten']));
    $phone = $wpdb->escape(trim($_POST['phone']));  
    $user_address = $wpdb->escape(trim($_POST['user_address']));  
    $user_website = $wpdb->escape(trim($_POST['user_website']));  
    $account_type =$_POST['account_type']; 
    // if($account_type == 'ca-nhan') {
    //   $role_user = 'mogioicanhan';
    // } else {
    //   $role_user = 'mogioicongty';
    // }
    $role_user = 'subscriber';
    if(isset($_POST['g-recaptcha-response'])){  
      $tut_captcha=$_POST['g-recaptcha-response'];
    } 
    if(!$tut_captcha){
      $errcaptacha = '<div class="text-danger">Bạn chưa xác thực reCAPTCHA!.</div>';
    }  
    $kiemtra=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcKm2cUAAAAAHlgm2Ecw4p0cApB22y7qYKMK4Z5&response=".$tut_captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
    if($kiemtra.success==false) {
      $errcaptacha = 'Bạn đã nhập sai mã Captcha ?';
      exit;
    } 

    if( $email == "" || $password == "" || $confirmpassword == "" || $username == "") {
      $err = 'Vui lòng không bỏ trống những thông tin bắt buộc!';
    } else if ( username_exists($username) ) {
      $err = 'Username đã tồn tại trong hệ thống. Bạn nhập Username khác.';
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $err = 'Địa chỉ Email không hợp lệ!.';
    } else if(email_exists($email) ) {
      $err = 'Địa chỉ Email đã tồn tại!.';
    } else if($password <> $confirmpassword ){
      $err = '2 mật khẩu không giống nhau!.';
    } else if ( 5 > strlen( $password ) ) {
      $err = 'Mật khẩu của bạn phải lớn hơn 6 ký tự.';
    } else {  
      //$profile_pic = empty($_POST['bdsttp_image_id']) ? '' : $_POST['bdsttp_image_id'];      
      $user_id = wp_insert_user( array ('phone' => apply_filters('pre_user_phone', $phone),'user_pass' => apply_filters('pre_user_user_pass', $password),'display_name' => apply_filters('pre_user_display_name ', $hovaten), 'user_login' => apply_filters('pre_user_user_login', $username),'user_address' => apply_filters('pre_user_user_address', $user_address),'user_url' => apply_filters('pre_user_user_url', $user_website), 'user_email' => apply_filters('pre_user_user_email', $email), 'role' => $role_user ) );
      $picture = upload_user_file($_FILES['picture']);
      $upimg = update_user_meta($user_id, 'bdsttppic', $picture); 
      //update_user_meta($user_id, 'bdsttppic', $profile_pic); 
      
      // if($account_type == 'ca-nhan') {
      //   wp_update_user( array ('ID' => $user_id, 'role' => 'mogioicanhan'));
      // } else {
      //   wp_update_user( array ('ID' => $user_id, 'role' => 'mogioicongty'));
      // }    
      wp_update_user( array ('ID' => $user_id, 'role' => $role_user));

      
      
      if($user_id) {
        do_action('user_register', $user_id); 
        echo '<script> window.alert("Chúc Mừng Bạn Đã Đăng Ký Thành Công. Bạn đăng nhập tài khoản đã đăng ký để vào hệ thống của chúng tôi.");
        window.location = "'.get_bloginfo( 'url' ).'/wp-login.php"</script>';
      }
    }
  }
?>    
<main class="main py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-9 col-md-8 col-lg-6 center">
        <div class="block-2">
          <h3>Đăng Ký tài khoản</h3>
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
            <form method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="text" name="name-register" placeholder="Tên đăng nhập (*)" class="form-control">
              </div>
              <div class="form-group">
                <input type="password" name="password" placeholder="Mật khẩu (*)" class="form-control">
              </div>
              <div class="form-group">
                <input type="password" name="confirmpassword" placeholder="Nhập lại mật khẩu (*)" class="form-control">
              </div>
              <div class="form-group">
                <input type="text" name="hovaten" placeholder="Họ và tên" class="form-control">
              </div>
              <div class="form-group">
                <input type="text" name="user_address" placeholder="Địa chỉ" class="form-control">
              </div> 
              <div class="form-group">
                <input type="email" name="email" placeholder="Email (*)" class="form-control">
              </div>
              <div class="form-group">
                <input type="tel" name="phone" placeholder="Điện thoại" class="form-control">
              </div> 
              <div class="form-group">
                <input type="url" name="user_website" placeholder="Website" class="form-control">
              </div> 
              <div class="form-group select-file-img">
                <span class="green">Nhấn chọn ảnh đại diện</span>
                <input class="input-file" accept="image/*" name="picture"  type="file" onchange="loadFile(event)">
                <img id="output_avatar" class="img-fluid" src="" style="width: 100px; height: auto;" />
                <script>
                  var loadFile = function(event) {
                    var output = document.getElementById('output_avatar');
                    output.src = URL.createObjectURL(event.target.files[0]);
                     $('#output_avatar').addClass('active-avatar');
                  };
                </script>
              </div>   
              <!-- <div class="form-group">
                <label class="radio-inline"><input type="radio" name="account_type" value="ca-nhan" checked="checked">Cá nhân</label>
                <label class="radio-inline"><input type="radio" name="account_type" value="cong-ty">Công ty</label>
              </div>                -->
              <div class="form-group g-recaptcha-block d-flex align-items-center justify-content-between">
                <div class="g-recaptcha" data-sitekey="6LcKm2cUAAAAAJgufT8d0xuHWYMo2obawRflQ29N"></div>
                <a class="pull-right" href="<?php bloginfo('url'); ?>/lay-lai-mat-khau" title="Quên mật khẩu?" style="font-weight: bold;">Quên mật khẩu?</a>
              </div>
              <div class="form-group text-danger">
                <?php
                  if(! empty($err) ) :
                    echo ''.$err.'';
                  endif;
                  echo $errcaptacha;
                ?>
              </div>
              <div class="wrap-btn form-group d-flex justify-content-center w-100">
                <button class="btn btn-secondary mx-1 px-4" name='reset' type="reset">Hủy bỏ</button>
                <button class="btn btn-primary mx-1 px-4" type="submit" name="dangky">Đăng ký</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer() ?>