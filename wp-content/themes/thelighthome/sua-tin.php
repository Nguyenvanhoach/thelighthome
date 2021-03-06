<?php 
	/*Template Name: Edit Tin Template*/
	get_header();	session_start();$page_slug = get_post_field( 'post_name');
	$post_ID = addslashes( $_GET['postid'] );
	$post_tags = wp_get_post_tags($post_ID); 
	$tagsarray = array();
	$post_Status = get_post_status($post_ID);
	foreach ($post_tags as $tag) {
	  $tagsarray[] = $tag->name;
	}
	$tagslist = implode( ', ', $tagsarray );
	$curpost = get_post( $post_ID ); 
	$author = $curpost->post_author;
	$dmuc = get_the_category( $post_ID );
	
	$phongtam_post = get_post_meta( $post_ID, 'phongtam_post', true );
	$phongngu_post = get_post_meta( $post_ID, 'phongngu_post', true );
	$huongnha_post = get_post_meta( $post_ID, 'huongnha_post', true );	
	$huongbancong_post = get_post_meta( $post_ID, 'huongbancong_post', true );	
	$sotang_post = get_post_meta( $post_ID, 'sotang_post', true );	
	$donvi_price_post = get_post_meta( $post_ID, 'donvi_price_post', true );
	
	$loai_bds = get_the_terms($post_ID, 'loaibds');
	$quan_huyen = get_the_terms($post_ID, 'khuvucbds');
	$kv_qh = '';$kv_pxa = '';
	if( $quan_huyen ){
		foreach( $quan_huyen as $qh ){ 
			if( $qh->parent == 0) {
				$kv_qh = $qh->term_id;
			} else {
				$kv_pxa = $qh->term_id;
			}
		}
	}
	$dtich = get_the_terms($post_ID, 'area');
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_ID) );	
	
	$video_post = get_post_meta( $post_ID, 'video_post', true );
	$bd_post = get_post_meta( $post_ID, 'bd_post', true );	
	if(is_user_logged_in()){
		$current_user = wp_get_current_user();
		$user_id = get_current_user_id();
		$full_name_u = $current_user->display_name;
		$avatar = get_user_meta($current_user->ID,'bdsttppic', true);
		$avatar_image =wp_get_attachment_image_src($avatar, 'medium');		
		$user_levels =  $current_user->user_level;
		if($user_levels <= 2) { $status_post = "publish"; } else { $status_post = "publish"; }

		$custom = get_post_custom($post_ID);
		$check_special = isset( $custom['check_special'] ) ? esc_attr( $custom['check_special'][0] ) : '';
		
			if($user_id == $author) {
				if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['edit_post'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) {
					if (isset($_POST['post_title'])) {
							$post_title = sanitize_text_field($_POST['post_title']);
					}
					if (isset($_POST['post_content'])) {
							//$post_content = sanitize_text_field($_POST['post_content']);
							$post_content =  apply_filters('the_content', $_POST['post_content']);
					}
					if (isset($_POST['post_tags'])) {
							$post_tags = sanitize_text_field($_POST['post_tags']);
					}
					if (isset($_POST['duongpho_post'])) {
						$duongpho_post = sanitize_text_field($_POST['duongpho_post']);
					}
					if (isset($_POST['dientich_post'])) {
						$dientich_post = sanitize_text_field($_POST['dientich_post']);
					}
					if (isset($_POST['address_post'])) {
						$address_post = sanitize_text_field($_POST['address_post']);
					}            
					if (isset($_POST['gia_post'])) {
						$gia_post = sanitize_text_field($_POST['gia_post']);
					}
					if (isset($_POST['donvi_price_post'])) {
						$donvi_price_post = sanitize_text_field($_POST['donvi_price_post']);
					}
					if (isset($_POST['tenlienhe_post'])) {
						$tenlienhe_post = sanitize_text_field($_POST['tenlienhe_post']);
					}
					if (isset($_POST['user_address_post'])) {
						$user_address_post = sanitize_text_field($_POST['user_address_post']);
					}
					if (isset($_POST['phone_post'])) {
						$phone_post = sanitize_text_field($_POST['phone_post']);
					}
					if (isset($_POST['user_email_post'])) {
						$user_email_post = sanitize_text_field($_POST['user_email_post']);
					}		            
					if (isset($_POST['duongvao_post'])) {
						$duongvao_post = sanitize_text_field($_POST['duongvao_post']);
					}
					if (isset($_POST['mattien_post'])) {
						$mattien_post = sanitize_text_field($_POST['mattien_post']);
					}
					if (isset($_POST['noithat_post'])) {
						$noithat_post = sanitize_text_field($_POST['noithat_post']);
					}
					if (isset($_POST['tienichkemtheo_post'])) {
						$tienichkemtheo_post = sanitize_text_field($_POST['tienichkemtheo_post']);
					}
					if (isset($_POST['dacdiemxahoi_post'])) {
						$dacdiemxahoi_post = sanitize_text_field($_POST['dacdiemxahoi_post']);
					}
					if (isset($_POST['phaply_post'])) {
						$phaply_post = sanitize_text_field($_POST['phaply_post']);
					}
					if (isset($_POST['phongtam_post'])) {
						$phongtam_post = sanitize_text_field( $_POST['phongtam_post'] );
					}
					if (isset($_POST['huongnha_post'])) {
							$huongnha_post = sanitize_text_field( $_POST['huongnha_post'] );
					}
					if (isset($_POST['sotang_post'])) {
							$sotang_post = sanitize_text_field( $_POST['sotang_post'] );
					}
					if (isset($_POST['phongngu_post'])) {
							$phongngu_post = sanitize_text_field( $_POST['phongngu_post'] );
					}
					if (isset($_POST['huongbancong_post'])) {
							$huongbancong_post = sanitize_text_field( $_POST['huongbancong_post'] );
					}
					if (isset($_POST['loai_bds'])) {
							$loai_bds = sanitize_text_field( $_POST['loai_bds'] );
							// $catechild_htbds = get_cat_ID($loai_bds);
					}
					if (isset($_POST['hinhthuc_bds'])) {
							$hinhthuc_bds = sanitize_text_field( $_POST['hinhthuc_bds'] );
							$hinhthuc_bdsID = get_cat_ID($hinhthuc_bds);
					}
					if (isset($_POST['hinhthuc_cat_sub'])) {
							$hinhthuc_cat_sub = sanitize_text_field( $_POST['hinhthuc_cat_sub'] );
							$hinhthuc_cat_sub_ID =  get_cat_ID($hinhthuc_cat_sub);
					}
					if (isset($_POST['city_post'])) {
							$city_post = sanitize_text_field( $_POST['city_post'] );
					}
					if (isset($_POST['quan_post'])) {
							$quan_post = sanitize_text_field( $_POST['quan_post'] );
					}
					if (isset($_POST['xa_post'])) {
							$xa_post = sanitize_text_field( $_POST['xa_post'] );
					}
					if (isset($_POST['video_post'])) {
						$video_post = sanitize_text_field( $_POST['video_post']);
					}
					if (isset($_POST['bd_post'])) {
							$bd_post = sanitize_text_field($_POST['bd_post']);
					}
					if(isset($_FILES["userImage"]) && ($_FILES["userImage"]["type"]) != '' ) {						
						$msg = '';
						$uploaded = FALSE;
						$extensions = array("jpeg", "jpg", "png", "gif"); // file extensions to be checked
						$fileTypes = array("image/png","image/jpg","image/jpeg","image/gif"); // file types to be checked
						$file = $_FILES["userImage"];
						$attachment_id =  my_upload_user_file_from_form($file);	
					}
					if($_POST["check_special"] == "on") {
						$check_special_checked = "on";
					} else {
						$check_special_checked = "off";
					}
					$danhmuc = sanitize_text_field($_POST['danhmuc']);
					$loaibds = sanitize_text_field($_POST['loaibds']);
					$quan_huyen = sanitize_text_field($_POST['quan_huyen']);
					$phuong_xa = sanitize_text_field($_POST['phuong_xa']);
					$area = sanitize_text_field( $_POST['area'] );
					$post = array(
						'ID' => $post_ID,
						'post_title'    => wp_strip_all_tags($post_title),
						'post_content'  => $post_content,
						'post_category' => array(1,$danhmuc),
						'tags_input'    => $post_tags,
						'post_status'   => $post_Status,
						'post_type' => 'post',
						'tax_input' => array(
							'loaibds' => array($loaibds),
							'area' => array($area),
							'khuvucbds' => array($quan_huyen,$phuong_xa),
						)
					);					
					$bdsttp_post_id = wp_insert_post($post);
					if($bdsttp_post_id) {
						update_post_meta($bdsttp_post_id, "check_special", $check_special_checked);										
						update_post_meta($bdsttp_post_id,'_thumbnail_id',$attachment_id);
						// update_post_meta($bdsttp_post_id,'duongpho_post',$duongpho_post);
						update_post_meta($bdsttp_post_id,'dientich_post',$dientich_post);
						update_post_meta($bdsttp_post_id,'address_post',$address_post);
						update_post_meta($bdsttp_post_id,'phongtam_post',$phongtam_post);
						
						update_post_meta($bdsttp_post_id,'gia_post',$gia_post);
						update_post_meta($bdsttp_post_id,'donvi_price_post',$donvi_price_post);
						update_post_meta($bdsttp_post_id,'tenlienhe_post',$tenlienhe_post);
						update_post_meta($bdsttp_post_id,'user_address_post',$user_address_post);
						update_post_meta($bdsttp_post_id,'phone_post',$phone_post);
						update_post_meta($bdsttp_post_id,'user_email_post',$user_email_post);
						update_post_meta($bdsttp_post_id,'bd_post',$bd_post);
						update_post_meta($bdsttp_post_id,'video_post',$video_post);
						update_post_meta($bdsttp_post_id,'duongvao_post',$duongvao_post);
						update_post_meta($bdsttp_post_id,'mattien_post',$mattien_post);
						update_post_meta($bdsttp_post_id,'noithat_post',$noithat_post);
						update_post_meta($bdsttp_post_id,'tienichkemtheo_post',$tienichkemtheo_post);
						update_post_meta($bdsttp_post_id,'dacdiemxahoi_post',$dacdiemxahoi_post);
						update_post_meta($bdsttp_post_id,'phaply_post',$phaply_post);
						update_post_meta($bdsttp_post_id,'huongnha_post',$huongnha_post);
						update_post_meta($bdsttp_post_id,'sotang_post',$sotang_post);
						update_post_meta($bdsttp_post_id,'phongngu_post',$phongngu_post);
						update_post_meta($bdsttp_post_id,'huongbancong_post',$huongbancong_post);
						
						if(isset($_FILES["gallary-img"]["type"])){
							$files_gallery = $_FILES["gallary-img"];
							upload_imgs_gallerry($files_gallery, $bdsttp_post_id);
						}
						global $wp;  
						$current_url = home_url(add_query_arg(array($_GET), $wp->request));
						echo '<script>window.location = "'.$current_url.'"</script>';exit();

					}
				}
			}
		?>
		<main class="main py-4 py-md-5">
			<div class="wrap-content">
				<div class="container">
					<div class="row">
						<div class="col-md-9 mb-3 mb-md-0">
							<div class="content-list">
								<h2><?php echo get_the_title();?></h2>
								<form id="new_post" method="post" action="" enctype="multipart/form-data">
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Ti??u ????? <span class="color-red">*</span></strong>
										</div>
										<div class="col-sm-10"><input class="form-control" name="post_title" type="text" value="<?php echo get_the_title($post_ID) ;?>" placeholder="Nh???p ti??u ?????" /></div>
									</div>	
									<div class="row row-list">
										<div class="col-12 color-primary mb-3">
											<strong>Th??ng tin v??? b???t ?????ng s???n <span class="color-red">*</span></strong>
										</div>
										<div class="col-12">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" name="check_special" <?php if($check_special == "on"): echo " checked"; endif ?>>
												<label class="form-check-label mb-sm-0 red mr-1 font-weight-bold text-capitalize">Check ch???n hi???n th??? b????t ??????ng sa??n n????i b???t ??? trang ch???</label>
											</div>
										</div>
										<div class="col-12">
											<div class="row align-items-sm-center">
												<div class="col-md-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label class="mb-sm-0">Danh m???c Cho thu??</label>	
														</div>	
														<div class="col-sm-7">
															<select name="danhmuc" class="form-control">
																<option value="">Ch???n danh m???c</option>
																<?php $terms = get_terms(array('taxonomy' => 'category','hide_empty' => false,'parent'   => 1));
																	foreach($terms as $term){
																		echo "<option value='".$term->term_id."'";
																			if($dmuc) {
																				foreach($dmuc as $dm) {
																					if($dm->term_id == $term->term_id){ echo 'selected = "selected"';}
																				}
																			}
																		echo ">".$term->name."</option>";
																	}
																?>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-md-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label class="mb-sm-0">Th??? lo???i</label>	
														</div>	
														<div class="col-sm-7">
															<select name="loaibds" class="form-control">
																<option value="">Ch???n th??? lo???i</option>
																<?php $terms = get_terms(array('taxonomy' => 'loaibds','hide_empty' => false,));
																	foreach($terms as $term){
																		echo"<option value='".$term->term_id."'";
																		if($loai_bds) {
																			foreach($loai_bds as $lbds) {
																				if($lbds->term_id == $term->term_id){ echo 'selected = "selected"';}
																			}
																		}
																		echo ">".$term->name."</option>";
																	}
																?>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-md-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label class="mb-sm-0">Qu???n huy???n</label>
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="quan_huyen">
																<option value="">Ch???n qu???n/huy???n</option>
																<?php 
																	$args_qh = array( 
																		'hide_empty' => 0,
																		'taxonomy' => 'khuvucbds',
																		'orderby' => 'id',
																		'parent' => 0,
																		); 
																	$cates = get_categories( $args_qh ); 
																	foreach ( $cates as $cate ) { 
																		echo '<option value="'.$cate->term_id.'"';
																		if( $kv_qh ){
																				if($kv_qh == $cate->term_id ) {
																					echo 'selected = "selected"';
																			}
																		}
																		echo '>'.$cate->name.'</option>';
																	} 
																?>
															</select>
														</div>												
													</div>											
												</div>
												<div class="col-md-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
														<label class="mb-sm-0">Ph?????ng x??</label>						
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="phuong_xa">
																<option value="">Ch???n X??/Ph?????ng</option>
																	<?php 
																		if( $kv_qh ){
																			$arg_pxa = array( 
																				'hide_empty' => 0,
																				'taxonomy' => 'khuvucbds',
																				'orderby' => 'id',
																				'parent' => $kv_qh,
																				); 
																			$term_pxa = get_categories( $arg_pxa ); 
																			foreach ( $term_pxa as $pxa ) { 
																				echo '<option value="'.$pxa->term_id.'"';
																				if( $kv_pxa ){
																						if($kv_pxa == $pxa->term_id ) {
																							echo 'selected = "selected"';
																					}
																				}
																				echo '>'.$pxa->name.'</option>';
																			} 
																		}
																	?>
															</select>
														</div>													
													</div>											
												</div>
												<div class="col-md-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-3">
															<label class="mb-sm-0">Di???n t??ch</label>													
														</div>	
														<div class="col-sm-9">
															<div class="input-group">														    
																<input value="<?php echo get_post_meta( $post_ID, 'dientich_post', true );?>" type="text" class="form-control" name="dientich_post" placeholder="vdu: 100 m2" />
																<span class="input-group-btn style-input-group-2 ml-1">
																	<select class="form-control" name="area">
																		<option value="">Di???n t??ch</option>
																		<?php $term_area = get_terms(array('taxonomy' => 'area','hide_empty' => false,));
																			foreach($term_area as $term){
																				echo"<option value='".$term->term_id."'";
																				if($dtich) {
																					foreach($dtich as $dt) {
																						if($dt->term_id == $term->term_id){ echo 'selected = "selected"';}
																					}
																				}
																				echo ">".$term->name."</option>";
																			}
																		?>
																	</select>
																</span>
															</div>												
														</div>	
													</div>											
												</div>
												<!-- <div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>???????ng ph???</label>													
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="duongpho_post" value="<?php echo get_post_meta( $post_ID, 'duongpho_post', true );?>" />
														</div>	
													</div>											
												</div> -->
												<div class="col-md-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-3">
															<label class="mb-sm-0">Gi?? <span class="color-red">*</span></label>	
														</div>	
														<div class="col-sm-9">
															<div class="input-group">														    
																<input value="<?php echo get_post_meta( $post_ID, 'gia_post', true );?>"  type="number" placeholder="vdu: 1 t???: 1000000000" class="form-control" name="gia_post" />
																<span class="input-group-btn style-input-group-2 ml-1">
																	<select name="donvi_price_post" class="form-control">																	
																		<option value="Th??ng" <?php selected( $donvi_price_post, 'Th??ng' ); ?> >Th??ng</option>
																		<option value="N??m" <?php selected( $donvi_price_post, 'N??m' ); ?> >N??m</option>
																		<option value="N???n" <?php selected( $donvi_price_post, 'N???n' ); ?> >N???n</option>
																		<option value="C??n" <?php selected( $donvi_price_post, 'C??n' ); ?> >C??n</option>
																	</select>
																</span>
															</div>
														</div>												
													</div>											
												</div>														
												
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>?????a ch??? <span class="color-red">*</span></label>												
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="address_post" value="<?php echo get_post_meta( $post_ID, 'address_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Ch???n s??? ph??ng t???m</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="phongtam_post">
																<option value="" selected="selected">Ch???n s??? ph??ng t???m</option>
																<option value="1" <?php selected( $phongtam_post, '1' ); ?>>1 Ph??ng</option>
																<option value="2" <?php selected( $phongtam_post, '2' ); ?>>2 Ph??ng</option>
																<option value="3" <?php selected( $phongtam_post, '3' ); ?>>3 Ph??ng</option>
																<option value="4" <?php selected( $phongtam_post, '4' ); ?>>4 Ph??ng</option>
																<option value="5" <?php selected( $phongtam_post, '5' ); ?>>5 Ph??ng</option>
																<option value="6" <?php selected( $phongtam_post, '6' ); ?>>6 Ph??ng</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Ch???n s??? ph??ng ng???</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="phongngu_post">
																<option value="" selected="selected">Ch???n s??? ph??ng ng???</option>
																<option value="1" <?php selected( $phongngu_post, '1' ); ?>>1 Ph??ng</option>
																<option value="2" <?php selected( $phongngu_post, '2' ); ?>>2 Ph??ng</option>
																<option value="3" <?php selected( $phongngu_post, '3' ); ?>>3 Ph??ng</option>
																<option value="4" <?php selected( $phongngu_post, '4' ); ?>>4 Ph??ng</option>
																<option value="5" <?php selected( $phongngu_post, '5' ); ?>>5 Ph??ng</option>
																<option value="6" <?php selected( $phongngu_post, '6' ); ?>>6 Ph??ng</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>S??? t???ng</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="sotang_post">
																<option value="" selected="selected">Ch???n s??? t???ng</option>
																<option value="1" <?php selected( $sotang_post, '1' ); ?>>1</option>
																<option value="2" <?php selected( $sotang_post, '2' ); ?>>2</option>
																<option value="3" <?php selected( $sotang_post, '3' ); ?>>3</option>
																<option value="4" <?php selected( $sotang_post, '4' ); ?>>4</option>
																<option value="5" <?php selected( $sotang_post, '5' ); ?>>5</option>
																<option value="6" <?php selected( $sotang_post, '6' ); ?>>6</option>
																<option value="7" <?php selected( $sotang_post, '7' ); ?>>7</option>
																<option value="8" <?php selected( $sotang_post, '8' ); ?>>8</option>
																<option value="9" <?php selected( $sotang_post, '9' ); ?>>9</option>
																<option value="10" <?php selected( $sotang_post, '10' ); ?>>10</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>H?????ng nh??</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="huongnha_post">
																<option value="Kh??ng x??c ?????nh" <?php selected( $huongnha_post, 'Kh??ng x??c ?????nh' ); ?>>Kh??ng x??c ?????nh</option>
																<option value="????ng" <?php selected( $huongnha_post, '????ng' ); ?>>????ng</option>
																<option value="T??y" <?php selected( $huongnha_post, 'T??y' ); ?>>T??y</option>
																<option value="Nam" <?php selected( $huongnha_post, 'Nam' ); ?>>Nam</option>
																<option value="B???c" <?php selected( $huongnha_post, 'B???c' ); ?>>B???c</option>
																<option value="????ng-B???c" <?php selected( $huongnha_post, '????ng-B???c' ); ?>>????ng-B???c</option>
																<option value="T??y-B???c" <?php selected( $huongnha_post, 'T??y-B???c' ); ?>>T??y-B???c</option>
																<option value="T??y-Nam" <?php selected( $huongnha_post, 'T??y-Nam' ); ?>>T??y-Nam</option>
																<option value="????ng-Nam" <?php selected( $huongnha_post, '????ng-Nam' ); ?>>????ng-Nam</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>H?????ng ban c??ng</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="huongbancong_post">
																<option value="Kh??ng x??c ?????nh" <?php selected( $huongbancong_post, 'Kh??ng x??c ?????nh' ); ?>>Kh??ng x??c ?????nh</option>
																<option value="????ng" <?php selected( $huongbancong_post, '????ng' ); ?>>????ng</option>
																<option value="T??y" <?php selected( $huongbancong_post, 'T??y' ); ?>>T??y</option>
																<option value="Nam" <?php selected( $huongbancong_post, 'Nam' ); ?>>Nam</option>
																<option value="B???c" <?php selected( $huongbancong_post, 'B???c' ); ?>>B???c</option>
																<option value="????ng-B???c" <?php selected( $huongbancong_post, '????ng-B???c' ); ?>>????ng-B???c</option>
																<option value="T??y-B???c" <?php selected( $huongbancong_post, 'T??y-B???c' ); ?>>T??y-B???c</option>
																<option value="T??y-Nam" <?php selected( $huongbancong_post, 'T??y-Nam' ); ?>>T??y-Nam</option>
																<option value="????ng-Nam" <?php selected( $huongbancong_post, '????ng-Nam' ); ?>>????ng-Nam</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>???????ng v??o (m)</label>												
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="duongvao_post" value="<?php echo get_post_meta( $post_ID, 'duongvao_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>M???t ti???n (m)</label>												
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="mattien_post" value="<?php echo get_post_meta( $post_ID, 'mattien_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>N???i th???t</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="noithat_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'noithat_post', true );?></textarea>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Ti???n ??ch k??m theo</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="tienichkemtheo_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'tienichkemtheo_post', true );?></textarea>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>?????c ??i???m x?? h???i</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="dacdiemxahoi_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'dacdiemxahoi_post', true );?></textarea>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Ph??p l??</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="phaply_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'phaply_post', true );?></textarea>
														</div>	
													</div>											
												</div>
											</div>
										</div>
									</div>								
									<div class="row row-list">
										<div class="col-12 color-primary mb-1">
											<strong>Th??ng tin m?? t??? <span class="color-red">*</span></strong>
										</div>
										<div class="col-12">
											<div class="form-horizontal">
												<?php $post = get_post( $post_ID, OBJECT, 'edit' );$content = $post->post_content;wp_editor( $content, 'userpostcontent', array( 'textarea_name' => 'post_content' ));?>
											</div>
										</div>
									</div>								
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>H??nh ???nh ?????i di???n b??i vi???t </strong>
										</div>
										<div class="col-12 col-md-10">
											<div class="form-horizontal form-group img-upload">									
									        	<div class="wrap-upload">
									        		<p>(Click ????? t???i ???nh)</p>
									        		<input type="file" name="userImage" id="userImage" class="user-image" />	
									        	</div>		
									        	<div class="img-preview"><div style="background-image: url('<?php echo $feat_image;?>')"></div></div>
										        <div class="upload-msg"></div>
											</div>
										</div>								
									</div>
									<div class="row row-list" id="gallery-metabox">
										<div class="col-12 col-md-2 color-primary">
											<strong>Slider h??nh ???nh</strong>
										</div>
										<div class="col-md-10">
											<div class="form-horizontal form-group gallery-image">										
									        	<div class="wrap-upload">
									        		<p>Ch???n Nhi???u ???nh</p>
									        		<input id="input-gallary" multiple="multiple" type="file" name="gallary-img[]" class="user-image" />	
									        	</div>							            
										        <div class="upload-msg"></div>
										        <ul id="gallery-metabox-list" class="list-inline">
										        	<?php $ids = get_post_meta($post_ID, 'tdc_gallery_id', true);
										        	if($ids){
										        		foreach($ids as $key => $value) {
										        			$image = wp_get_attachment_image_src($value); ?>
												           <li >
																			 <img alt="<?php echo get_bloginfo( 'name' ); ?>" class="image-preview img-fluid" src="<?php echo $image[0]; ?>">
																	</li>
										        		<?php }
										        	} ?>
										        </ul>
											</div>	
										</div>						
									</div>
									<div class="row row-list">
										<div class="col-12 col-md-2 color-primary">
											<strong>Link Video</strong>
										</div>
										<div class="col-12 col-md-10">
											<div class="form-horizontal">
												<input type="text" class="form-control" name="video_post" value="<?php echo get_post_meta( $post_ID, 'video_post', true ); ?>" placeholder="D??n link video Youtube v??o ????y." />
											</div>
										</div>
									</div>
									<div class="row row-list">
										<div class="col-12 col-md-2 color-primary">
											<strong>?????a Ch??? b???n ?????</strong>
										</div>
										<div class="col-12 col-md-10">
											<input type="text" name="bd_post" class="form-control" value="<?php echo get_post_meta( $post_ID, 'bd_post', true ); ?>" placeholder="v?? d???: 35 Nguy???n Hu???, Ph?????ng b???n ngh??, qu???n 1, TP.H??? ch?? minh">
											<p><i>????? t??ng ????? tin c???y v?? tin rao ???????c nhi???u ng?????i quan t??m</i></p>
										</div>
									</div>
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>G???n th??? tag</strong>
										</div>
										<div class="col-sm-10">
											<div class="form-horizontal">
												<input value="<?php  echo $tagslist ;?>" type="text" name="post_tags" class="form-control" placeholder="Nh???p th??? Tag">
												<div class="pt-5"><i>Tag gi??p cho b???n ph??n lo???i th??m c??c ch??? ????? cho tin. M???i tag ???????c ng??n c??ch nhau b???ng c??ch nh???n ph??m Space t??? b??n ph??m ????? c?? kho???ng c??ch gi???a 2 Tag v???i nhau.</i></div>
											</div>
										</div>
									</div>	
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Li??n h??? <span class="color-red">*</span></strong>
										</div>
										<div class="col-sm-10">
											<div class="form-horizontal">
												<div class="form-group">
													<div class="col-sm-2">H??? v?? t??n</div>
													<div class="col-sm-10"><input class="form-control" name="tenlienhe_post" type="text" value="<?php echo get_post_meta( $post_ID, 'tenlienhe_post', true ); ?>" /></div>
												</div>
												<div class="form-group">
													<div class="col-sm-2">S??? ??i???n tho???i</div>
													<div class="col-sm-10"><input name="phone_post" type="text" value="<?php echo get_post_meta( $post_ID, 'phone_post', true ); ?>" class="form-control" /></div>
												</div>
												<div class="form-group">
													<div class="col-sm-2">Email</div>
													<div class="col-sm-10"><input type="email" name="user_email_post" value="<?php echo get_post_meta( $post_ID, 'user_email_post', true ); ?>" class="form-control" /></div>
												</div>
												<div class="form-group">
													<div class="col-sm-2">?????a ch???</div>
													<div class="col-sm-10"><input class="form-control" name="user_address_post" type="text" value="<?php echo get_post_meta( $post_ID, 'user_address_post', true ); ?>" /></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row row-list">
										<div class="col-12">									
											<div class="wrap-btn d-flex justify-content-center">
												<input type="hidden" name="edit_post" value="post" />
													<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
												<input type="hidden" name="add_new_post" value="post" />
												<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
												<button class="btn btn-secondary mx-1 px-4" name="reset" type="reset" onclick="history.back();">H???y B???</button>
												<button class="btn btn-primary mx-1 px-4" type="submit">S???a Tin</button>
											</div>
										</div>
								  </div>
								</form>
							</div>
						</div>
						<div class="col-md-3">
							<div class="slide-bar"> 
								<div class="block-bar"> 
									<h3>Trang C?? Nh??n</h3> 
									<div class="profesional-img text-center">
										<?php if($avatar_image) { ?>
											<img src="<?php echo $avatar_image[0];?>" alt="<?php echo $user_login;?>" class="center-block img-fluid">  
										<?php } else {?>
											<i class="fa fa-user" aria-hidden="true"></i>
										<?php } ?>
									</div>
									<div class="full-name text-center font-weight-bold text-uppercase"><?php echo $current_user->display_name; ?></div>
								</div>                       
								<div class="block-bar">
									<h3>Qu???n L?? Tin ????ng</h3>
									<ul class="list-unstyled">
									<li class="<?php if($page_slug==='quan-ly-tin-dang') echo"active"?>">
										<a href="<?php echo bloginfo('url').'/quan-ly-tin-dang'; ?>" title="Qu???n l?? tin ????ng">Qu???n l?? tin ????ng</a>
									</li>
									<li class="<?php if($page_slug==='dang-tin') echo"active"?>">
										<a href="<?php echo bloginfo('url').'/dang-tin'; ?>" title="????ng tin">????ng tin</a>
									</li>
									</ul>
								</div>   
								<div class="block-bar">
									<h3>Qu???n L?? Th??ng c?? nh??n</h3>
									<ul class="list-unstyled">
										<li class="<?php if($page_slug==='thong-tin-ca-nhan') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thong-tin-ca-nhan'; ?>" title="Th??ng tin c?? nh??n"><i class="fa fa-user mr-1"></i>Th??ng tin c?? nh??n</a>
										</li>
										<li class="<?php if($page_slug==='thay-doi-thong-tin') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thay-doi-thong-tin'; ?>" title="Thay ?????i th??ng tin c?? nh??n"><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Thay ?????i th??ng tin c?? nh??n</a>
										</li>
										<li class="<?php if($page_slug==='thay-doi-mat-khau') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thay-doi-mat-khau'; ?>" title="Thay ?????i m???t kh???u"><i class="fa fa-refresh mr-1"></i>Thay ?????i m???t kh???u</a>
										</li>
										<li class="<?php if($page_slug==='dang-xuat') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/dang-xuat'; ?>" title="????ng Xu???t"><i class="fa fa-sign-out mr-1"></i>????ng Xu???t</a>
										</li>
									</ul>
								</div>    
							</div>
						</div>		
					</div>
				</div>
			</div>
	<?php } else {
		echo '<script>window.location = "'.get_bloginfo( 'url' ).'/dang-nhap/"</script>';
	} 
	get_footer(); ?>
<script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/assets/js/ajax-upload.js"></script>

