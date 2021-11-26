<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<div class="banner">  
  <?php if(function_exists('getSliderBanner')){?>
    <div class="banner-cover">
      <div slider-banner class="h-100">
        <?php echo getSliderBanner(); ?>
      </div>
    <!-- <img class="img-fluid mx-auto d-block" src="<?php echo get_template_directory_uri();?>/assets/images/banner.jpg" alt="<?php echo get_bloginfo( 'name' ); ?>">  -->
  </div>      
  <?php } ?>
  <div class="banner-content d-flex align-items-center">
    <div class="container">
      <div class="search-block">
        <h3 class="text-capitalize mb-4 d-flex flex-wrap align-items-center justify-content-center"><div class="d-inline-block mr-2 icon-search"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/assets/images/icon-search-home.png" class="img-fluid d-inline-block" alt="<?php echo get_bloginfo( 'name' ); ?>"></div>Tìm kiếm Bất Động Sản</h3>  
        <div class="row justify-content-center"><div class="col-md-10 col-lg-8"><?php searchBox(); ?></div></div>
      </div>    
    </div>
  </div>
</div>
<div class="list-category py-4 py-md-5">
  <div class="container">
    <div class="row">
      <div class="col-4 col-md my-2 text-center">
        <a href="<?php bloginfo('url'); ?>/can-ban/can-ban-nha-rieng/" title="Văn Phòng"><div class="icon-cat d-flex align-items-center justify-content-cente mx-auto mb-2"><img alt="Văn Phòng" src="<?php echo get_template_directory_uri();?>/assets/images/icon-home.png" class="img-fluid d-block mx-auto" loading="lazy"></div>
          <div class="text-cat">Văn Phòng</div></a>
      </div>
      <div class="col-4 col-md my-2 text-center">
        <a href="<?php bloginfo('url'); ?>/can-ban/ban-can-ho-chung-cu/" title="Căn hộ / Chung Cư" class="canho"><div class="icon-cat d-flex align-items-center justify-content-center mx-auto mb-2">
            <img alt="Căn Hộ / Chung Cư" src="<?php echo get_template_directory_uri();?>/assets/images/icon-canho.png" class="img-fluid d-block mx-auto" loading="lazy">
          </div>
          <div class="text-cat">Căn Hộ & Chung Cư</div></a>
      </div>
      <div class="col-4 col-md my-2 text-center">
        <a href="<?php bloginfo('url'); ?>/cho-thue/cho-thue-nha-tro-phong-tro/" title="Phòng Cho Thuê" class="khoxuong"><div class="icon-cat d-flex align-items-center justify-content-center mx-auto mb-2">
            <img alt="Phòng Cho Thuê" src="<?php echo get_template_directory_uri();?>/assets/images/icon-ptro.png" class="img-fluid d-block mx-auto" loading="lazy">
          </div>
          <div class="text-cat">Phòng Cho Thuê</div></a>
      </div>
    </div>
  </div>
</div>
<div class="real-estate-special bg-gray py-4">
  <div class="container">
		<div class="text-center mb-5 mt-4">
			<h2 class="title-h2 d-flex flex-wrap align-items-center justify-content-center color-primary"><strong class="text-uppercase">Bất động sản nổi bật</strong></h2>
			<div class="separator position-relative d-inline-block"><i class="fa fa-circle mx-auto"></i></div>
		</div>
    <?php echo bds_noibat('12'); ?>
		<div>
			<a title="Bất động sản nổi bật" href="<?php bloginfo('url');?>/bat-dong-san-noi-bat" class="txt-more text-capitalize">Xem thêm Bất động sản nổi bật<i class="ml-2 fa fa-chevron-right"></i></a>
		</div>
  </div>
</div>

<div class="wrap-canho">
  <div class="container py-4">
    <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Căn hộ chung cư</strong> <a title="Căn hộ chung cư" href="<?php bloginfo('url');?>/loai-bat-dong-san/can-ho-chung-cu/" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
    <div class="block-chungcu">
      <?php echo get_loai_bds('can-ho-chung-cu',12); ?>
    </div>
  </div>
  <div class="bg-gray py-4">
    <div class="container ">
      <div class="row">
        <div class="col-12 col-lg-6">
          <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Nhà mặt phố, shophouse</strong><a title="Nhà mặt phố, shophouse" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/nha-mat-pho" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
          <div class="block-gray">
            <?php echo get_loai_bds('nha-pho-shophouse,nha-mat-pho',6); ?>            
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Nhà riêng</strong><a title="Nhà riêng" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/nha-rieng" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
          <div class="block-gray">
            <?php echo get_loai_bds('nha-rieng',6); ?>                    
          </div>
        </div>
      </div>
    </div>    
  </div>
  <div class="container py-4">
    <div class="row">
      <div class="col-12">
        <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Văn phòng, Nhà cho thuê</strong><a title="Văn phòng, Nhà cho thuê" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/van-phong" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
        <div class="block-gray">
          <?php echo get_loai_bds('van-phong,nha-tro,phong-tro',12); ?>          
        </div>
      </div>      
      <!-- <div class="col-12 col-lg-6">
        <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Condotel, Penthouse, Officetel</strong><a title="Condotel, Penthouse, Officetel" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/can-ho-condotel" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
        <div class="block-gray">
          <?php echo get_loai_bds('can-ho-condotel,can-ho-officetel,can-ho-mini',6); ?>          
        </div>
      </div> -->
    </div>
  </div>
  <div class="bg-gray py-4">
    <div class="container">
      <div class="row">      
        <div class="col-12 col-lg-6">
          <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Biệt thự</strong><a title="Biệt thự" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/biet-thu-lien-ke" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
          <div class="block-gray">
            <?php echo get_loai_bds('biet-thu-don-lap,biet-thu-lien-ke,biet-thu-nghi-duong,biet-thu-song-lap',6); ?>            
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Đất nền</strong><a title="Đất nền" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/dat-nen" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
          <div class="block-gray">
            <?php echo get_loai_bds('dat-nen',6); ?>                  
          </div>
        </div>      
      </div>
    </div>
  </div>
  <div class="container py-4">  
    <div class="row">      
      <div class="col-12 col-lg-6">
        <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Nhà xưởng kho bãi</strong><a title="Nhà xưởng kho bãi" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/nha-xuong-kho-bai" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
        <div class="block-gray">
          <?php echo get_loai_bds('nha-xuong-kho-bai,nha-xuong',6); ?>             
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <h3 class="title-block d-flex flex-wrap align-items-center"><strong class="text-uppercase">Bất động sản khác</strong><a title="Bất động sản khác" href="<?php bloginfo('url'); ?>/loai-bat-dong-san/bat-dong-san-khac" class="view-all ml-auto">Xem tất cả <i class="ml-1 fa fa-plus"></i></a></h3>
        <div class="block-gray">
          <?php echo get_loai_bds('bat-dong-san-khac',6); ?>             
        </div>
      </div>
    </div>   
  </div>
</div>
<div class="news-home py-5 bg-gray">
  <div class="container">
    <h3 class="title-block d-flex flex-wrap align-items-center text-uppercase"><strong>Tin tức mới nhất</strong></h3>
    <div class="desc-mute">
      Tin tức mới nhất, phân tích xu hướng thị trường, cập nhật nhanh chóng và chính xác hàng ngày
    </div>
    <?php if(function_exists('news_home')){ echo news_home(); } ?>
  </div>
</div>
<?php
get_footer();
