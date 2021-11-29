<?php
/**
 * The template for displaying the 404 template in the Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<div class="container section-inner thin error404-content">
		<div class="bg-white py-4 py-md-5 px-3 px-md-5 text-center">
			<div class="py-lg-4">
				<img loading="lazy" src="<?php echo get_template_directory_uri();?>/assets/images/404.svg" class="img-fluid d-block mx-auto mb-4" alt="<?php echo get_bloginfo( 'name' ); ?>">
				<h1 class="entry-title"><?php _e( 'Không tìm thấy đường dẫn này', 'twentytwenty' ); ?></h1>
				<div class="intro-text"><p>Bạn có thể truy cập vào <a href="<?php bloginfo('url'); ?>" title="trang chủ" style="color:#00aef0">trang chủ</a> hoặc sử dụng ô dưới đây để tìm kiếm</p></div>
				<?php
				get_search_form(
					array(
						'aria_label' => __( '404 not found', 'twentytwenty' ),
					)
				);
				?>
			</div>
		</div>
	</div>
<?php
get_footer();
