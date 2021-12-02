<?php
/*
  Template Name: Result Search
*/  
get_header(); global $wpdb;?>
  <div class="wrap-result-search py-4 py-md-5">
    <div class="container">
      <div class="row">
        <div class="col-md-9 mb-3 mb-md-0">         
          <div class="real-list">
            <?php //if(isset( $_POST['querySearch'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) {
              if (isset($_GET['name_search'])) {
                $name_search = $_GET['name_search'];
              }
              $danh_muc = '';$quan_huyen = ''; $khuvuc = '';$loaibds = '';$area ='';

              if (isset($_GET['danh_muc'])) {
                $danh_muc = $_GET['danh_muc'];              
              }
              if (isset($_GET['quan_huyen'])) {
                $quan_huyen = $_GET['quan_huyen'];              
              }
              if (isset($_GET['phuong_xa'])) {
                $phuong_xa = $_GET['phuong_xa'];              
              }
              if($phuong_xa != ''){
                $khuvuc = $phuong_xa;
              } else {
                $khuvuc = $quan_huyen;
              }
              if ($khuvuc !='' && $khuvuc !=null ) {              
                $khuvuc = array(
                  'taxonomy' => 'khuvucbds',
                  'field'    => 'id',
                  'terms'    => array($khuvuc),
                );
              }
              if (isset($_GET['loaibds'])) {
                $loaibds = $_GET['loaibds'];              
              }
              if ($loaibds !='' && $loaibds !=null ) {              
                $loaibds = array(
                  'taxonomy' => 'loaibds',
                  'field'    => 'slug',
                  'terms'    => $loaibds,
                );
              }
              if (isset($_GET['area'])) {
                $area = $_GET['area'];              
              }
              if ($area !='' && $area !=null ) {              
                $area = array(
                  'taxonomy' => 'area',
                  'field'    => 'slug',
                  'terms'    => $area,
                );
              }
              if (isset($_GET['price-min'])) {
                $priceMin = $_GET['price-min'];              
              }
              if (isset($_GET['price-max'])) {
                $priceMax = $_GET['price-max'];              
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
              'post_type' => 'post', 
              'posts_per_page' => '20',
              'paged'          => $paged,
              'order' => 'ASC',
				      'category'		=> $danh_muc,
              'tax_query' => array(
                'relation' => 'AND',
                array(
                  'relation' => 'OR',
                  $khuvuc,
                  $loaibds,
                  $area,
                )                
              ),  
              'meta_query'    => array(
                'relation'      => 'AND',
                array(
                    'key'       => 'gia_post',
                    'value'     => $priceMin,
                    'type'      => 'NUMERIC',
                    'compare'   => '>='
                ),
                array(
                    'key'       => 'gia_post',
                    'value'     => $priceMax,
                    'type'      => 'NUMERIC',
                    'compare'   => '<='
                ),
              ),
            );
            $timKiem = new WP_Query( $post );
            if($timKiem->have_posts()) {
              echo '<div class="row"><div class="col-12"><h2><span>Có <strong class="red">'.$timKiem->found_posts.'</strong> bất động sản tìm kiếm theo yêu cầu của bạn.</span></h2></div></div>';
              while ( $timKiem->have_posts() ) : $timKiem->the_post();
                $postid = get_the_ID();
                $post_author_id = get_post_field( 'post_author', $postid );   
                $display_name = get_the_author_meta( 'display_name' , $post_author_id );  
                $dientich_post = get_post_meta( $postid, 'dientich_post', true );
                $gia_post = get_post_meta( $postid, 'gia_post', true );
                $address_post = get_post_meta( $postid, 'address_post', true ); 
                $phongtam_post = get_post_meta(get_the_id(),'phongtam_post',true);
                $phongngu_post = get_post_meta(get_the_id(),'phongngu_post',true);  
                $donvi_price_post = get_post_meta( $postid, 'donvi_price_post', true );
                if($donvi_price_post) {
                  $donvi_price_post = '/'.$donvi_price_post;
                }	 
                  echo '<div class="my-3 border-bottom">
                    <div class="row item">
                        <div class="col-5 col-md-4 pr-0"><a href="'.get_the_permalink().'" title="'.get_the_title().'" class="post-media mb-3 d-block">';
                        if ( has_post_thumbnail() ) {
                          echo '<div class="rounded overflow-hidden">'.get_the_post_thumbnail( get_the_id(), 'full', array( 'class' =>'img-fluid d-block mx-auto','alt' => get_the_title(),'loading' => 'lazy')).'</div>';
                        } else {
                          echo"<div class='bg-img img-wrap'><img src='".get_template_directory_uri()."/assets/images/logo.png' alt='".get_bloginfo( 'name' )."' class='img-fluid d-block mx-auto' loading = 'lazy'></div>";
                        }  
                        echo '</a></div>                   
                        <div class="col-7 col-md-8">
                          <a href="'.get_the_permalink().'" title="'.get_the_title().'" class="d-block"><h3 class="mb-3">'.get_the_title().'</h3></a>  
                            <div class="block-att d-flex flex-wrap align-items-center justify-content-between mb-2">';
                              if($gia_post) {
                                echo '<div><span class="listing-price">'.price($gia_post).'</span><span class="text-lowercase">'.$donvi_price_post.'</span></div>';
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
                              echo '</div>
                            </div>
                          <div class="description d-none d-md-block">'.trim_text_to_words(get_the_content(), 350).'</div>
                        </div>   
                      </div>
                  </div>';
              endwhile;
              echo "<div class='paginations text-center my-4'>";
                echo get_pagination($timKiem);
              echo "</div>";
              //Reset Post Data
              wp_reset_postdata();
            } else {
              echo '<h3 class="entry-title">Không có bất động sản nào được tìm thấy</h3>';
            }
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
<?php //echo register_info(); ?>
<?php get_footer();
