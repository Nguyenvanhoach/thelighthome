</main>
<footer class="footer pt-5">
  <div class="inner-footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8 text-center text-md-left mb-4 mb-md-0">
          <img loading="lazy" src="<?php echo get_template_directory_uri();?>/assets/images/logo_f.png" class="img-fluid d-block d-md-inline-block mb-3 mx-auto" alt="<?php bloginfo('description'); ?>">
          <h2 class="mb-0">CÔNG TY TNHH SANSA LAND</h2>
        </div>
        <div class="col-md-4 text-left text-md-right">        
          <?php if(function_exists('newsLetter')){ echo newsLetter(); } ?>
        </div>
      </div>
      <div class="line my-4 my-md-5"></div>
      <div class="row mb-2">
        <div class="col-12 col-md-4 mb-4 mb-md-0">
          <h3 class="text-uppercase"><span class="pb-2">Thông tin liên hệ</span></h3>       
          <ul class="address list-unstyled mb-4">
            <?php if(get_option('address_company') !='') {echo'<li class="address-icon">'.get_option('address_company').'</li>';}?>
            <?php if(get_option('phone_company') !='') {echo'<li class="hotline-icon">'.get_option('phone_company').'</li>';}?>
            <?php if(get_option('fax_company') !='') {echo'<li class="fax-icon">'.get_option('fax_company').'</li>';}?>
            <?php if(get_option('mail_company') !='') {echo'<li class="mail-icon">'.get_option('mail_company').'</li>';}?>
            <li class="website-icon">www.sansaland.vn</li>
          </ul>
          
        </div>
        <div class="col-12 col-md-4">
          <h3 class="text-uppercase"><span class="pb-2">Site map</span></h3>
          <div class="row">
            <div class="col-6"> 
                <ul class="list-unstyled list-i">
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/gioi-thieu" title="Giới thiệu">Giới thiệu</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/lien-he" title="Liên hệ">Liên hệ</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/tin-tuc" title="Tin tức & sự kiện">Tin tức & sự kiện</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/du-an/" title="Dự án">Dự án</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/can-ban/" title="Cần bán">Cần bán</a></li>
                 <li ><a href="<?php bloginfo('url'); ?>/cho-thue/" title="Cho thuê">Cho thuê</a></li>
                </ul>
             </div>
             <div class="col-6">
               <ul class="list-unstyled list-i">
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/can-ban/ban-can-ho-chung-cu/" title="Bán căn hộ chung cư">Bán căn hộ chung cư</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/can-ban/ban-dat/" title="Bán đất">Bán đất</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/can-ban/ban-nha-mat-tien/" title="Bán nhà mặt tiền">Bán nhà mặt tiền</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/cho-thue/cho-thue-van-phong/" title="Cho Thuê văn phòng">Cho Thuê văn phòng</a></li>
                 <li class="mb-2"><a href="<?php bloginfo('url'); ?>/cho-thue/cho-thue-nha-tro-phong-tro/" title="Cho Thuê phòng trọ">Cho Thuê phòng trọ</a></li>
                 <li><a href="<?php bloginfo('url'); ?>/cho-thue/cho-thue-can-ho-chung-cu/" title="Cho Thuê Căn hộ chung cư">Cho Thuê Căn hộ</a></li>
                </ul>
             </div>
          </div>         
        </div>
        <div class="col-12 col-md-4 mb-md-0">
          <h3 class="text-uppercase"><span class="pb-2">Theo dõi chúng tôi</span></h3>
            <div class="wrap-fb overflow-hidden">
              <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fchothuecanhoquan2%2F&tabs=timeline&width=340&height=200&small_header=false&adapt_container_width=false&hide_cover=false&show_facepile=true&appId=215651349123280" width="100%" height="200" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
            </div>
        </div>
      </div>
    </div>
    <div class="footer-b py-4 mt-md-4">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-7">Copyright © 2020 SANSALAND. All rights reserved.</div>
          <div class="col-md-5">
            <ul class="nav social justify-content-md-end align-items-center">
              <li class="pr-4 pr-md-2 pr-lg-4">Kết nối với chúng tôi:</li>
                <?php if(get_option('facebook') !='') {echo'<li class="nav-item pr-4 pr-md-2 pr-lg-3"><a target="_blank" href="'.get_option('facebook').'" title="Facebook"><i class="fa fa-facebook-square" aria-hidden="true"></i></i></a></li>';}?>
                <?php if(get_option('twitter') !='') {echo'<li class="nav-item pr-4 pr-md-2 pr-lg-3"><a target="_blank" href="'.get_option('twitter').'" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></i></a></li>';}?>
                <?php if(get_option('linkedin') !='') {echo'<li class="nav-item pr-4 pr-md-2 pr-lg-3"><a target="_blank" href="'.get_option('linkedin').'" title="Linkedin"><i class="fa fa-linkedin-square" aria-hidden="true"></i></i></a></li>';}?>
                <?php if(get_option('pinterest') !='') {echo'<li class="nav-item pr-4 pr-md-2 pr-lg-3"><a target="_blank" href="'.get_option('pinterest').'" title="Pinterest"><i class="fa fa-pinterest-square" aria-hidden="true"></i></i></a></li>';}?>
                <?php if(get_option('youtube') !='') {echo'<li class="nav-item pr-4 pr-md-2 pr-lg-3"><a target="_blank" href="'.get_option('youtube').'" title="Youtube"><i class="fa fa-youtube-square" aria-hidden="true"></i></i></a></li>';}?>
              </ul> 
          </div>
        </div>
      </div>
    </div>      
  </div>
</footer>
<a id="totop" class="totop d-flex align-items-center justify-content-center" href="#" title="To top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
<?php wp_footer(); ?>

<script src="<?php echo get_template_directory_uri();?>/assets/js/script.js"></script>	

<script src='https://www.google.com/recaptcha/api.js' async defer></script>
  
</body>
</html>


