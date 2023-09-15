<?php
/**
 * The template for displaying the footer.
 * @package Modern Blogger
 */
?>
<?php if( get_theme_mod( 'modern_blogger_hide_scroll',true) != '' || get_theme_mod( 'modern_blogger_backtotop_responsive',true) != '') { ?>
  <?php $modern_blogger_scroll_align = get_theme_mod( 'modern_blogger_back_to_top','Right');
  if($modern_blogger_scroll_align == 'Left'){ ?>
    <a href="#content" class="back-to-top scroll-left text-center"><?php esc_html_e('Top', 'modern-blogger'); ?><span class="screen-reader-text"><?php esc_html_e('Back to Top', 'modern-blogger'); ?></span></a>
  <?php }else if($modern_blogger_scroll_align == 'Center'){ ?>
    <a href="#content" class="back-to-top scroll-center text-center"><?php esc_html_e('Top', 'modern-blogger'); ?><span class="screen-reader-text"><?php esc_html_e('Back to Top', 'modern-blogger'); ?></span></a>
  <?php }else{ ?>
    <a href="#content" class="back-to-top scroll-right text-center"><?php esc_html_e('Top', 'modern-blogger'); ?><span class="screen-reader-text"><?php esc_html_e('Back to Top', 'modern-blogger'); ?></span></a>
  <?php }?>
<?php }?>
<footer role="contentinfo" id="footer">
  <?php //Set widget areas classes based on user choice
    $modern_blogger_footer_columns = get_theme_mod('modern_blogger_footer_widget', '4');
    if ($modern_blogger_footer_columns == '3') {
      $modern_blogger_cols = 'col-lg-4 col-md-4';
    } elseif ($modern_blogger_footer_columns == '4') {
      $modern_blogger_cols = 'col-lg-3 col-md-3';
    } elseif ($modern_blogger_footer_columns == '2') {
      $modern_blogger_cols = 'col-lg-6 col-md-6';
    } else {
      $modern_blogger_cols = 'col-lg-12 col-md-12';
    }
  ?>
  <?php
  if ( is_active_sidebar( 'footer-1' ) ||
    is_active_sidebar( 'footer-2' ) ||
    is_active_sidebar( 'footer-3' ) ||
    is_active_sidebar( 'footer-4' ) ) :
  ?>
  <div class="footerinner py-4">
    <div class="container">
      <div class="row">
        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
          <div class="sidebar-column <?php echo esc_attr( $modern_blogger_cols ); ?>">
            <?php dynamic_sidebar( 'footer-1'); ?>
          </div>
        <?php endif; ?> 
        <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
          <div class="sidebar-column <?php echo esc_attr( $modern_blogger_cols ); ?>">
            <?php dynamic_sidebar( 'footer-2'); ?>
          </div>
        <?php endif; ?> 
        <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
          <div class="sidebar-column <?php echo esc_attr( $modern_blogger_cols ); ?>">
            <?php dynamic_sidebar( 'footer-3'); ?>
          </div>
        <?php endif; ?> 
        <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
          <div class="sidebar-column <?php echo esc_attr( $modern_blogger_cols ); ?>">
            <?php dynamic_sidebar( 'footer-4'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <div class="inner">
    <div class="container">
      <div class="copyright">
        <p class="m-0"><?php echo esc_html(get_theme_mod('modern_blogger_text',__('Modern Blogger WordPress Theme By Themesglance','modern-blogger'))); ?></p>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>