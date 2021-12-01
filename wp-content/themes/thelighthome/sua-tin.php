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
	$categoryPost=get_the_category( $post_ID );
	$phongtam_post = get_post_meta( $post_ID, 'phongtam_post', true );
	$phongngu_post = get_post_meta( $post_ID, 'phongngu_post', true );
	$huongnha_post = get_post_meta( $post_ID, 'huongnha_post', true );	
	$huongbancong_post = get_post_meta( $post_ID, 'huongbancong_post', true );	
	$sotang_post = get_post_meta( $post_ID, 'sotang_post', true );	
	$donvi_price_post = get_post_meta( $post_ID, 'donvi_price_post', true );
	
	$loai_bds = get_the_terms( $post_ID, 'loaibds' );
	$loaibds = $loai_bds->name;	
	
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
			        if(isset($_FILES["userImage"]["type"])){
						$msg = '';
						$uploaded = FALSE;
						$extensions = array("jpeg", "jpg", "png", "gif"); // file extensions to be checked
						$fileTypes = array("image/png","image/jpg","image/jpeg","image/gif"); // file types to be checked
						$file = $_FILES["userImage"];
						$attachment_id =  my_upload_user_file_from_form($file);	
					}
			  //       $loaitinrao_post = sanitize_text_field($_POST['loaitinrao_post']);
					// $datestart_post = sanitize_text_field($_POST['datestart_post']);
					// $dateend_post = sanitize_text_field($_POST['dateend_post']);
			        $duanchild_bds = sanitize_text_field( $_POST['duan_bds'] ); 

			        $tax_dientich = '';$mucgia='';
			        $post = array(
		            	'ID' => $post_ID,
					    'post_title'    => wp_strip_all_tags($post_title),
					    'post_content'  => $post_content,
					    'post_category' => array(1),
					    'tags_input'    => $post_tags,
					    'post_status'   => $post_Status,
					    'post_type' => 'post',
					    'tax_input' => array(
			                'loaibds' => array($loai_bds),
			                'pricebds' => array ($mucgia),
			                'area' => array($tax_dientich),
			            )
					);					
					$bdsttp_post_id = wp_insert_post($post);
					wp_set_object_terms($bdsttp_post_id,$loai_bds,'loaibds',true);
					wp_set_object_terms($bdsttp_post_id,$mucgia,'pricebds',true);
					wp_set_object_terms($bdsttp_post_id,$tax_dientich,'area',true);
					update_post_meta($bdsttp_post_id,'_thumbnail_id',$attachment_id);
					update_post_meta($bdsttp_post_id,'duongpho_post',$duongpho_post);
					update_post_meta($bdsttp_post_id,'dientich_post',$dientich_post);
					update_post_meta($bdsttp_post_id,'address_post',$address_post);
					update_post_meta($bdsttp_post_id,'phongtam_post',$phongtam_post);
					update_post_meta($bdsttp_post_id,'city_post',$city_post);
					update_post_meta($bdsttp_post_id,'quan_post',$quan_post);
					update_post_meta($bdsttp_post_id,'xa_post',$xa_post);
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
					// update_post_meta($bdsttp_post_id,'loaitinrao_post',$loaitinrao_post);
					// update_post_meta($bdsttp_post_id,'datestart_post',$datestart_post);
					// update_post_meta($bdsttp_post_id,'dateend_post',$dateend_post);
					if(isset($_FILES["gallary-img"]["type"])){
						$files_gallery = $_FILES["gallary-img"];
						upload_imgs_gallerry($files_gallery, $bdsttp_post_id);
					}
				}
			}
		?>
		<main class="main py-4 py-md-5">
			<div class="wrap-content">
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<div class="content-list">
								<h2><?php echo get_the_title();?></h2>
								<form id="new_post" method="post" action="" enctype="multipart/form-data">
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Tiêu đề <span class="color-red">*</span></strong>
										</div>
										<div class="col-sm-10"><input class="form-control" name="post_title" type="text" value="<?php echo get_the_title($post_ID) ;?>" placeholder="Nhập tiêu đề" /></div>
									</div>	
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Thông tin về bất động sản <span class="color-red">*</span></strong>
										</div>
										<div class="col-sm-10">
											<div class="row align-items-sm-center">
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Hình thức <span class="color-red">*</span></label>										
														</div>	
														<div class="col-sm-7">
															<select name="hinhthuc_bds" class="form-control">
																<?php 
																	
																?>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>s</label>	
														</div>	
														<div class="col-sm-7">
															<select name="hinhthuc_cat_sub" class="form-control">	
																<?php
																?>													 			
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Loại bất động sản <span class="color-red">*</span></label>
														</div>	
														<div class="col-sm-7">
															<select name="loai_bds" class="form-control">
																<option value="">Lựa chọn</option>
																<?php $terms = get_terms(array('taxonomy' => 'loaibds','hide_empty' => false,));
																	foreach($terms as $term){ ?>
																	<option value="<?php echo $term->name?>" <?php if($loaibds == $term->name){echo 'selected = "selected"' ;} ?>
																		> <?php echo $term->name ?></option> 
																	<?php }
																	?>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Tỉnh thành phố <span class="color-red">*</span></label>													
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="city_post">
															</select>
														</div>	
													</div>
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Quận huyện <span class="color-red">*</span></label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="quan_post">
																			<?php ?>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Phường xã</label>						
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="xa_post">
																			<?php ?>
															</select>
														</div>	
													</div>	
												</div>	
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Đường phố</label>													
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="duongpho_post" value="<?php echo get_post_meta( $post_ID, 'duongpho_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Diện tích</label>													
														</div>	
														<div class="col-sm-7">														
															<div class="input-group">														    
																	<input value="<?php echo get_post_meta( $post_ID, 'dientich_post', true );?>" type="text" class="form-control" name="dientich_post" placeholder="100" />
																	<span class="input-group-btn style-input-group-2">
																			<button class="btn btn-default" type="button">m²</button>
																	</span>
															</div>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Giá <span class="color-red">*</span></label>												
														</div>	
														<div class="col-sm-7">
															<input value="<?php echo get_post_meta( $post_ID, 'gia_post', true );?>"  type="text" placeholder="vdu: 1 tỷ: 1000000000" class="form-control" name="gia_post" />
														</div>	
													</div>												
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Đơn vị giá</label>												
														</div>	
														<div class="col-sm-7">														
															<select name="donvi_price_post" class="form-control">
																<option value="0" <?php selected( $donvi_price_post, '0' ); ?>>Thỏa thuận</option>
																<option value="1000000" <?php selected( $donvi_price_post, '1000000' ); ?>>Triệu</option>
																<option value="1000000000" <?php selected( $donvi_price_post, '1000000000' ); ?>>Tỷ</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Địa chỉ <span class="color-red">*</span></label>												
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="address_post" value="<?php echo get_post_meta( $post_ID, 'address_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Chọn số phòng tắm</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="phongtam_post">
																<option value="" selected="selected">Chọn số phòng tắm</option>
																<option value="1" <?php selected( $phongtam_post, '1' ); ?>>1 Phòng</option>
																<option value="2" <?php selected( $phongtam_post, '2' ); ?>>2 Phòng</option>
																<option value="3" <?php selected( $phongtam_post, '3' ); ?>>3 Phòng</option>
																<option value="4" <?php selected( $phongtam_post, '4' ); ?>>4 Phòng</option>
																<option value="5" <?php selected( $phongtam_post, '5' ); ?>>5 Phòng</option>
																<option value="6" <?php selected( $phongtam_post, '6' ); ?>>6 Phòng</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Chọn số phòng ngủ</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="phongngu_post">
																<option value="" selected="selected">Chọn số phòng ngủ</option>
																<option value="1" <?php selected( $phongngu_post, '1' ); ?>>1 Phòng</option>
																<option value="2" <?php selected( $phongngu_post, '2' ); ?>>2 Phòng</option>
																<option value="3" <?php selected( $phongngu_post, '3' ); ?>>3 Phòng</option>
																<option value="4" <?php selected( $phongngu_post, '4' ); ?>>4 Phòng</option>
																<option value="5" <?php selected( $phongngu_post, '5' ); ?>>5 Phòng</option>
																<option value="6" <?php selected( $phongngu_post, '6' ); ?>>6 Phòng</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Số tầng</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="sotang_post">
																<option value="" selected="selected">Chọn số tầng</option>
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
															<label>Hướng nhà</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="huongnha_post">
																<option value="Không xác định" <?php selected( $huongnha_post, 'Không xác định' ); ?>>Không xác định</option>
																<option value="Đông" <?php selected( $huongnha_post, 'Đông' ); ?>>Đông</option>
																<option value="Tây" <?php selected( $huongnha_post, 'Tây' ); ?>>Tây</option>
																<option value="Nam" <?php selected( $huongnha_post, 'Nam' ); ?>>Nam</option>
																<option value="Bắc" <?php selected( $huongnha_post, 'Bắc' ); ?>>Bắc</option>
																<option value="Đông-Bắc" <?php selected( $huongnha_post, 'Đông-Bắc' ); ?>>Đông-Bắc</option>
																<option value="Tây-Bắc" <?php selected( $huongnha_post, 'Tây-Bắc' ); ?>>Tây-Bắc</option>
																<option value="Tây-Nam" <?php selected( $huongnha_post, 'Tây-Nam' ); ?>>Tây-Nam</option>
																<option value="Đông-Nam" <?php selected( $huongnha_post, 'Đông-Nam' ); ?>>Đông-Nam</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Hướng ban công</label>												
														</div>	
														<div class="col-sm-7">
															<select class="form-control" name="huongbancong_post">
																<option value="Không xác định" <?php selected( $huongbancong_post, 'Không xác định' ); ?>>Không xác định</option>
																<option value="Đông" <?php selected( $huongbancong_post, 'Đông' ); ?>>Đông</option>
																<option value="Tây" <?php selected( $huongbancong_post, 'Tây' ); ?>>Tây</option>
																<option value="Nam" <?php selected( $huongbancong_post, 'Nam' ); ?>>Nam</option>
																<option value="Bắc" <?php selected( $huongbancong_post, 'Bắc' ); ?>>Bắc</option>
																<option value="Đông-Bắc" <?php selected( $huongbancong_post, 'Đông-Bắc' ); ?>>Đông-Bắc</option>
																<option value="Tây-Bắc" <?php selected( $huongbancong_post, 'Tây-Bắc' ); ?>>Tây-Bắc</option>
																<option value="Tây-Nam" <?php selected( $huongbancong_post, 'Tây-Nam' ); ?>>Tây-Nam</option>
																<option value="Đông-Nam" <?php selected( $huongbancong_post, 'Đông-Nam' ); ?>>Đông-Nam</option>
															</select>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Đường vào (m)</label>												
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="duongvao_post" value="<?php echo get_post_meta( $post_ID, 'duongvao_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Mặt tiền (m)</label>												
														</div>	
														<div class="col-sm-7">
															<input type="text" class="form-control" name="mattien_post" value="<?php echo get_post_meta( $post_ID, 'mattien_post', true );?>" />
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Nội thất</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="noithat_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'noithat_post', true );?></textarea>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Tiện ích kèm theo</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="tienichkemtheo_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'tienichkemtheo_post', true );?></textarea>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Đặc điểm xã hội</label>												
														</div>	
														<div class="col-sm-7">
															<textarea name="dacdiemxahoi_post"  rows="3" cols="5" class="form-control"><?php echo get_post_meta( $post_ID, 'dacdiemxahoi_post', true );?></textarea>
														</div>	
													</div>											
												</div>
												<div class="col-sm-6 my-2">
													<div class="row align-items-sm-center">
														<div class="col-sm-5">
															<label>Pháp lý</label>												
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
											<strong>Thông tin mô tả <span class="color-red">*</span></strong>
										</div>
										<div class="col-12">
											<div class="form-horizontal">
												<?php $post = get_post( $post_ID, OBJECT, 'edit' );$content = $post->post_content;wp_editor( $content, 'userpostcontent', array( 'textarea_name' => 'post_content' ));?>
											</div>
										</div>
									</div>								
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Hình ảnh đại diện bài viết </strong>
										</div>
										<div class="col-12 col-md-10">
											<div class="form-horizontal form-group img-upload">									
									        	<div class="wrap-upload">
									        		<p>(Click để tải ảnh)</p>
									        		<input type="file" name="userImage" id="userImage" class="user-image" />	
									        	</div>		
									        	<div class="img-preview"><div style="background-image: url('<?php echo $feat_image;?>')"></div></div>
										        <div class="upload-msg"></div>
											</div>
										</div>								
									</div>
									<div class="row row-list" id="gallery-metabox">
										<div class="col-12 col-md-2 color-primary">
											<strong>Slider hình ảnh</strong>
										</div>
										<div class="col-md-10">
											<div class="form-horizontal form-group gallery-image">										
									        	<div class="wrap-upload">
									        		<p>Chọn Nhiều Ảnh</p>
									        		<input id="input-gallary" multiple="multiple" type="file" name="gallary-img[]" class="user-image" />	
									        	</div>							            
										        <div class="upload-msg"></div>
										        <ul id="gallery-metabox-list" class="list-inline">
										        	<?php $ids = get_post_meta($post_ID, 'tdc_gallery_id', true);
										        	if($ids){
										        		foreach($ids as $key => $value) {
										        			$image = wp_get_attachment_image_src($value); ?>
												           <li style="background-image:url('<?php echo $image[0]; ?>')"></li>
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
												<input type="text" class="form-control" name="video_post" value="<?php echo get_post_meta( $post_ID, 'video_post', true ); ?>" placeholder="Dán link video Youtube vào đây." />
											</div>
										</div>
									</div>
									<div class="row row-list">
										<div class="col-12 col-md-2 color-primary">
											<strong>Địa Chỉ bản đồ</strong>
										</div>
										<div class="col-12 col-md-10">
											<input type="text" name="bd_post" class="form-control" value="<?php echo get_post_meta( $post_ID, 'bd_post', true ); ?>" placeholder="ví dụ: 35 Nguyễn Huệ, Phường bến nghé, quận 1, TP.Hồ chí minh">
											<p><i>Để tăng độ tin cậy và tin rao được nhiều người quan tâm</i></p>
										</div>
									</div>
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Gắn thẻ tag</strong>
										</div>
										<div class="col-sm-10">
											<div class="form-horizontal">
												<input value="<?php  echo $tagslist ;?>" type="text" name="post_tags" class="form-control" placeholder="Nhập thẻ Tag">
												<div class="pt-5"><i>Tag giúp cho bạn phân loại thêm các chủ để cho tin. Mỗi tag được ngăn cách nhau bằng cách nhấn phím Space từ bàn phím để có khoảng cách giữa 2 Tag với nhau.</i></div>
											</div>
										</div>
									</div>	
									<div class="row row-list">
										<div class="col-sm-2 color-primary">
											<strong>Liên hệ <span class="color-red">*</span></strong>
										</div>
										<div class="col-sm-10">
											<div class="form-horizontal">
												<div class="form-group">
													<div class="col-sm-2">Họ và tên</div>
													<div class="col-sm-10"><input class="form-control" name="tenlienhe_post" type="text" value="<?php echo get_post_meta( $post_ID, 'tenlienhe_post', true ); ?>" /></div>
												</div>
												<div class="form-group">
													<div class="col-sm-2">Số điện thoại</div>
													<div class="col-sm-10"><input name="phone_post" type="text" value="<?php echo get_post_meta( $post_ID, 'phone_post', true ); ?>" class="form-control" /></div>
												</div>
												<div class="form-group">
													<div class="col-sm-2">Email</div>
													<div class="col-sm-10"><input type="email" name="user_email_post" value="<?php echo get_post_meta( $post_ID, 'user_email_post', true ); ?>" class="form-control" /></div>
												</div>
												<div class="form-group">
													<div class="col-sm-2">Địa chỉ</div>
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
												<button class="btn btn-secondary mx-1 px-4" name="reset" type="reset" onclick="history.back();">Hủy Bỏ</button>
												<button class="btn btn-primary mx-1 px-4" type="submit">Sửa Tin</button>
											</div>
										</div>
								  </div>
								</form>
							</div>
						</div>
						<div class="col-md-3">
							<div class="slide-bar"> 
								<div class="block-bar"> 
									<h3>Trang Cá Nhân</h3> 
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
									<h3>Quản Lý Tin đăng</h3>
									<ul class="list-unstyled">
									<li class="<?php if($page_slug==='quan-ly-tin-dang') echo"active"?>">
										<a href="<?php echo bloginfo('url').'/quan-ly-tin-dang'; ?>" title="Quản lý tin đăng">Quản lý tin đăng</a>
									</li>
									<li class="<?php if($page_slug==='dang-tin') echo"active"?>">
										<a href="<?php echo bloginfo('url').'/dang-tin'; ?>" title="Đăng tin">Đăng tin</a>
									</li>
									</ul>
								</div>   
								<div class="block-bar">
									<h3>Quản Lý Thông cá nhân</h3>
									<ul class="list-unstyled">
										<li class="<?php if($page_slug==='thong-tin-ca-nhan') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thong-tin-ca-nhan'; ?>" title="Thông tin cá nhân"><i class="fa fa-user mr-1"></i>Thông tin cá nhân</a>
										</li>
										<li class="<?php if($page_slug==='thay-doi-thong-tin') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thay-doi-thong-tin'; ?>" title="Thay đổi thông tin cá nhân"><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Thay đổi thông tin cá nhân</a>
										</li>
										<li class="<?php if($page_slug==='thay-doi-mat-khau') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/thay-doi-mat-khau'; ?>" title="Thay đổi mật khẩu"><i class="fa fa-refresh mr-1"></i>Thay đổi mật khẩu</a>
										</li>
										<li class="<?php if($page_slug==='dang-xuat') echo"active"?>">
											<a href="<?php echo bloginfo('url').'/dang-xuat'; ?>" title="Đăng Xuất"><i class="fa fa-sign-out mr-1"></i>Đăng Xuất</a>
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


