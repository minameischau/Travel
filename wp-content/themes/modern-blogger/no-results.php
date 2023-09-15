<?php
/**
 * The template part for displaying a message that posts cannot be found.
 * @package Modern Blogger
 */
?>

<header role="banner">
	<h2 class="entry-title"><?php echo esc_html( get_theme_mod('modern_blogger_search_result_title',__('Nothing Found', 'modern-blogger' )) ); ?></h2>
</header>

<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>	
	<p><?php printf( esc_html__( 'Ready to publish your first post? Get started here.', 'modern-blogger' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
<?php elseif ( is_search() ) : ?>
	<p><?php echo esc_html( get_theme_mod('modern_blogger_search_result_text',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'modern-blogger' )) ); ?></p><br />
		<?php get_search_form(); ?>
<?php else : ?>
	<p><?php esc_html_e( 'Dont worry it happens to the best of us.', 'modern-blogger' ); ?></p><br />
	<div class="read-moresec mt-3">
		<a href="<?php echo esc_url( home_url() ); ?>" class="button py-2 px-4"><?php esc_html_e( 'Return to the home page', 'modern-blogger' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Return to the home page', 'modern-blogger' ); ?></span></a>
	</div>
<?php endif; ?>