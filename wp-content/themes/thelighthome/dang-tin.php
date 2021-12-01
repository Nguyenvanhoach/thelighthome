<?php 
	/*Template Name: Đăng Tin Template*/
	get_header();
	session_start();	
	$page_slug = get_post_field( 'post_name');	
	?>
	<main class="main py-4 py-md-5">
		<div class="wrap-content">
			<div class="container">
				<div class="row">
					<?php if(is_user_logged_in()){
						$current_user = wp_get_current_user();
						// $user_login = $current_user->user_login;
						$full_name_u = $current_user->display_name;
						$avatar = get_user_meta($current_user->ID,'bdsttppic', true);
						$avatar_image =wp_get_attachment_image_src($avatar, 'medium');	
						$user_id = get_current_user_id();
						$user_levels =  $current_user->user_level;
						if($user_levels <= 2) { $status_post = "publish"; } else { $status_post = "publish"; } 		
					?>	
					<div class="col-md-9">
						<div class="content-list">
							<h2><?php echo get_the_title();?></h2>
							<form id="new_post" method="post" action="" enctype="multipart/form-data">
								<div class="row row-list mb-3">
									<div class="col-md-2 color-primary">
										<strong>Tiêu đề <span class="color-red">*</span></strong>
									</div>
									<div class="col-md-10"><input class="form-control" name="post_title" type="text" placeholder="Nhập tiêu đề" /></div>
								</div>	
								<div class="row row-list mb-2">
									<div class="col-12 color-primary">
										<strong>Thông tin về bất động sản <span class="color-red">*</span></strong>
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5">
												<label class="mb-sm-0">Danh mục Cho thuê</label>	
											</div>	
											<div class="col-sm-7">
												<select name="danhmuc" class="form-control">
													<option value="">Chọn danh mục</option>
													<?php $terms = get_terms(array('taxonomy' => 'category','hide_empty' => false,'parent'   => 1));
														foreach($terms as $term){
															echo"<option value='".$term->slug."'>".$term->name."</option>";
														}
													?>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5">
												<label class="mb-sm-0">Thể loại</label>	
											</div>	
											<div class="col-sm-7">
												<select name="loaibds" class="form-control">
													<option value="">Chọn thể loại</option>
													<?php $terms = get_terms(array('taxonomy' => 'loaibds','hide_empty' => false,));
														foreach($terms as $term){
															echo"<option value='".$term->slug."'>".$term->name."</option>";
														}
													?>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5">
												<label class="mb-sm-0">Quận huyện</label>
											</div>	
											<div class="col-sm-7">
												<select class="form-control" name="quan_huyen">
													<option value="">Chọn quận/huyện</option>
													<?php 
														$args_qh = array( 
															'hide_empty' => 0,
															'taxonomy' => 'khuvucbds',
															'orderby' => 'id',
															'parent' => 0,
															); 
														$cates = get_categories( $args_qh ); 
														foreach ( $cates as $cate ) {  
															echo '<option value="'.$cate->term_id.'">'.$cate->name.'</option>';
														} 
													?>
												</select>
											</div>												
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5">
											<label class="mb-sm-0">Phường xã</label>						
											</div>	
											<div class="col-sm-7">
												<select class="form-control" name="phuong_xa">
													<option value="">Chọn Xã/Phường</option>
												</select>
											</div>													
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-3">
												<label class="mb-sm-0">Diện tích</label>													
											</div>	
											<div class="col-sm-9">
												<div class="input-group">														    
													<input type="text" class="form-control" name="dientich_post" placeholder="vdu: 100 m2" />
													<span class="input-group-btn style-input-group-2 ml-1">
														<select class="form-control" name="area">
															<option value="">Diện tích</option>
															<?php showTaxomi('area');?>
														</select>
													</span>
												</div>												
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-3">
												<label class="mb-sm-0">Giá <span class="color-red">*</span></label>	
											</div>	
											<div class="col-sm-9">
												<div class="input-group">														    
													<input type="number" class="form-control" name="gia_post" placeholder="vdu: 1000000" />
													<span class="input-group-btn style-input-group-2 ml-1">
														<select name="donvi_price_post" class="form-control">																	
															<option value="Tháng">Tháng</option>
															<option value="Năm">Năm</option>
															<option value="Nền">Nền</option>
															<option value="Căn">Căn</option>
														</select>
													</span>
												</div>
											</div>												
										</div>											
									</div>									
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Địa chỉ <span class="color-red">*</span></label></div>	
											<div class="col-sm-7">
												<input type="text" class="form-control" name="address_post" placeholder="Nhập địa chỉ" />
											</div>	
										</div>
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Chọn số phòng tắm</label></div>	
											<div class="col-sm-7">
												<select class="form-control" name="phongtam_post">
													<option value="">Chọn số phòng tắm</option>
													<option value="1">1 Phòng</option>
													<option value="2">2 Phòng</option>
													<option value="3">3 Phòng</option>
													<option value="4">4 Phòng</option>
													<option value="5">5 Phòng</option>
													<option value="6">6 Phòng</option>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Chọn số phòng ngủ</label></div>	
											<div class="col-sm-7">
												<select class="form-control" name="phongngu_post">
													<option value="">Chọn số phòng ngủ</option>
													<option value="1">1 Phòng</option>
													<option value="2">2 Phòng</option>
													<option value="3">3 Phòng</option>
													<option value="4">4 Phòng</option>
													<option value="5">5 Phòng</option>
													<option value="6">6 Phòng</option>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Số tầng</label></div>	
											<div class="col-sm-7">
												<select class="form-control" name="sotang_post">
													<option value="">Chọn số tầng</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">>10</option>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Hướng nhà</label></div>	
											<div class="col-sm-7">
												<select class="form-control" name="huongnha_post">
													<option value="Không xác định">Không xác định</option>
													<option value="Đông">Đông</option>
													<option value="Tây">Tây</option>
													<option value="Nam">Nam</option>
													<option value="Bắc">Bắc</option>
													<option value="Đông-Bắc">Đông-Bắc</option>
													<option value="Tây-Bắc">Tây-Bắc</option>
													<option value="Tây-Nam">Tây-Nam</option>
													<option value="Đông-Nam">Đông-Nam</option>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Hướng ban công</label></div>	
											<div class="col-sm-7">
												<select class="form-control" name="huongbancong_post">
													<option value="Không xác định">Không xác định</option>
													<option value="Đông">Đông</option>
													<option value="Tây">Tây</option>
													<option value="Nam">Nam</option>
													<option value="Bắc">Bắc</option>
													<option value="Đông-Bắc">Đông-Bắc</option>
													<option value="Tây-Bắc">Tây-Bắc</option>
													<option value="Tây-Nam">Tây-Nam</option>
													<option value="Đông-Nam">Đông-Nam</option>
												</select>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Đường vào (m)</label></div>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="duongvao_post" />
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Mặt tiền (m)</label></div>	
											<div class="col-sm-7">
												<input type="text" class="form-control" name="mattien_post" />
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Nội thất</label></div>	
											<div class="col-sm-7">
												<textarea name="noithat_post"  rows="3" cols="5" class="form-control"></textarea>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Tiện ích kèm theo</label></div>	
											<div class="col-sm-7">
												<textarea name="tienichkemtheo_post"  rows="3" cols="5" class="form-control"></textarea>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Đặc điểm xã hội</label></div>	
											<div class="col-sm-7">
												<textarea name="dacdiemxahoi_post"  rows="3" cols="5" class="form-control"></textarea>
											</div>	
										</div>											
									</div>
									<div class="col-md-6 my-2">
										<div class="row align-items-sm-center">
											<div class="col-sm-5"><label class="mb-sm-0">Pháp lý</label></div>	
											<div class="col-sm-7">
												<select class="form-control" name="phaply_post">
													<option value="">Chọn pháp lý</option>
													<option value="Sổ Hồng Riêng">Sổ Hồng Riêng</option>
													<option value="Sổ Riêng">Sổ Riêng</option>
													<option value="Sổ Chung">Sổ Chung</option>
													<option value="Đồng Sở Hữu">Đồng Sở Hữu</option>
													<option value="Pháp Lý Rõ Ràng">Pháp Lý Rõ Ràng</option>
												</select>
											</div>	
										</div>											
									</div>
								</div>
								<div class="row row-list my-2 mt-3">
									<div class="col-12 color-primary mb-2"><strong>Thông tin mô tả <span class="color-red">*</span></strong></div>
									<div class="col-12">
										<div class="form-horizontal">
											<?php $post_obj = $wp_query->get_queried_object(); wp_editor( $post_obj->post_content, 'userpostcontent', array( 'textarea_name' => 'post_content' ));?>
										</div>
									</div>
								</div>								
								<div class="row row-list">
									<div class="col-md-2 color-primary"><strong>Hình ảnh đại diện bài viết </strong></div>
									<div class="col-md-10">
										<div class="form-horizontal form-group img-upload">
											<div class="wrap-upload">
													<p>(Click để tải ảnh)</p>
													<input type="file" name="userImage" id="userImage" class="user-image" required />	
													<!-- required -->
												</div>		
												<div class="img-preview"></div>					            
												<div class="upload-msg"></div>
										</div>
									</div>
								</div>
								<div class="row row-list" id="gallery-metabox">
									<div class="col-md-2 color-primary"><strong>Slider hình ảnh</strong></div>
									<div class="col-md-10">
										<div class="form-horizontal form-group gallery-image">	
											<div class="wrap-upload">
												<p>Chọn Nhiều Ảnh</p>
												<input id="input-gallary" multiple="multiple" type="file" name="gallary-img[]" class="user-image" />	
											</div>							            
											<div class="upload-msg"></div>
											<ul id="gallery-metabox-list" class="list-inline"></ul>
										</div>	
									</div>						
								</div>
								<div class="row row-list">
									<div class="col-md-2 color-primary"><strong>Link Video</strong></div>
									<div class="col-md-10">
										<div class="form-horizontal">
											<input type="text" class="form-control" name="video_post" placeholder="Dán link video youtube vào đây." />
										</div>
									</div>
								</div>
								<div class="row row-list">
									<div class="col-md-2 color-primary"><strong>Địa Chỉ bản đồ</strong></div>
									<div class="col-md-10">
										<input type="text" name="bd_post" class="form-control" placeholder="ví dụ: 35 Nguyễn Huệ, Phường bến nghé, quận 1, TP.Hồ chí minh">
										<div><i>Để tăng độ tin cậy và tin rao được nhiều người quan tâm</i></div>
									</div>
								</div>
								<div class="row row-list">
									<div class="col-md-2 color-primary"><strong>Gắn thẻ tag</strong></div>
									<div class="col-md-10">
										<div class="form-horizontal">
											<input type="text" name="post_tags" class="form-control" placeholder="Nhập thẻ Tag">
											<div class="pt-1"><i>Tag giúp cho bạn phân loại thêm các chủ để cho tin. Mỗi tag được ngăn cách nhau bằng cách nhấn phím Space từ bàn phím để có khoảng cách giữa 2 Tag với nhau.</i></div>
										</div>
									</div>
								</div>	
								<div class="row row-list">
									<div class="col-md-2 color-primary"><strong>Liên hệ <span class="color-red">*</span></strong></div>
									<div class="col-md-10">
										<div class="form-group row">
											<div class="col-sm-2">Họ và tên</div>
											<div class="col-sm-10"><input class="form-control" name="tenlienhe_post" type="text" value="<?php the_author_meta( 'display_name', $current_user->ID ); ?>" /></div>
										</div>
										<div class="form-group row">
											<div class="col-sm-2">Số điện thoại</div>
											<div class="col-sm-10"><input name="phone_post" type="tel" value="<?php the_author_meta( 'phone', $current_user->ID ); ?>" class="form-control" /></div>
										</div>
										<div class="form-group row">
											<div class="col-sm-2">Email</div>
											<div class="col-sm-10"><input type="email" name="user_email_post" value="<?php the_author_meta( 'user_email_post', $current_user->ID ); ?>" class="form-control" /></div>
										</div>
										<div class="form-group row">
											<div class="col-sm-2">Địa chỉ</div>
											<div class="col-sm-10"><input class="form-control" name="user_address_post" type="text" value="<?php the_author_meta( 'user_address', $current_user->ID ); ?>" /></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">									
										<div class="wrap-btn d-flex justify-content-center">
											<input type="hidden" name="add_new_post" value="post" />
											<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
											<button class="btn btn-secondary mx-1 px-4" name="reset" type="reset">Hủy Bỏ</button>
											<button class="btn btn-primary mx-1 px-4" type="submit">Đăng Tin</button>
										</div>
									</div>
								</div>
							</form>
							<?php if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['add_new_post'] ) &&  isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) { //current_user_can('level_0') &&
								
								// if(isset($_FILES["gallary-img"]["type"])){
								// 	$files_gallery = $_FILES["gallary-img"];
								// 	var_dump($files_gallery);
								// }

								$post_title = sanitize_text_field($_POST['post_title']);
								$bd_post = sanitize_text_field($_POST['bd_post']);
								//$post_content = sanitize_text_field($_POST['post_content']);
								$post_content =  apply_filters('the_content', $_POST['post_content']);								
								$post_tags = sanitize_text_field($_POST['post_tags']);

								if(isset($_FILES["userImage"]["type"])){
									$msg = '';
									$uploaded = FALSE;
									$extensions = array("jpeg", "jpg", "png", "gif"); // file extensions to be checked
									$fileTypes = array("image/png","image/jpg","image/jpeg","image/gif"); // file types to be checked
									$file = $_FILES["userImage"];
									$attachment_id =  my_upload_user_file_from_form($file);	
								}
								$dientich_post = sanitize_text_field( $_POST['dientich_post'] );	
								$area = sanitize_text_field( $_POST['area'] );	
								$area = get_term_by('slug', $area, 'area');
								$area = $area->term_id;
								$address_post = sanitize_text_field( $_POST['address_post'] );
								$gia_post = sanitize_text_field( $_POST['gia_post'] );	
								$donvi_price_post = sanitize_text_field( $_POST['donvi_price_post'] );
								$video_post = sanitize_text_field( $_POST['video_post']);
								$phongtam_post = sanitize_text_field($_POST['phongtam_post']);
								$phongngu_post = sanitize_text_field($_POST['phongngu_post']);
								$huongnha_post = sanitize_text_field($_POST['huongnha_post']);
								$huongbancong_post = sanitize_text_field($_POST['huongbancong_post']);
								$duongvao_post = sanitize_text_field($_POST['duongvao_post']);
								$mattien_post = sanitize_text_field($_POST['mattien_post']);
								$sotang_post = sanitize_text_field($_POST['sotang_post']);
								$noithat_post = sanitize_text_field($_POST['noithat_post']);
								$tienichkemtheo_post = sanitize_text_field($_POST['tienichkemtheo_post']);
								$dacdiemxahoi_post = sanitize_text_field($_POST['dacdiemxahoi_post']);
								$phaply_post = sanitize_text_field($_POST['phaply_post']);
								// $duongpho_post = sanitize_text_field($_POST['duongpho_post']);
								$tenlienhe_post = sanitize_text_field($_POST['tenlienhe_post']);
								$user_address_post = sanitize_text_field($_POST['user_address_post']);
								$phone_post = sanitize_text_field($_POST['phone_post']);
								$user_email_post = sanitize_text_field($_POST['user_email_post']);
								$danhmuc = sanitize_text_field($_POST['danhmuc']);
								$id_dmuc = get_category_by_slug($danhmuc); 
								$id_dmuc = $id_dmuc->term_id;
								
								$loaibds = sanitize_text_field($_POST['loaibds']);
								$loaibds = get_term_by('slug', $loaibds, 'loaibds');
								$loaibds = $loaibds->term_id;

								$quan_huyen = sanitize_text_field($_POST['quan_huyen']);
								$phuong_xa = sanitize_text_field($_POST['phuong_xa']);
								
								if ( $post_title == "" && $post_content == "") {
									echo '<div class="alert alert-danger text-center"><strong>Lỗi: Vui lòng không bỏ trống những thông tin bắt buộc!</strong></div>';		
								} else {
									$post = array(
										'post_title'    => wp_strip_all_tags($post_title),
										'post_content'  => $post_content,
										'post_category' => array(1,$id_dmuc),
										'tags_input'    => $post_tags,
										'post_status'   => $status_post,
										'post_type' => 'post',
										'tax_input' => array(
										'area' => array($area),
										'khuvucbds' => array($quan_huyen,$phuong_xa),
										'loaibds' => array($loaibds),
										)
									);
									$bdsttp_post_id = wp_insert_post($post);
									if(isset($_FILES["gallary-img"]["type"])){
										$files_gallery = $_FILES["gallary-img"];
										upload_imgs_gallerry($files_gallery, $bdsttp_post_id);
									}
								
									update_post_meta($bdsttp_post_id,'bd_post',$bd_post);									
									update_post_meta( $bdsttp_post_id, 'dientich_post', $dientich_post);
									update_post_meta( $bdsttp_post_id, 'address_post', $address_post);
									update_post_meta( $bdsttp_post_id, 'gia_post', $gia_post);
									update_post_meta($bdsttp_post_id, 'donvi_price_post', $donvi_price_post);
									update_post_meta( $bdsttp_post_id, 'phongtam_post', $phongtam_post);
									update_post_meta( $bdsttp_post_id, 'phongngu_post', $phongngu_post);
									update_post_meta( $bdsttp_post_id, 'huongnha_post', $huongnha_post);
									update_post_meta( $bdsttp_post_id, 'huongbancong_post', $huongbancong_post);
									update_post_meta( $bdsttp_post_id, 'duongvao_post', $duongvao_post);
									update_post_meta( $bdsttp_post_id, 'mattien_post', $mattien_post);
									update_post_meta( $bdsttp_post_id, 'sotang_post', $sotang_post);
									update_post_meta( $bdsttp_post_id, 'noithat_post', $noithat_post);
									update_post_meta( $bdsttp_post_id, 'tienichkemtheo_post', $tienichkemtheo_post);
									update_post_meta( $bdsttp_post_id, 'dacdiemxahoi_post', $dacdiemxahoi_post);
									update_post_meta( $bdsttp_post_id, 'phaply_post', $phaply_post);
									// update_post_meta( $bdsttp_post_id, 'duongpho_post', $duongpho_post);
									update_post_meta( $bdsttp_post_id, 'video_post', $video_post);
									update_post_meta( $bdsttp_post_id, 'tenlienhe_post', $tenlienhe_post);
									update_post_meta( $bdsttp_post_id, 'user_address_post', $user_address_post);
									update_post_meta( $bdsttp_post_id, 'phone_post', $phone_post);
									update_post_meta( $bdsttp_post_id, 'user_email_post', $user_email_post);

									update_post_meta($bdsttp_post_id,'_thumbnail_id',$attachment_id);	
									
									echo '<div class="alert alert-success text-center"><strong>Chúc mừng bạn. Bài viết của bạn sẽ được hệ thống chúng tôi xem xét và cập nhật lên Website.</strong></div>';
									echo '<script> window.alert("Chúc mừng bạn. Bài viết của bạn sẽ được hệ thống chúng tôi xem xét và cập nhật lên Website.");
									window.location = "'.get_bloginfo( 'url' ).'/dang-tin"</script>';  
									exit();
								}
							}?>
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
				<?php } else {
					echo '<script>window.location = "'.get_bloginfo( 'url' ).'/dang-nhap/"</script>';
				} ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
<script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script>
<!-- <script src="<?php echo get_template_directory_uri();?>/uploadavatar.js"></script> -->

<!-- <script src="<?php echo get_template_directory_uri();?>/assets/js/gallery-metabox.js"></script> -->
<script src="<?php echo get_template_directory_uri();?>/assets/js/ajax-upload.js"></script>
