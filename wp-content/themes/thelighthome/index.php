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
      <div class="row justify-content-center"><div class="col-md-10 col-lg-8"><?php searchBox(); ?></div></div>
    </div>
  </div>
</div>
<div class="list-category py-4 py-md-5">
  <div class="container">
    <div class="row">
      <div class="col-4 col-md my-2 text-center">
        <a href="<?php bloginfo('url'); ?>/cho-thue/van-phong/" title="Văn Phòng"><div class="icon-cat d-flex align-items-center justify-content-cente mx-auto mb-2"><img alt="Văn Phòng" src="<?php echo get_template_directory_uri();?>/assets/images/icon-home.png" class="img-fluid d-block mx-auto" loading="lazy"></div>
          <div class="text-cat">Văn Phòng</div></a>
      </div>
      <div class="col-4 col-md my-2 text-center">
        <a href="<?php bloginfo('url'); ?>/cho-thue/can-ho-chung-cu/" title="Căn hộ / Chung Cư" class="canho"><div class="icon-cat d-flex align-items-center justify-content-center mx-auto mb-2">
            <img alt="Căn Hộ / Chung Cư" src="<?php echo get_template_directory_uri();?>/assets/images/icon-canho.png" class="img-fluid d-block mx-auto" loading="lazy">
          </div>
          <div class="text-cat">Căn Hộ & Chung Cư</div></a>
      </div>
      <div class="col-4 col-md my-2 text-center">
        <a href="<?php bloginfo('url'); ?>/cho-thue/phong-tro/" title="Phòng Cho Thuê" class="khoxuong"><div class="icon-cat d-flex align-items-center justify-content-center mx-auto mb-2">
            <img alt="Phòng Cho Thuê" src="<?php echo get_template_directory_uri();?>/assets/images/icon-ptro.png" class="img-fluid d-block mx-auto" loading="lazy">
          </div>
          <div class="text-cat">Phòng Cho Thuê</div></a>
      </div>
    </div>
  </div>
</div>
<div class="real-estate-special bg-gray py-4 py-md-5">
  <div class="container">
		<div class="text-center mb-4">
			<h2 class="title-h2 d-flex flex-wrap align-items-center justify-content-center color-spec"><strong class="text-uppercase">Bất động sản nổi bật</strong></h2>
			<div class="separator position-relative d-inline-block color-spec"><i class="fa fa-circle mx-auto color-spec"></i></div>
		</div>
    <?php echo bds_noibat('12'); ?>		
  </div>
