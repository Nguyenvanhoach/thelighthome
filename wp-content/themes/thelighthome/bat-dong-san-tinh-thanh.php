<?php
/*
  Template Name: BdsTinhThanh
*/  
get_header(); global $wpdb;$matp = addslashes( $_GET['matp'] );$nametp = addslashes( $_GET['nametp'] );
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
    $paged = get_query_var('page');
} else {
    $paged = 1;
}  
?>
  <div class="wrap-result-search my-5">
    <div class="container">
      <div class="row">
        <div class="col-md-9 mb-3 mb-md-0">         
          <div class="real-list">
            <?php if($matp && $nametp) {
              $post_all = array(
                'post_status'   => 'publish',
                'post_type' => 'post', 
                'posts_per_page' => '20',
                'paged'          => $paged,
                'meta_query' => array(
                  array(
                    'key' => 'city_post',
                    'value' =>$matp,
                  ),
                ),
              ); 
              $get_post_city = new WP_Query($post_all);                 
            ?>
            <div class="row mb-4">
              <div class="col-md-8">
                <h2><?php echo $nametp; ?> <span>Có <strong class="red"><?php echo $get_post_city->found_posts; ?></strong> bất động sản.</span></h2>
              </div>
              <div class="col-md-4">
                <div class="d-flex">
                    <div class="send-alert ml-md-auto" data-toggle="modal" data-target="#send-alert-modal">
                      <a href="#" title="Nhận tin bất động sản theo tiêu chí của bạn">
                        <span>Nhận tin bất động sản theo tiêu chí của bạn</span>
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                      </a>
                    </div>                        
                </div>
              </div>
            </div>
            
            <?php
            if($get_post_city->have_posts()) { 
              while ( $get_post_city->have_posts() ) : $get_post_city->the_post();
                $postid = get_the_ID();
                $loaitinrao_post = get_post_meta( $postid, 'loaitinrao_post', true ); 
                $post_author_id = get_post_field( 'post_author', $postid );   
                $display_name = get_the_author_meta( 'display_name' , $post_author_id );  
                $dientich_post = get_post_meta( $postid, 'dientich_post', true );
                $content = get_the_content(); 
                $gia_post = get_post_meta( $postid, 'gia_post', true );
                $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
              $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);  
                // if ($gia_post>=1000000000) {
                //   $gia_post = $gia_post / 1000000000;
                // }
                $donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );
                $show_gia = '';
                if($donvi_price_post<=0) {
                  $show_gia = 'Thỏa thuận';
                }else if($donvi_price_post<=1000000) {
                  $donvi_price_post ='Triệu';
                  $show_gia = $gia_post . $donvi_price_post;
                }else if($donvi_price_post<=1000000000) {
                  $donvi_price_post ='Tỷ';
                  $show_gia = $gia_post . $donvi_price_post;
                }  
                $address_post = get_post_meta( $postid, 'address_post', true ); 
                $sort_loaitin = get_post_meta( $postid, 'sort_loaitin', true );
                
                  if ( has_post_thumbnail() ) {?>
                    <div class="post-vipdb">
                      <div class="row space-1 item">
                        <div class="col-5 col-md-4 pr-0"><a href="<?php echo get_the_permalink() ?>" title="<?php echo  get_the_title() ?>"><div class="post-media mb-3"><div class="img-wrap rounded overflow-hidden"><?php echo get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid','alt' => get_the_title(),'loading' => 'lazy'));?></div></div></a></div>
                        <div class="col-7 col-md-8">
                          <a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>"><h3 class="mb-3"><?php the_title();?></h3></a>  
                          <?php 
                            echo '<div class="block-att d-flex flex-wrap align-items-center justify-content-between mb-2">';
                            if($gia_post) {
                                    echo '<div class="listing-price">'.$gia_post.'</div>';
                                  }
                                  echo '<div class="listing-info d-flex flex-wrap align-items-center">';
                                    if($phongngu_post) {
                                      echo '<div class="mx-1"><i class="fa fa-bed mr-1" aria-hidden="true"></i>'.$phongngu_post.'</div>';
                                    }
                                    if($phongtam_post) {
                                      echo '<div class="mx-1"><i class="fa fa-bath mr-1" aria-hidden="true"></i>'.$phongtam_post.'</div>';
                                    }
                                    if($dientich_post) {
                                      echo '<div class="mx-1"><i class="fa fa-object-group mr-1" aria-hidden="true"></i>'.$dientich_post.'</div>';
                                    }
                            echo '</div>';
                          echo '</div>'; 
                          ?>
                          <div class="description d-none d-md-block"><?php echo trim_text_to_words(get_the_content(), 350); ?></div>              
                        </div>                  
                      </div>
                    </div>
                  <?php } else {?>
                    <div class="post-vipdb">
                      <div class="row space-1 item">
                        <div class="col-xs-5 col-sm-4"><a href="<?php echo get_the_permalink() ?>" title="<?php echo  get_the_title() ?>"><div class="no-img"><span>NO IMAGE</span></div></a></div>
                        <div class="col-sm-8">
                          <a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>">
                            <h3><?php the_title();?></h3>
                            <div class="author hidden">
                              <i class="fa fa-user"></i>
                              <span class="text-uppercase"><?php echo $display_name;?></span>
                              <span class="datetime">
                               <i class="fa fa-clock-o"></i><?php echo get_the_date();?>
                              </span>
                            </div>
                            <div class="description hidden-xs"><?php echo substr(strip_tags($content), 0, 400);?>...</div>
                            <div class="block-bottom">
                              <span class="block-price">Giá:&nbsp;<span><?php echo $show_gia;?></span></span>
                              <span class="dientich">Diện tích:&nbsp;<strong class="color-primary"><?php echo $dientich_post;?> m2</strong></span>
                              <?php if($address_post){?>Địa chỉ:&nbsp;<strong class="color-primary"><?php echo $address_post; ?></strong> <?php }?>
                            </div>  
                            </a>                
                        </div>                  
                      </div>
                    </div>
                <?php }
              endwhile;
              echo "<div class='paginations text-center my-4'>";
                echo get_pagination($get_post_city);
              echo "</div>";
              //Reset Post Data
              wp_reset_postdata();
            } else {
              echo "Không có bất động sản nào được tìm thấy";
            }
          } ?>          
          </div>
        </div>
        <div class="col-md-3">
          <?php get_sidebar(); ?>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<?php echo register_info(); ?>
<?php get_footer();?>
