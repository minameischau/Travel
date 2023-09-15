<?php

	$modern_blogger_custom_css = '';

	// Layout Options
	$modern_blogger_theme_layout = get_theme_mod( 'modern_blogger_theme_layout_options','Default Theme');
    if($modern_blogger_theme_layout == 'Default Theme'){
		$modern_blogger_custom_css .='body{';
			$modern_blogger_custom_css .='max-width: 100%;';
		$modern_blogger_custom_css .='}';
	}else if($modern_blogger_theme_layout == 'Container Theme'){
		$modern_blogger_custom_css .='body{';
			$modern_blogger_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$modern_blogger_custom_css .='}';
	}else if($modern_blogger_theme_layout == 'Box Container Theme'){
		$modern_blogger_custom_css .='body{';
			$modern_blogger_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$modern_blogger_custom_css .='}';
	}
	
	/*--------- Preloader Color Option -------*/
	$modern_blogger_preloader_color = get_theme_mod('modern_blogger_preloader_color');

	if($modern_blogger_preloader_color != false){
		$modern_blogger_custom_css .=' .tg-loader{';
			$modern_blogger_custom_css .='border-color: '.esc_attr($modern_blogger_preloader_color).';';
		$modern_blogger_custom_css .='} ';
		$modern_blogger_custom_css .=' .tg-loader-inner, .preloader .preloader-container .animated-preloader, .preloader .preloader-container .animated-preloader:before{';
			$modern_blogger_custom_css .='background-color: '.esc_attr($modern_blogger_preloader_color).';';
		$modern_blogger_custom_css .='} ';
	}

	$modern_blogger_preloader_bg_color = get_theme_mod('modern_blogger_preloader_bg_color');

	if($modern_blogger_preloader_bg_color != false){
		$modern_blogger_custom_css .=' #overlayer, .preloader{';
			$modern_blogger_custom_css .='background-color: '.esc_attr($modern_blogger_preloader_bg_color).';';
		$modern_blogger_custom_css .='} ';
	}

	/*------------ Button Settings option-----------------*/

	$modern_blogger_top_button_padding = get_theme_mod('modern_blogger_top_button_padding');
	$modern_blogger_bottom_button_padding = get_theme_mod('modern_blogger_bottom_button_padding');
	$modern_blogger_left_button_padding = get_theme_mod('modern_blogger_left_button_padding');
	$modern_blogger_right_button_padding = get_theme_mod('modern_blogger_right_button_padding');
	if($modern_blogger_top_button_padding != false || $modern_blogger_bottom_button_padding != false || $modern_blogger_left_button_padding != false || $modern_blogger_right_button_padding != false){
		$modern_blogger_custom_css .='.blogbtn a, .read-more a, #comments input[type="submit"].submit{';
			$modern_blogger_custom_css .='padding-top: '.esc_attr($modern_blogger_top_button_padding).'px; padding-bottom: '.esc_attr($modern_blogger_bottom_button_padding).'px; padding-left: '.esc_attr($modern_blogger_left_button_padding).'px; padding-right: '.esc_attr($modern_blogger_right_button_padding).'px; display:inline-block;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_button_border_radius = get_theme_mod('modern_blogger_button_border_radius');
	$modern_blogger_custom_css .='.blogbtn a, .read-more a, #comments input[type="submit"].submit{';
		$modern_blogger_custom_css .='border-radius: '.esc_attr($modern_blogger_button_border_radius).'px;';
	$modern_blogger_custom_css .='}';

	/*----------- Copyright css -----*/
	$modern_blogger_copyright_top_padding = get_theme_mod('modern_blogger_top_copyright_padding');
	$modern_blogger_copyright_bottom_padding = get_theme_mod('modern_blogger_bottom_copyright_padding');
	if($modern_blogger_copyright_top_padding != '' || $modern_blogger_copyright_bottom_padding != ''){
		$modern_blogger_custom_css .='.inner{';
			$modern_blogger_custom_css .='padding-top: '.esc_attr($modern_blogger_copyright_top_padding).'px; padding-bottom: '.esc_attr($modern_blogger_copyright_bottom_padding).'px; ';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_copyright_alignment = get_theme_mod('modern_blogger_copyright_alignment', 'center');
	if($modern_blogger_copyright_alignment == 'center' ){
		$modern_blogger_custom_css .='#footer .copyright p{';
			$modern_blogger_custom_css .='text-align: '. $modern_blogger_copyright_alignment .';';
		$modern_blogger_custom_css .='}';
	}elseif($modern_blogger_copyright_alignment == 'left' ){
		$modern_blogger_custom_css .='#footer .copyright p{';
			$modern_blogger_custom_css .=' text-align: '. $modern_blogger_copyright_alignment .';';
		$modern_blogger_custom_css .='}';
	}elseif($modern_blogger_copyright_alignment == 'right' ){
		$modern_blogger_custom_css .='#footer .copyright p{';
			$modern_blogger_custom_css .='text-align: '. $modern_blogger_copyright_alignment .';';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_copyright_font_size = get_theme_mod('modern_blogger_copyright_font_size');
	$modern_blogger_custom_css .='#footer .copyright p{';
		$modern_blogger_custom_css .='font-size: '.esc_attr($modern_blogger_copyright_font_size).'px;';
	$modern_blogger_custom_css .='}';

	/*------ Topbar padding ------*/
	$modern_blogger_top_topbar_padding = get_theme_mod('modern_blogger_top_topbar_padding');
	$modern_blogger_bottom_topbar_padding = get_theme_mod('modern_blogger_bottom_topbar_padding');
	if($modern_blogger_top_topbar_padding != false || $modern_blogger_bottom_topbar_padding != false){
		$modern_blogger_custom_css .='.top-bar, .page-template-custom-front-page .top-bar{';
			$modern_blogger_custom_css .='padding-top: '.esc_attr($modern_blogger_top_topbar_padding).'px !important; padding-bottom: '.esc_attr($modern_blogger_bottom_topbar_padding).'px !important; ';
		$modern_blogger_custom_css .='}';
	}

	/*------ Woocommerce ----*/
	$modern_blogger_product_border = get_theme_mod('modern_blogger_product_border',true);

	if($modern_blogger_product_border == false){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$modern_blogger_custom_css .='border: 0;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_product_top = get_theme_mod('modern_blogger_product_top_padding',10);
	$modern_blogger_product_bottom = get_theme_mod('modern_blogger_product_bottom_padding',10);
	$modern_blogger_product_left = get_theme_mod('modern_blogger_product_left_padding',10);
	$modern_blogger_product_right = get_theme_mod('modern_blogger_product_right_padding',10);
	if($modern_blogger_product_top != false || $modern_blogger_product_bottom != false || $modern_blogger_product_left != false || $modern_blogger_product_right != false){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$modern_blogger_custom_css .='padding-top: '.esc_attr($modern_blogger_product_top).'px; padding-bottom: '.esc_attr($modern_blogger_product_bottom).'px; padding-left: '.esc_attr($modern_blogger_product_left).'px; padding-right: '.esc_attr($modern_blogger_product_right).'px;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_product_border_radius = get_theme_mod('modern_blogger_product_border_radius');
	if($modern_blogger_product_border_radius != false){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$modern_blogger_custom_css .='border-radius: '.esc_attr($modern_blogger_product_border_radius).'px;';
		$modern_blogger_custom_css .='}';
	}

	/*----- WooCommerce button css --------*/
	$modern_blogger_product_button_top = get_theme_mod('modern_blogger_product_button_top_padding',10);
	$modern_blogger_product_button_bottom = get_theme_mod('modern_blogger_product_button_bottom_padding',10);
	$modern_blogger_product_button_left = get_theme_mod('modern_blogger_product_button_left_padding',12);
	$modern_blogger_product_button_right = get_theme_mod('modern_blogger_product_button_right_padding',12);
	if($modern_blogger_product_button_top != false || $modern_blogger_product_button_bottom != false || $modern_blogger_product_button_left != false || $modern_blogger_product_button_right != false){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product .button, .woocommerce div.product form.cart .button, a.button.wc-forward, .woocommerce .cart .button, .woocommerce .cart input.button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, button.woocommerce-button.button.woocommerce-form-login__submit, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled]{';
			$modern_blogger_custom_css .='padding-top: '.esc_attr($modern_blogger_product_button_top).'px; padding-bottom: '.esc_attr($modern_blogger_product_button_bottom).'px; padding-left: '.esc_attr($modern_blogger_product_button_left).'px; padding-right: '.esc_attr($modern_blogger_product_button_right).'px;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_product_button_border_radius = get_theme_mod('modern_blogger_product_button_border_radius');
	if($modern_blogger_product_button_border_radius != false){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product .button, .woocommerce div.product form.cart .button, a.button.wc-forward, .woocommerce .cart .button, .woocommerce .cart input.button, a.checkout-button.button.alt.wc-forward, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, button.woocommerce-button.button.woocommerce-form-login__submit{';
			$modern_blogger_custom_css .='border-radius: '.esc_attr($modern_blogger_product_button_border_radius).'px;';
		$modern_blogger_custom_css .='}';
	}

	/*----- WooCommerce product sale css --------*/
	$modern_blogger_product_sale_top = get_theme_mod('modern_blogger_product_sale_top_padding');
	$modern_blogger_product_sale_bottom = get_theme_mod('modern_blogger_product_sale_bottom_padding');
	$modern_blogger_product_sale_left = get_theme_mod('modern_blogger_product_sale_left_padding');
	$modern_blogger_product_sale_right = get_theme_mod('modern_blogger_product_sale_right_padding');
	if($modern_blogger_product_sale_top != false || $modern_blogger_product_sale_bottom != false || $modern_blogger_product_sale_left != false || $modern_blogger_product_sale_right != false){
		$modern_blogger_custom_css .='.woocommerce span.onsale {';
			$modern_blogger_custom_css .='padding-top: '.esc_attr($modern_blogger_product_sale_top).'px; padding-bottom: '.esc_attr($modern_blogger_product_sale_bottom).'px; padding-left: '.esc_attr($modern_blogger_product_sale_left).'px; padding-right: '.esc_attr($modern_blogger_product_sale_right).'px;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_product_sale_border_radius = get_theme_mod('modern_blogger_product_sale_border_radius',0);
	if($modern_blogger_product_sale_border_radius != false){
		$modern_blogger_custom_css .='.woocommerce span.onsale {';
			$modern_blogger_custom_css .='border-radius: '.esc_attr($modern_blogger_product_sale_border_radius).'px;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_menu_case = get_theme_mod('modern_blogger_product_sale_position', 'Right');
	if($modern_blogger_menu_case == 'Right' ){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product .onsale{';
			$modern_blogger_custom_css .=' left:auto; right:0;';
		$modern_blogger_custom_css .='}';
	}elseif($modern_blogger_menu_case == 'Left' ){
		$modern_blogger_custom_css .='.woocommerce ul.products li.product .onsale{';
			$modern_blogger_custom_css .=' left:-10px; right:auto;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_product_sale_font_size = get_theme_mod('modern_blogger_product_sale_font_size',13);
	$modern_blogger_custom_css .='.woocommerce span.onsale {';
		$modern_blogger_custom_css .='font-size: '.esc_attr($modern_blogger_product_sale_font_size).'px;';
	$modern_blogger_custom_css .='}';


	/*---- Comment form ----*/
	$modern_blogger_comment_width = get_theme_mod('modern_blogger_comment_width', '100');
	$modern_blogger_custom_css .='#comments textarea{';
		$modern_blogger_custom_css .=' width:'.esc_attr($modern_blogger_comment_width).'%;';
	$modern_blogger_custom_css .='}';

	$modern_blogger_comment_submit_text = get_theme_mod('modern_blogger_comment_submit_text', 'Post Comment');
	if($modern_blogger_comment_submit_text == ''){
		$modern_blogger_custom_css .='#comments p.form-submit {';
			$modern_blogger_custom_css .='display: none;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_comment_title = get_theme_mod('modern_blogger_comment_title', 'Leave a Reply');
	if($modern_blogger_comment_title == ''){
		$modern_blogger_custom_css .='#comments h2#reply-title {';
			$modern_blogger_custom_css .='display: none;';
		$modern_blogger_custom_css .='}';
	}

	/*------ Footer background css -------*/
	$modern_blogger_footer_bg_color = get_theme_mod('modern_blogger_footer_bg_color');
	if($modern_blogger_footer_bg_color != false){
		$modern_blogger_custom_css .='.footerinner{';
			$modern_blogger_custom_css .='background-color: '.esc_attr($modern_blogger_footer_bg_color).';';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_footer_bg_image = get_theme_mod('modern_blogger_footer_bg_image');
	if($modern_blogger_footer_bg_image != false){
		$modern_blogger_custom_css .='.footerinner{';
			$modern_blogger_custom_css .='background: url('.esc_attr($modern_blogger_footer_bg_image).');';
		$modern_blogger_custom_css .='}';
	}

	/*----- Featured image css -----*/
	$modern_blogger_feature_image_border_radius = get_theme_mod('modern_blogger_feature_image_border_radius');
	if($modern_blogger_feature_image_border_radius != false){
		$modern_blogger_custom_css .='.blog-sec img{';
			$modern_blogger_custom_css .='border-radius: '.esc_attr($modern_blogger_feature_image_border_radius).'px;';
		$modern_blogger_custom_css .='}';
	}

	$modern_blogger_feature_image_shadow = get_theme_mod('modern_blogger_feature_image_shadow');
	if($modern_blogger_feature_image_shadow != false){
		$modern_blogger_custom_css .='.blog-sec img{';
			$modern_blogger_custom_css .='box-shadow: '.esc_attr($modern_blogger_feature_image_shadow).'px '.esc_attr($modern_blogger_feature_image_shadow).'px '.esc_attr($modern_blogger_feature_image_shadow).'px #aaa;';
		$modern_blogger_custom_css .='}';
	}

	/*------ Sticky header padding ------------*/
	$modern_blogger_top_sticky_header_padding = get_theme_mod('modern_blogger_top_sticky_header_padding');
	$modern_blogger_bottom_sticky_header_padding = get_theme_mod('modern_blogger_bottom_sticky_header_padding');
	$modern_blogger_custom_css .=' .fixed-header{';
		$modern_blogger_custom_css .=' padding-top: '.esc_attr($modern_blogger_top_sticky_header_padding).'px; padding-bottom: '.esc_attr($modern_blogger_bottom_sticky_header_padding).'px';
	$modern_blogger_custom_css .='}';

		// featured image dimention
	$modern_blogger_blog_image_dimension = get_theme_mod('modern_blogger_blog_image_dimension', 'default');
	$modern_blogger_feature_image_custom_width = get_theme_mod('modern_blogger_feature_image_custom_width',250);
	$modern_blogger_feature_image_custom_height = get_theme_mod('modern_blogger_feature_image_custom_height',250);
	if($modern_blogger_blog_image_dimension == 'custom'){
		$modern_blogger_custom_css .='.blog-sec img{';
			$modern_blogger_custom_css .='width: '.esc_attr($modern_blogger_feature_image_custom_width).'px; height: '.esc_attr($modern_blogger_feature_image_custom_height).'px;';
		$modern_blogger_custom_css .='}';
	}

	/*------ Related products ---------*/
	$modern_blogger_related_products = get_theme_mod('modern_blogger_single_related_products',true);
	if($modern_blogger_related_products == false){
		$modern_blogger_custom_css .=' .related.products{';
			$modern_blogger_custom_css .='display: none;';
		$modern_blogger_custom_css .='}';
	}

	// Featured image header
	$header_image_url = modern_blogger_banner_image( $image_url = '' );
	$modern_blogger_custom_css .='#page-site-header{';
		$modern_blogger_custom_css .='background-image: url('. esc_url( $header_image_url ).'); background-size: cover;';
	$modern_blogger_custom_css .='}';

	$modern_blogger_post_featured_image = get_theme_mod('modern_blogger_post_featured_image', 'in-content');
	if($modern_blogger_post_featured_image == 'banner' ){
		$modern_blogger_custom_css .='.single #wrapper h1, .page #wrapper h1, .page #wrapper img{';
			$modern_blogger_custom_css .=' display: none;';
		$modern_blogger_custom_css .='}';
		$modern_blogger_custom_css .='.page-template-custom-front-page #page-site-header{';
			$modern_blogger_custom_css .=' display: none;';
		$modern_blogger_custom_css .='}';
	}

	// Woocommerce Shop page pagination
	$modern_blogger_shop_page_navigation = get_theme_mod('modern_blogger_shop_page_navigation',true);
	if ($modern_blogger_shop_page_navigation == false) {
		$modern_blogger_custom_css .='.woocommerce nav.woocommerce-pagination{';
			$modern_blogger_custom_css .='display: none;';
		$modern_blogger_custom_css .='}';
	}

	/*----- Blog Post display type css ------*/
	$modern_blogger_blog_post_display_type = get_theme_mod('modern_blogger_blog_post_display_type', 'blocks');
	if($modern_blogger_blog_post_display_type == 'without blocks' ){
		$modern_blogger_custom_css .='.blog .blog-sec, .blog #sidebar .widget{';
			$modern_blogger_custom_css .='border: 0;';
		$modern_blogger_custom_css .='}';
	}

	/*---------- Responsive style ---------*/
	if (get_theme_mod('modern_blogger_hide_topbar_responsive',true) == true && get_theme_mod('modern_blogger_top_header',false) == false) {
		$modern_blogger_custom_css .='.top-bar{';
			$modern_blogger_custom_css .=' display: none;';
		$modern_blogger_custom_css .='} ';
	}

	if (get_theme_mod('modern_blogger_hide_topbar_responsive',true) == false) {
		$modern_blogger_custom_css .='@media screen and (max-width: 575px){
			.top-bar{';
			$modern_blogger_custom_css .=' display: none;';
		$modern_blogger_custom_css .='} }';
	} else if(get_theme_mod('modern_blogger_hide_topbar_responsive',true) == true){
		$modern_blogger_custom_css .='@media screen and (max-width: 575px){
			.top-bar{';
			$modern_blogger_custom_css .=' display: block;';
		$modern_blogger_custom_css .='} }';
	}

	// Site title Font Size
	$modern_blogger_site_title_font_size = get_theme_mod('modern_blogger_site_title_font_size', '25');
	$modern_blogger_custom_css .='.logo h1, .logo p.site-title{';
		$modern_blogger_custom_css .='font-size: '.esc_attr($modern_blogger_site_title_font_size).'px;';
	$modern_blogger_custom_css .='}';

	// Site tagline Font Size
	$modern_blogger_site_tagline_font_size = get_theme_mod('modern_blogger_site_tagline_font_size', '14');
	$modern_blogger_custom_css .='.logo p.site-description{';
		$modern_blogger_custom_css .='font-size: '.esc_attr($modern_blogger_site_tagline_font_size).'px;';
	$modern_blogger_custom_css .='}';

	// responsive settings
	if (get_theme_mod('modern_blogger_preloader_responsive',false) == true && get_theme_mod('modern_blogger_preloader',false) == false) {
		$modern_blogger_custom_css .='@media screen and (min-width: 575px){
			.preloader, #overlayer, .tg-loader{';
			$modern_blogger_custom_css .=' visibility: hidden;';
		$modern_blogger_custom_css .='} }';
	}
	if (get_theme_mod('modern_blogger_preloader_responsive',false) == false) {
		$modern_blogger_custom_css .='@media screen and (max-width: 575px){
			.preloader, #overlayer, .tg-loader{';
			$modern_blogger_custom_css .=' visibility: hidden;';
		$modern_blogger_custom_css .='} }';
	}

	// scroll to top
	$modern_blogger_scroll = get_theme_mod( 'modern_blogger_backtotop_responsive',true);
	if (get_theme_mod('modern_blogger_backtotop_responsive',true) == true && get_theme_mod('modern_blogger_hide_scroll',true) == false) {
    	$modern_blogger_custom_css .='.show-back-to-top{';
			$modern_blogger_custom_css .='visibility: hidden !important;';
		$modern_blogger_custom_css .='} ';
	}
    if($modern_blogger_scroll == true){
    	$modern_blogger_custom_css .='@media screen and (max-width:575px) {';
		$modern_blogger_custom_css .='.show-back-to-top{';
			$modern_blogger_custom_css .='visibility: visible !important;';
		$modern_blogger_custom_css .='} }';
	}else if($modern_blogger_scroll == false){
		$modern_blogger_custom_css .='@media screen and (max-width:575px) {';
		$modern_blogger_custom_css .='.show-back-to-top{';
			$modern_blogger_custom_css .='visibility: hidden !important;';
		$modern_blogger_custom_css .='} }';
	}

	/*------ Footer background css -------*/
	$modern_blogger_copyright_bg_color = get_theme_mod('modern_blogger_copyright_bg_color');
	if($modern_blogger_copyright_bg_color != false){
		$modern_blogger_custom_css .='.inner{';
			$modern_blogger_custom_css .='background-color: '.esc_attr($modern_blogger_copyright_bg_color).';';
		$modern_blogger_custom_css .='}';
	}
	
	// slider button
	if (get_theme_mod('modern_blogger_slider_button_responsive',true) == true && get_theme_mod('modern_blogger_slider_button',true) == false) {
		$modern_blogger_custom_css .='@media screen and (min-width: 575px){
			.read-more{';
			$modern_blogger_custom_css .=' display: none;';
		$modern_blogger_custom_css .='} }';
	}
	if (get_theme_mod('modern_blogger_slider_button_responsive',true) == false) {
		$modern_blogger_custom_css .='@media screen and (max-width: 575px){
			.read-more{';
			$modern_blogger_custom_css .=' display: none;';
		$modern_blogger_custom_css .='} }';
		$modern_blogger_custom_css .='@media screen and (max-width: 575px){
			#slider .carousel-caption{';
			$modern_blogger_custom_css .=' padding: 0px;';
		$modern_blogger_custom_css .='} }';
	}