</div>
<div class="container py-4 py-md-5">
  <div class="row">
    <div class="col-md-7 col-lg-8 mb-4 mb-md-0">
      <ul class="nav nav-tabs tabs-bds d-flex flex-nowrap" id="tabs-bds" role="tablist">
        <li class="nav-item">
          <a class="nav-link text-uppercase active" id="tab-bds-news" data-toggle="tab" href="#bds-news" role="tab" aria-controls="bds-news" aria-selected="true">Mới nhất</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" id="tab-phong-tro" data-toggle="tab" href="#phong-tro" role="tab" aria-controls="phong-tro" aria-selected="false">Phòng trọ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" id="tab-can-ho-chungcu" data-toggle="tab" href="#can-ho-chungcu" role="tab" aria-controls="can-ho-chungcu" aria-selected="false">Căn hộ chung cư</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-uppercase" id="tab-van-phong" data-toggle="tab" href="#van-phong" role="tab" aria-controls="van-phong" aria-selected="false">Văn phòng</a>
        </li>
      </ul>
      <div class="tab-content" id="tabs-bdsContent">
        <div class="tab-pane fade show active" id="bds-news" role="tabpanel" aria-labelledby="tab-bds-news">
          <div>
            <?php
              $post = array(
                'post_status'   => 'publish',
                'post_type' => 'post', 
                'posts_per_page' => 5,   
                'tax_query' => array(
                  array(
                      'taxonomy' => 'category',
                      'field' => 'term_id',
                      'terms' => '1',
                  ) )
              );
            
              $getPost = new WP_Query($post );
              if($getPost->have_posts()) {  	
                while ($getPost->have_posts() ) : $getPost->the_post();
                  $postid = get_the_ID();          
                  //$loaitinrao_post = get_post_meta($postid, 'loaitinrao_post', true );
                  $dientich_post = get_post_meta($postid, 'dientich_post', true );
                  $dientich_post = trim($dientich_post);
                  $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
                  $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
                  $gia_post = get_post_meta($postid, 'gia_post', true );
                  $address_post = get_post_meta($postid, 'address_post', true );
                  $donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );
                  if($donvi_price_post) {
                    $donvi_price_post = '/'.$donvi_price_post;
                  }	 
                  echo '<div class="col-12 item-real box-real boxshadow-none my-4 px-4 py-2"><div class="row">';
                    echo '<div class="col-4 col-lg-3 px-0">';
                      echo '<a class="post-media h-100 d-block" href="'.get_the_permalink().'" title="'.get_the_title().'">';
                        if(get_post_thumbnail_id($postid)) {
                          echo '<div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div>';
                        } else {
                          echo"<div class='bg-img img-wrap'><img src='".get_template_directory_uri()."/assets/images/logo.png' alt='".get_bloginfo( 'name' )."' class='img-fluid d-block mx-auto' loading = 'lazy'></div>";
                        }
                      echo '</a>';
                    echo '</div>';                        
                    echo '<div class="col-8 col-lg-9">';
                        echo '<div class="h-100"><a class="d-block" href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize my-1">'. get_the_title() .'</h4></a>';   
                        echo '<div class="block-att">';
                          if($gia_post) {
                            echo '<div class="my-1"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';
                          }
                          echo '<div class="listing-info d-flex flex-wrap align-items-center">';
                          if($phongngu_post) {
                            echo '<div><i class="fa fa-bed mr-1 my-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
                          }
                          if($phongtam_post) {
                            echo '<div><i class="fa fa-bath mr-1 my-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
                          }
                          if($dientich_post) {
                            echo '<div><i class="fa fa-object-group mr-1 my-1" aria-hidden="true"></i>Diện tích: <strong>'.$dientich_post.'</strong></div>';
                          }
                        echo '</div>';
                        echo '<div class="des-mute d-flex flex-nowrap mt-2">';
                          if($address_post) {
                            echo '<i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span>';
                          }				 
                        echo'</div>';
                    echo '</div></div>';
                    echo "</div>";
                  echo "</div></div>";
                endwhile;
                wp_reset_postdata();
                echo '<div class="text-center mt-md-4"><a title="Bất động sản nổi bật" href="'.get_bloginfo('url').'/cho-thue/" class="txt-more px-3 py-2 font-weight-bold d-inline-block">Xem thêm <i class="ml-2 fa fa-chevron-right"></i></a></div>';
              } 
            ?>
          </div>
        </div>
        <div class="tab-pane fade" id="phong-tro" role="tabpanel" aria-labelledby="tab-phong-tro">
          <div>
            <?php
              $post = array(
                'post_status'   => 'publish',
                'post_type' => 'post', 
                'posts_per_page' => 5,   
                'tax_query' => array(
                  array(
                      'taxonomy' => 'category',
                      'field' => 'term_id',
                      'terms' => '9',
                  ) )
              );
            
              $getPost = new WP_Query($post );
              if($getPost->have_posts()) {  	
                while ($getPost->have_posts() ) : $getPost->the_post();
                  $postid = get_the_ID();          
                  //$loaitinrao_post = get_post_meta($postid, 'loaitinrao_post', true );
                  $dientich_post = get_post_meta($postid, 'dientich_post', true );
                  $dientich_post = trim($dientich_post);
                  $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
                  $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
                  $gia_post = get_post_meta($postid, 'gia_post', true );
                  $address_post = get_post_meta($postid, 'address_post', true );
                  echo '<div class="col-12 item-real box-real boxshadow-none my-4 px-4 py-2"><div class="row">';
                    echo '<div class="col-4 col-lg-3 px-0">';
                      echo '<a class="post-media h-100 d-block" href="'.get_the_permalink().'" title="'.get_the_title().'">';
                        if(get_post_thumbnail_id($postid)) {
                          echo '<div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div>';
                        } else {
                          echo"<div class='bg-img img-wrap'><img src='".get_template_directory_uri()."/assets/images/logo.png' alt='".get_bloginfo( 'name' )."' class='img-fluid d-block mx-auto'></div>";
                        }
                      echo '</a>';
                    echo '</div>';                        
                    echo '<div class="col-8 col-lg-9">';
                        echo '<div class="h-100"><a class="d-block" href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize my-1">'. get_the_title() .'</h4></a>';   
                        echo '<div class="block-att">';
                          if($gia_post) {
                            echo '<div class="my-1"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.$gia_post.'</span></div>';
                          }
                          echo '<div class="listing-info d-flex flex-wrap align-items-center">';
                          if($phongngu_post) {
                            echo '<div><i class="fa fa-bed mr-1 my-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
                          }
                          if($phongtam_post) {
                            echo '<div><i class="fa fa-bath mr-1 my-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
                          }
                          if($dientich_post) {
                            echo '<div><i class="fa fa-object-group mr-1 my-1" aria-hidden="true"></i>Diện tích: <strong>'.$dientich_post.'</strong></div>';
                          }
                        echo '</div>';
                        echo '<div class="des-mute d-flex flex-nowrap mt-2">';
                          if($address_post) {
                            echo '<i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span>';
                          }				 
                        echo'</div>';
                    echo '</div></div>';
                    echo "</div>";
                  echo "</div></div>";
                endwhile;
                wp_reset_postdata();
                echo '<div class="text-center mt-md-4"><a title="Phòng trọ" href="'.get_bloginfo('url').'/cho-thue/phong-tro/" class="txt-more px-3 py-2 font-weight-bold d-inline-block">Xem thêm <i class="ml-2 fa fa-chevron-right"></i></a></div>';
              } 
            ?>
          </div>
        </div>
        <div class="tab-pane fade" id="can-ho-chungcu" role="tabpanel" aria-labelledby="tab-can-ho-chungcu">
        <div>
            <?php
              $post = array(
                'post_status'   => 'publish',
                'post_type' => 'post', 
                'posts_per_page' => 5,   
                'tax_query' => array(
                  array(
                      'taxonomy' => 'category',
                      'field' => 'term_id',
                      'terms' => '7',
                  ) )
              );            
              $getPost = new WP_Query($post );
              if($getPost->have_posts()) {  	
                while ($getPost->have_posts() ) : $getPost->the_post();
                  $postid = get_the_ID();          
                  //$loaitinrao_post = get_post_meta($postid, 'loaitinrao_post', true );
                  $dientich_post = get_post_meta($postid, 'dientich_post', true );
                  $dientich_post = trim($dientich_post);
                  $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
                  $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
                  $gia_post = get_post_meta($postid, 'gia_post', true );
                  $address_post = get_post_meta($postid, 'address_post', true );
                  echo '<div class="col-12 item-real box-real boxshadow-none my-4 px-4 py-2"><div class="row">';
                    echo '<div class="col-4 col-lg-3 px-0">';
                      echo '<a class="post-media h-100 d-block" href="'.get_the_permalink().'" title="'.get_the_title().'">';
                        if(get_post_thumbnail_id($postid)) {
                          echo '<div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div>';
                        } else {
                          echo"<div class='bg-img img-wrap'><img src='".get_template_directory_uri()."/assets/images/logo.png' alt='".get_bloginfo( 'name' )."' class='img-fluid d-block mx-auto'></div>";
                        }
                      echo '</a>';
                    echo '</div>';                        
                    echo '<div class="col-8 col-lg-9">';
                        echo '<div class="h-100"><a class="d-block" href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize my-1">'. get_the_title() .'</h4></a>';   
                        echo '<div class="block-att">';
                          if($gia_post) {
                            echo '<div class="my-1"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.$gia_post.'</span></div>';
                          }
                          echo '<div class="listing-info d-flex flex-wrap align-items-center">';
                          if($phongngu_post) {
                            echo '<div><i class="fa fa-bed mr-1 my-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
                          }
                          if($phongtam_post) {
                            echo '<div><i class="fa fa-bath mr-1 my-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
                          }
                          if($dientich_post) {
                            echo '<div><i class="fa fa-object-group mr-1 my-1" aria-hidden="true"></i>Diện tích: <strong>'.$dientich_post.'</strong></div>';
                          }
                        echo '</div>';
                        echo '<div class="des-mute d-flex flex-nowrap mt-2">';
                          if($address_post) {
                            echo '<i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span>';
                          }				 
                        echo'</div>';
                    echo '</div></div>';
                    echo "</div>";
                  echo "</div></div>";
                endwhile;
                wp_reset_postdata();
                echo '<div class="text-center mt-md-4"><a title="Căn hộ chung cư" href="'.get_bloginfo('url').'/cho-thue/can-ho-chung-cu/" class="txt-more px-3 py-2 font-weight-bold d-inline-block">Xem thêm <i class="ml-2 fa fa-chevron-right"></i></a></div>';
              } 
            ?>
          </div>
        </div>
        <div class="tab-pane fade" id="van-phong" role="tabpanel" aria-labelledby="tab-van-phong">
        <div>
            <?php
              $post = array(
                'post_status'   => 'publish',
                'post_type' => 'post', 
                'posts_per_page' => 5,   
                'tax_query' => array(
                  array(
                      'taxonomy' => 'category',
                      'field' => 'term_id',
                      'terms' => '8',
                  ) )
              );
            
              $getPost = new WP_Query($post );
              if($getPost->have_posts()) {  	
                while ($getPost->have_posts() ) : $getPost->the_post();
                  $postid = get_the_ID();          
                  //$loaitinrao_post = get_post_meta($postid, 'loaitinrao_post', true );
                  $dientich_post = get_post_meta($postid, 'dientich_post', true );
                  $dientich_post = trim($dientich_post);
                  $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
                  $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);
                  $gia_post = get_post_meta($postid, 'gia_post', true );
                  $address_post = get_post_meta($postid, 'address_post', true );
                  echo '<div class="col-12 item-real box-real boxshadow-none my-4 px-4 py-2"><div class="row">';
                    echo '<div class="col-4 col-lg-3 px-0">';
                      echo '<a class="post-media h-100 d-block" href="'.get_the_permalink().'" title="'.get_the_title().'">';
                        if(get_post_thumbnail_id($postid)) {
                          echo '<div class="img-wrap">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div>';
                        } else {
                          echo"<div class='bg-img img-wrap'><img src='".get_template_directory_uri()."/assets/images/logo.png' alt='".get_bloginfo( 'name' )."' class='img-fluid d-block mx-auto'></div>";
                        }
                      echo '</a>';
                    echo '</div>';                        
                    echo '<div class="col-8 col-lg-9">';
                        echo '<div class="h-100"><a class="d-block" href="' . get_the_permalink() .'"  title="' . get_the_title() .'"><h4 class="text-capitalize my-1">'. get_the_title() .'</h4></a>';   
                        echo '<div class="block-att">';
                          if($gia_post) {
                            echo '<div class="my-1"><i class="fa fa-usd"></i> Giá: <span class="listing-price">'.$gia_post.'</span></div>';
                          }
                          echo '<div class="listing-info d-flex flex-wrap align-items-center">';
                          if($phongngu_post) {
                            echo '<div><i class="fa fa-bed mr-1 my-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
                          }
                          if($phongtam_post) {
                            echo '<div><i class="fa fa-bath mr-1 my-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
                          }
                          if($dientich_post) {
                            echo '<div><i class="fa fa-object-group mr-1 my-1" aria-hidden="true"></i>Diện tích: <strong>'.$dientich_post.'</strong></div>';
                          }
                        echo '</div>';
                        echo '<div class="des-mute d-flex flex-nowrap mt-2">';
                          if($address_post) {
                            echo '<i class="fa fa-map-marker mr-1" aria-hidden="true"></i><span class="text-capitalize">'.$address_post.'</span>';
                          }				 
                        echo'</div>';
                    echo '</div></div>';
                    echo "</div>";
                  echo "</div></div>";
                endwhile;
                wp_reset_postdata();
                echo '<div class="text-center mt-md-4"><a title="Văn Phòng" href="'.get_bloginfo('url').'/cho-thue/van-phong/" class="txt-more px-3 py-2 font-weight-bold d-inline-block">Xem thêm <i class="ml-2 fa fa-chevron-right"></i></a></div>';
              } 
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5 col-lg-4">
      <div class="sidebar">
        <h3 class="font-weight-normal text-uppercase">
        <span><i class="fa fa-bars"></i> Tin tức mới</span>
        </h3>
        <div>
          <?php if(function_exists('news_home')){ echo news_home(); } ?>        
        </div>
      </div>
    </div>
  </div>
