<?php
/*
  Template Name: Result Search
*/  
get_header(); global $wpdb;?>
  <div class="wrap-result-search py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-9">          
          <div class="real-list">
            <?php //if(isset( $_POST['querySearch'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) {
              if (isset($_GET['name_search'])) {
                $name_search = $_GET['name_search'];
              }
              if (isset($_GET['hinhthuc_bds'])) {
                $hinhthuc_bds = $_GET['hinhthuc_bds'];
                $hinhthuc_bdsID = get_cat_ID($hinhthuc_bds);            
              }

              if (isset($_GET['loai_bds'])) {
                $loai_bds = $_GET['loai_bds'];              
              }
              if (isset($_GET['pricebds_post'])) {
                $mucgia = $_GET['pricebds_post'];              
              }
              if (isset($_GET['city_post'])) {
                $city_post = $_GET['city_post'];              
              }
              if (isset($_GET['quan_post'])) {
                $quan_post = $_GET['quan_post'];              
              }
              if (isset($_GET['area_post'])) {
                $area_post = $_GET['area_post'];              
              }
              
              $city_metaVal='';
              $quan_metaVal='';
              $tax_dientich='';
              $tax_loaibds='';$tax_price ='';
              if ($city_post !='' && $city_post !=null ) {              
                $city_metaVal = $city_post;
              }
              if ($quan_post !='' && $quan_post !=null ) {              
                $quan_metaVal = $quan_post;
              }
              if ($area_post !='' && $area_post !=null ) {              
                $tax_dientich = array(
                  'taxonomy' => 'area',
                  'field'    => 'slug',
                  'terms'    => array($area_post),
                );
              }

              if ($loai_bds !='' && $loai_bds !=null ) {              
                $tax_loaibds = array(
                  'taxonomy' => 'loaibds',
                  'field'    => 'slug',
                  'terms'    => array($loai_bds),
                );
              }
              if ($mucgia !='' && $mucgia !=null ) {
                $tax_price = array(
                  'taxonomy' => 'pricebds',
                  'field'    => 'slug',
                  'terms'    => array($mucgia),
                );
              }
              if ( get_query_var('paged') ) {
                  $paged = get_query_var('paged');
              } elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
                  $paged = get_query_var('page');
              } else {
                  $paged = 1;
              }              
            $post = array(
              's' => $name_search,
              'post_status'   => 'publish',
              'category__in' => array($hinhthuc_bdsID),
              'post_type' => 'post', 
              //'posts_per_page' => get_option('posts_per_page'),
              'posts_per_page' => '20',
              'paged'          => $paged,
              // 'meta_key'     => 'sort_loaitin',
              // 'orderby'       =>'meta_value',
              'order' => 'ASC',
              'meta_query' => array(
                'relation' => 'OR',
                array(
                  'key' => 'city_post',
                  'value' => $city_metaVal,
                  'compare' => 'LIKE'
                ),
              ),
              array(
                'relation' => 'OR',
                array(
                  'key' => 'quan_post',
                  'value' => $quan_metaVal,
                  'compare' => 'LIKE'
                )
              ),
              'tax_query' => array(
                'relation' => 'AND',
                array(
                  'relation' => 'AND',
                  $tax_loaibds,
                  $tax_price,
                  $tax_dientich,
                )                
              )                
            );

            $timKiem = new WP_Query( $post );
            //echo "<pre>", var_dump($timKiem), "</pre>";
            ?>
            <div class="row space-1">
              <div class="col-md-8">
                <h2><?php if($hinhthuc_bdsID == 7) {echo "Bán nhà đất:";} elseif($hinhthuc_bdsID == 21){echo "Cho thuê nhà đất:";}?> <span>Có <strong class="red"><?php echo $timKiem->found_posts; ?></strong> bất động sản.</span></h2>
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
            if($timKiem->have_posts()) {
              while ( $timKiem->have_posts() ) : $timKiem->the_post();
                $postid = get_the_ID();
                $post_author_id = get_post_field( 'post_author', $postid );   
                $display_name = get_the_author_meta( 'display_name' , $post_author_id );  
                $dientich_post = get_post_meta( $postid, 'dientich_post', true );
                $gia_post = get_post_meta( $postid, 'gia_post', true );
                $address_post = get_post_meta( $postid, 'address_post', true ); 
                $sort_loaitin = get_post_meta( $postid, 'sort_loaitin', true );
                $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
                $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);  
                
                if ( has_post_thumbnail() ) {?>
                  <div class="post-vipdb my-3 border-bottom">
                    <div class="row item">
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
                echo get_pagination($timKiem);
              echo "</div>";
              //Reset Post Data
              wp_reset_postdata();
            } else {
              echo "Không có bất động sản nào được tìm thấy";
            }

          //}
          ?>          
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
<?php get_footer();
