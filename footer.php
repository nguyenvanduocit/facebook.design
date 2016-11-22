<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fbd
 */

?>

	</div><!-- #content -->
	<div id="footer" layout="rows center-left">
		<div id="end-mark">
			<div class="end-mark-icon" style="background-image: url(<?php echo esc_attr(fbd_logo_src()); ?>)"></div>
			<p class="copyright"><?php echo bloginfo("site_title") ?> © <?php echo date("Y") ?></p>
		</div>
		<div id="footer-links" self="right">
			<?php $social_links = fbd_social_links(); ?>
			<ul>
				<?php foreach ($social_links as $social => $link){
					if($link){
						echo  '<a href="'.$link.'"><li class="'.$social.'"></li></a>';
					}
				} ?>
			</ul>
		</div>
	</div>
<?php wp_footer(); ?>

</body>
</html>