</div>


<div class="khuvuc py-4 py-md-5 bg-gray">
  <div class="container">
    <h3 class="title-block d-flex flex-wrap align-items-center text-uppercase"><strong>Bất động sản theo địa điểm</strong></h3>
    <div class="row space-m">
      <?php
        $terms = get_terms(array('taxonomy' => 'khuvucbds','hide_empty' => false,'orderby' => 'id','order' => 'ASC','parent'   => 0));   
        $stt = 1;
        $loop1 = '';
        $loop2 = '<div class="col-12 col-md-6"><div class="row space-m">';
        $loop3 = '';
        foreach($terms as $term){
          
          $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true );
          $img_url = wp_get_attachment_image_src($image_id, 'full')[0];
          if($stt == 1) {
            $loop1 .= '<div class="col-12 col-md-6 my-2 my-md-3">
            <a href="'.get_term_link($term->slug, 'khuvucbds').'" title="'.$term->name.'" class="d-block position-relative rounded overflow-hidden h-100">
              <div class="img-wrap h-100"><img src="'.$img_url.'" class="img-fluid d-block mx-auto wp-post-image" alt="'.$term->name.'" loading="lazy"></div>
              <div class="content position-absolute text-white d-flex align-items-center justify-content-center text-center">
                <div>
                  <h5 class="font-weight-bold text-capitalize">'.$term->name.'</h5>
                  <div><strong>'.$term->count.'</strong> Bất động sản tại '.$term->name.'</div>
                </div>
              </div>
            </a>
          </div>';
          } else if($stt == 2 || $stt == 3 || $stt == 4 || $stt == 5) {
            $loop2 .='<div class="col-6 my-2 my-md-3">
              <a href="'.get_term_link($term->slug, 'khuvucbds').'" title="'.$term->name.'" class="d-block position-relative rounded overflow-hidden">
                <div class="img-wrap"><img src="'.$img_url.'" class="img-fluid d-block mx-auto wp-post-image" alt="'.$term->name.'" loading="lazy"></div>
                <div class="content position-absolute text-white d-flex align-items-center justify-content-center text-center">
                  <div>
                    <h5 class="font-weight-bold text-capitalize">'.$term->name.'</h5>
                    <div><strong>'.$term->count.'</strong> Bất động sản tại '.$term->name.'</div>
                  </div>
                </div>
              </a>
            </div>';
          } else {
            $loop3 .= '<div class="col-6 col-md-3 my-2 my-md-3">
            <a href="'.get_term_link($term->slug, 'khuvucbds').'" title="'.$term->name.'" class="d-block position-relative rounded overflow-hidden">
              <div class="img-wrap"><img src="'.$img_url.'" class="img-fluid d-block mx-auto wp-post-image" alt="'.$term->name.'" loading="lazy"></div>
              <div class="content position-absolute text-white d-flex align-items-center justify-content-center text-center">
                <div>
                  <h5 class="font-weight-bold text-capitalize">'.$term->name.'</h5>
                  <div><strong>'.$term->count.'</strong> Bất động sản tại '.$term->name.'</div>
                </div>
              </div>
            </a>
          </div>';
          }
          $stt ++;
        }
        echo $loop1;
        $loop2 .= '</div></div>';
        echo $loop2;
        echo $loop3;
      ?>
    </div>    
  </div>
</div>
<?php
get_footer();
