<?php 
	/*Template Name: Thanh Vien Template*/
	get_header();	
	global $wpdb; 
	$account_type = addslashes( $_GET['account_type'] );
?>
<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="block-2 account_group">
					<?php if($account_type) {
							echo '<h3>Danh sách các công ty môi giới</h3>';
						} else {
							echo '<h3>Danh sách các môi giới viên</h3>';
						}?>
					
					<div class="content-block">
						<?php if($account_type) {
							getUserRoles('mogioicongty','20','s');
						} else {
							getUserRoles('Mogioicanhan','20','s');
						}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>