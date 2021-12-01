<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<div class="slide-bar">
    <?php searchBox(); ?>
    <?php  echo news_slidebar(); ?>
  </div>
