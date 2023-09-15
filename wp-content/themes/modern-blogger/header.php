<?php
/**
 * The Header for our theme.
 * @package Modern Blogger
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
	} else {
	    do_action( 'wp_body_open' );
	}?> 
	
	<?php if(get_theme_mod('modern_blogger_preloader',false) || get_theme_mod('modern_blogger_preloader_responsive',false)){ ?>
    <?php if(get_theme_mod( 'modern_blogger_preloader_type','Square') == 'Square'){ ?>
      <div id="overlayer"></div>
      <span class="tg-loader">
      	<span class="tg-loader-inner"></span>
      </span>
    <?php }else if(get_theme_mod( 'modern_blogger_preloader_type') == 'Circle') {?>    
      <div class="preloader text-center">
        <div class="preloader-container">
          <span class="animated-preloader"></span>
        </div>
      </div>
    <?php }?>
	<?php }?>
<header role="banner" class="position-relative">
	<a class="screen-reader-text skip-link" href="#maincontent"><?php esc_html_e( 'Skip to content', 'modern-blogger' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Skip to content', 'modern-blogger' ); ?></span></a>

	<!-- topbar -->
	<div class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-9">
					<div class="logo text-lg-start text-center">
		      	<?php if ( has_custom_logo() ) : ?>
		        	<div class="site-logo"><?php the_custom_logo(); ?></div>
		        <?php endif; ?>
		          <?php $modern_blogger_blog_info = get_bloginfo( 'name' ); ?>
		          <?php if ( ! empty( $modern_blogger_blog_info ) ) : ?>
		          	<?php if( get_theme_mod('modern_blogger_show_site_title',true) != ''){ ?>
		              <?php if ( is_front_page() && is_home() ) : ?>
		              	<h1 class="site-title p-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		              <?php else : ?>
		                <p class="site-title m-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		              <?php endif; ?>
		          <?php }?>
		        <?php endif; ?>
		        <?php if( get_theme_mod('modern_blogger_show_tagline',true) != ''){ ?>
		          <?php
		          $modern_blogger_description = get_bloginfo( 'description', 'display' );
		          if ( $modern_blogger_description || is_customize_preview() ) :
		          ?>
		          	<p class="site-description m-0">
		              <?php echo esc_html($modern_blogger_description); ?>
		          	</p>
		          <?php endif; ?>
		        <?php }?>
		      </div>
	    	</div>
	    	<div class="col-lg-3"></div>
			</div>
		</div>
	</div>
	<!-- middle header -->
	<div class="container">
		<div class="middle-header">
			<div class="row">
				<div class="col-lg-1 col-md-2 col-1 align-self-center"><p class="bar-box mb-0"><i class="fas fa-bars"></i></p>
				</div>
				<div class="col-lg-8 col-md-5 col-11 align-self-center text-lg-center text-end">
					<?php if (has_nav_menu('primary')){ ?>
						<div class="toggle-menu responsive-menu">
			        <button role="tab" class="mobiletoggle"><i class="<?php echo esc_attr(get_theme_mod('modern_blogger_menu_open_icon','fas fa-bars')); ?> me-2"></i><?php echo esc_html( get_theme_mod('modern_blogger_mobile_menu_label', __('Menu','modern-blogger'))); ?><span class="screen-reader-text"><?php echo esc_html( get_theme_mod('modern_blogger_mobile_menu_label', __('Menu','modern-blogger'))); ?></span>
			        </button>
				    </div>
				  <?php }?>
	        <div id="sidelong-menu" class="nav side-nav">
	          <nav id="primary-site-navigation" class="nav-menu" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'modern-blogger' ); ?>">
	          	<?php if (has_nav_menu('primary')){
	              wp_nav_menu( array( 
	                'theme_location' => 'primary',
	                'container_class' => 'main-menu-navigation clearfix' ,
	                'menu_class' => 'clearfix',
	                'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
	                'fallback_cb' => 'wp_page_menu',
	              ) ); 
	          	}?>
	            <a href="javascript:void(0)" class="closebtn responsive-menu"><?php echo esc_html( get_theme_mod('modern_blogger_close_menu_label', __('Close Menu','modern-blogger'))); ?><i class="<?php echo esc_attr(get_theme_mod('modern_blogger_menu_close_icon','fas fa-times-circle')); ?> m-3"></i><span class="screen-reader-text"><?php echo esc_html( get_theme_mod('modern_blogger_close_menu_label', __('Close Menu','modern-blogger'))); ?></span></a>
	          </nav>
	        </div>
				</div>
				<div class="col-lg-3 col-md-5 align-self-center text-lg-end text-center">
					<?php if(get_theme_mod('modern_blogger_show_search',true)){ ?>
		          <div class="header-search">
		            <?php get_search_form();?>
		          </div>
		      <?php }?>
				</div>
			</div>
		</div>
	</div>
</header>
<hr>
	<?php if(get_theme_mod('modern_blogger_post_featured_image') == 'banner' ){
    if( is_singular() ) {?>
    	<div id="page-site-header">
        <div class='page-header'> 
        	<?php the_title( '<h1>', '</h1>' ); ?>
        </div>
    	</div>
    <?php }
	}?>