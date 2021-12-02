<?php 
	/*Template Name: Contact Template*/
	get_header();	
	global $wpdb; 
?>
<main class="main">
	<div class="wrap-crumbs container my-3 my-md-4"><?php if(function_exists('breadcrumb')){breadcrumb();} ?></div>
	<div class="contact-form py-md-4">
		<div class="container">
		    <div class="row">
		      <div class="col-md-6 order-sm-1 mb-4">
		        <h3 class="text-uppercase item-line mb-3 mb-md-5 position-relative"><span class="pb-2">Nhập nội dung</span></h3>
		        <div class="wrap-form-contact bg-even px-4 py-3">
		          <?php if(function_exists('contactForm')){ echo contactForm(); } ?>                 
		        </div>
		      </div>
		      <div class="col-md-6 mb-4">
		        <div class="pr-md-5">
		          <div class="pr-lg-5">
		            <h3 class="text-uppercase item-line mb-4 mb-md-5 position-relative"><span class="pb-2">Thông tin</span></h3>
		            <h2 class="mb-2 text-uppercase">The Light Home</h2>
								<p>Phòng Đẹp Dịch Vụ Thông Minh Chuyên cung cấp phòng cho thuê tại Thành phố Hồ Chí Minh</p>
		            <ul class="address list-unstyled mb-4">
		              <?php if(get_option('address_company') !='') {echo'<li class="address-icon">'.get_option('address_company').'</li>';}?>
		              <?php if(get_option('phone_company') !='') {echo'<li class="hotline-icon">'.get_option('phone_company').'</li>';}?>
		              <?php if(get_option('fax_company') !='') {echo'<li class="fax-icon">'.get_option('fax_company').'</li>';}?>
		              <?php if(get_option('mail_company') !='') {echo'<li class="mail-icon">'.get_option('mail_company').'</li>';}?>
		              <li class="website-icon">www.thelighthome.vn</li>
		            </ul>
		          </div>
		        </div>              
		      </div>      
		    </div>
		</div>   
	</div>
	<?php if(get_option('google_map') !='') { echo'<div class="map">'.get_option('google_map').'</div>';}?>
</main>
<?php get_footer(); ?>