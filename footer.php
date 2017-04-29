<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Reactive_Magazine
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-menu">
			<a href="<?php echo get_site_url(); ?>/about-us" class="footer-link">About us</a>
			<span class="dotter">&bull;</span>
			<a href="<?php echo get_site_url(); ?>/contact-us" class="footer-link">Contact us</a>
			<span class="dotter">&bull;</span>
			<a href="<?php echo get_site_url(); ?>/promote" class="footer-link">Promote</a>
			<span class="dotter">&bull;</span>
			<a href="https://www.instagram.com/reacmag/" target="_blank" class="social-link fa fa-instagram"></a>
			<span class="dotter">&bull;</span>
			<a href="https://www.facebook.com/reacmag/" target="_blank" class="social-link fa fa-facebook"></a>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
