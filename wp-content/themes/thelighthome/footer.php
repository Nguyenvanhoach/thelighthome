</main>
<footer class="footer pt-4 pt-md-5">
  <div class="inner-footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
          <img loading="lazy" src="<?php echo get_template_directory_uri();?>/assets/images/logo.png" class="img-fluid d-block d-md-inline-block mb-3 mx-auto logo-f" alt="<?php bloginfo('description'); ?>">
          <p class="mw1 mb-0">Phòng Đẹp Dịch Vụ Thông Minh Chuyên cung cấp phòng cho thuê tại Thành phố Hồ Chí Minh</p>
        </div>
        <div class="col-md-6 text-left text-md-right d-flex justify-content-md-end">        
          <div class="wrap-fb overflow-hidden">
            <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo get_option('facebook');?>&tabs=timeline&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=215651349123280" width="340" height="134" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
          </div>
        </div>
      </div>
      <div class="line my-3 my-md-4"></div>
      <div class="row mb-2">
        <div class="col-12 col-md-3 mb-3 mb-md-0">
          <h3 class="text-uppercase"><span class="pb-2">Thông tin liên hệ</span></h3>       
          <ul class="address list-unstyled mb-0 mb-md-4">
            <?php if(get_option('address_company') !='') {echo'<li class="address-icon">'.get_option('address_company').'</li>';}?>
            <?php if(get_option('phone_company') !='') {echo'<li class="hotline-icon">'.get_option('phone_company').'</li>';}?>
            <?php if(get_option('fax_company') !='') {echo'<li class="fax-icon">'.get_option('fax_company').'</li>';}?>
            <?php if(get_option('mail_company') !='') {echo'<li class="mail-icon">'.get_option('mail_company').'</li>';}?>
            <li class="website-icon">www.thelighthome.vn</li>
          </ul>          
        </div>
        <div class="col-12 col-md-3">
          <h3 class="text-uppercase"><span class="pb-2">Site map</span></h3>
          <ul class="list-unstyled list-i">
            <li class="mb-2"><a href="<?php bloginfo('url'); ?>/gioi-thieu" title="Giới thiệu">Giới thiệu</a></li>
            <li class="mb-2"><a href="<?php bloginfo('url'); ?>/lien-he" title="Liên hệ">Liên hệ</a></li>
            <li class="mb-2"><a href="<?php bloginfo('url'); ?>/tin-tuc" title="Tin tức & sự kiện">Tin tức & sự kiện</a></li>
            <li class="mb-2"><a href="<?php bloginfo('url'); ?>/cho-thue/" title="Cho thuê">Cho thuê</a></li>
            <li class="mb-2"><a href="<?php bloginfo('url'); ?>/cho-thue/phong-tro/" title="Cho thuê">Cho thuê phòng trọ</a></li>
            <li class="mb-2"><a href="<?php bloginfo('url'); ?>/cho-thue/van-phong/" title="Cho thuê">Cho thuê văn phòng</a></li>
            <li ><a href="<?php bloginfo('url'); ?>/cho-thue/can-ho-chung-cu/" title="Cho thuê">Cho thuê căn hộ chung cư</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-6 mb-md-0">
          <!-- <h3 class="text-uppercase"><span class="pb-2">Bản đồ</span></h3> -->
          <?php if(get_option('google_map') !='') { echo'<div class="map rounded overflow-hidden">'.get_option('google_map').'</div>';}?>
        </div>
        
      </div>
    </div>
    <div class="footer-b py-4 mt-md-4">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-7">Copyright © 2021 THELIGHTHOME. All rights reserved.</div>
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
<div class="icon-right d-flex flex-row flex-md-column justify-content-between px-3 px-md-0">   
  <?php if(get_option('hotline') !='') {echo'<div class="text-center"><a title="Gọi ngay 24/7" href="tel:'.get_option('hotline').'" class="icon icon-phone support"><span>Gọi ĐT tư vấn ngay</span><i class="fas fa-headphones-alt d-flex align-items-center justify-content-center d-md-none h-100"></i>    </a>
    <div class="txt-act-ftor d-md-none">Gọi ngay</div></div>';}?>  
  <?php if(get_option('facebook') !='') { $shopfb =  str_replace( 'https://www.facebook.com/', '', get_option('facebook') ); echo '<div class="text-center"><a target="_blank" href="https://www.messenger.com/t/'.$shopfb.'" title="Chat ngay qua Messenger" class="icon icon-messenger"><span>Chat ngay qua Messenger</span></a><div class="d-md-none txt-act-ftor">Messenger</div></div>'; } ?>	
  <?php if(get_option('zalo') !='') { echo '<div class="text-center"><a target="_blank" href="'.get_option('zalo').'" title="Chat ngay qua Zalo" class="icon icon-zalo"><span>Chat ngay qua Zalo</span></a><div class="d-md-none txt-act-ftor">Zalo</div></div>'; } ?>		
</div>
<a id="totop" class="totop d-flex align-items-center justify-content-center" href="#" title="To top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
<?php wp_footer(); ?>

<script src="<?php echo get_template_directory_uri();?>/assets/js/script.js"></script>	

<script src='https://www.google.com/recaptcha/api.js' async defer></script> <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
  $(document).ready(function() {
    $wrapRangSlide = $('.wrap-rang-slide');
    if($wrapRangSlide.length) {     
      $price_min = $('.price-min').val();
      $price_max = $('.price-max').val();      
      $( "#slider-range" ).slider({
        range: true,
        min: parseInt($price_min),
        max: parseInt($price_max),
        values: [ parseInt($price_min), parseInt($price_max) ],
        slide: function( event, ui ) {
          // $( "#amount-to").val(ui.values[ 0 ]);
          // $( "#amount-right").val(ui.values[ 1 ]);
          //$( "#amount-to").html($( "#slider-range" ).slider("values", 0 ));
          var price_min = ui.values[0];
          $.ajax({
            url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
            type : 'POST',
            dataType:"html",
            data : {'action' : 'priceMin_action','price_min':price_min},
            success : function (result){
              $("#amount-to").html(result);
            }
          });
          var price_max = ui.values[1];
          $.ajax({
            url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
            type : 'POST',
            dataType:"html",
            data : {'action' : 'priceMax_action','price_max':price_max},
            success : function (result){
              $("#amount-right").html(result);
            }
          });

          // $('.mo-left').html(ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' VNĐ');
          //   $('.mo-right').html(ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' VNĐ');
          $('.price-min').val(ui.values[0]);
          $('.price-max').val(ui.values[1]);
        }
      });
        $( "#amount-to").html($( "#slider-range" ).slider("values", 0 ) + ' đồng');
        var price_max = $( "#slider-range" ).slider("values", 1 );
        $.ajax({
          url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
          type : 'POST',
          dataType:"html",
          data : {'action' : 'priceMax_action','price_max':price_max},
          success : function (result){
            $("#amount-right").html(result);
          }
        });
      $('.price-min').val($( "#slider-range" ).slider("values", 0 ));
      $('.price-max').val($( "#slider-range" ).slider("values", 1 ));
    }
  } );
  </script> 
</body>
</html>


