<?php
/**
 * Modern Blogger Theme Customizer
 * @package Modern Blogger
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function modern_blogger_customize_register( $wp_customize ) {	

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-selector.php' );

	class Modern_Blogger_WP_Customize_Range_Control extends WP_Customize_Control{
	    public $type = 'custom_range';
	    public function enqueue(){
	        wp_enqueue_script(
	            'cs-range-control',
	            false,
	            true
	        );
	    } 
	    public function render_content(){?>
	        <label>
	            <?php if ( ! empty( $this->label )) : ?>
	                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
	            <?php endif; ?>
	            <div class="cs-range-value"><?php echo esc_html($this->value()); ?></div>
	            <input data-input-type="range" type="range" <?php $this->input_attrs(); ?> value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> />
	            <?php if ( ! empty( $this->description )) : ?>
	                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
	            <?php endif; ?>
	        </label>
        <?php }
	}

	//add home page setting pannel
	$wp_customize->add_panel( 'modern_blogger_panel_id', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Settings', 'modern-blogger' ),
		'description' => __( 'Description of what this panel does.', 'modern-blogger' ),
	) );

	// font array
	$modern_blogger_font_array = array(
		'' => 'No Fonts',
		'Abril Fatface' => 'Abril Fatface',
		'Acme' => 'Acme',
		'Anton' => 'Anton',
		'Architects Daughter' => 'Architects Daughter',
		'Arimo' => 'Arimo',
		'Arsenal' => 'Arsenal', 
		'Arvo' => 'Arvo',
		'Alegreya' => 'Alegreya',
		'Alfa Slab One' => 'Alfa Slab One',
		'Averia Serif Libre' => 'Averia Serif Libre',
		'Bangers' => 'Bangers', 
		'Boogaloo' => 'Boogaloo',
		'Bad Script' => 'Bad Script',
		'Bitter' => 'Bitter',
		'Bree Serif' => 'Bree Serif',
		'BenchNine' => 'BenchNine', 
		'Cabin' => 'Cabin', 
		'Cardo' => 'Cardo',
		'Courgette' => 'Courgette',
		'Cherry Swash' => 'Cherry Swash',
		'Cormorant Garamond' => 'Cormorant Garamond',
		'Crimson Text' => 'Crimson Text',
		'Cuprum' => 'Cuprum', 
		'Cookie' => 'Cookie', 
		'Chewy' => 'Chewy', 
		'Days One' => 'Days One', 
		'Dosis' => 'Dosis',
		'Droid Sans' => 'Droid Sans',
		'Economica' => 'Economica',
		'Fredoka One' => 'Fredoka One',
		'Fjalla One' => 'Fjalla One',
		'Francois One' => 'Francois One',
		'Frank Ruhl Libre' => 'Frank Ruhl Libre',
		'Gloria Hallelujah' => 'Gloria Hallelujah',
		'Great Vibes' => 'Great Vibes',
		'Handlee' => 'Handlee', 
		'Hammersmith One' => 'Hammersmith One',
		'Inconsolata' => 'Inconsolata', 
		'Indie Flower' => 'Indie Flower', 
		'IM Fell English SC' => 'IM Fell English SC', 
		'Julius Sans One' => 'Julius Sans One',
		'Josefin Slab' => 'Josefin Slab', 
		'Josefin Sans' => 'Josefin Sans', 
		'Kanit' => 'Kanit', 
		'Lobster' => 'Lobster', 
		'Lato' => 'Lato',
		'Lora' => 'Lora', 
		'Libre Baskerville' =>'Libre Baskerville',
		'Lobster Two' => 'Lobster Two',
		'Merriweather' =>'Merriweather', 
		'Monda' => 'Monda',
		'Montserrat' => 'Montserrat',
		'Muli' => 'Muli', 
		'Marck Script' => 'Marck Script',
		'Noto Serif' => 'Noto Serif',
		'Open Sans' => 'Open Sans', 
		'Overpass' => 'Overpass',
		'Overpass Mono' => 'Overpass Mono',
		'Oxygen' => 'Oxygen', 
		'Orbitron' => 'Orbitron', 
		'Patua One' => 'Patua One', 
		'Pacifico' => 'Pacifico',
		'Padauk' => 'Padauk', 
		'Playball' => 'Playball',
		'Playfair Display' => 'Playfair Display', 
		'PT Sans' => 'PT Sans',
		'Philosopher' => 'Philosopher',
		'Permanent Marker' => 'Permanent Marker',
		'Poiret One' => 'Poiret One', 
		'Quicksand' => 'Quicksand', 
		'Quattrocento Sans' => 'Quattrocento Sans', 
		'Raleway' => 'Raleway', 
		'Rubik' => 'Rubik', 
		'Rokkitt' => 'Rokkitt', 
		'Russo One' => 'Russo One', 
		'Righteous' => 'Righteous', 
		'Slabo' => 'Slabo', 
		'Source Sans Pro' => 'Source Sans Pro', 
		'Shadows Into Light Two' =>'Shadows Into Light Two', 
		'Shadows Into Light' => 'Shadows Into Light', 
		'Sacramento' => 'Sacramento', 
		'Shrikhand' => 'Shrikhand', 
		'Tangerine' => 'Tangerine',
		'Ubuntu' => 'Ubuntu', 
		'VT323' => 'VT323', 
		'Varela Round' => 'Varela Round', 
		'Vampiro One' => 'Vampiro One',
		'Vollkorn' => 'Vollkorn',
		'Volkhov' => 'Volkhov', 
		'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
   );

	//Typography
	$wp_customize->add_section( 'modern_blogger_typography', array(
    	'title' => __( 'Typography', 'modern-blogger' ),
		'priority'   => 30,
		'panel' => 'modern_blogger_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'modern_blogger_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_paragraph_color', array(
		'label' => __('Paragraph Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_paragraph_font_family',array(
	  	'default' => '',
	  	'capability' => 'edit_theme_options',
	  	'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_paragraph_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'Paragraph Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	$wp_customize->add_setting('modern_blogger_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('modern_blogger_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'modern_blogger_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_atag_color', array(
		'label' => __('"a" Tag Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_atag_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( '"a" Tag Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'modern_blogger_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_li_color', array(
		'label' => __('"li" Tag Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_li_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( '"li" Tag Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'modern_blogger_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_h1_color', array(
		'label' => __('H1 Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_h1_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'H1 Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('modern_blogger_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_h1_font_size',array(
		'label'	=> __('H1 Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'modern_blogger_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_h2_color', array(
		'label' => __('h2 Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_h2_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'h2 Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('modern_blogger_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_h2_font_size',array(
		'label'	=> __('h2 Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'modern_blogger_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_h3_color', array(
		'label' => __('h3 Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_h3_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'h3 Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('modern_blogger_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_h3_font_size',array(
		'label'	=> __('h3 Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'modern_blogger_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_h4_color', array(
		'label' => __('h4 Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_h4_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'h4 Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('modern_blogger_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_h4_font_size',array(
		'label'	=> __('h4 Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'modern_blogger_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_h5_color', array(
		'label' => __('h5 Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_h5_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'h5 Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('modern_blogger_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_h5_font_size',array(
		'label'	=> __('h5 Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'modern_blogger_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_h6_color', array(
		'label' => __('h6 Color', 'modern-blogger'),
		'section' => 'modern_blogger_typography',
		'settings' => 'modern_blogger_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('modern_blogger_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control(
	   'modern_blogger_h6_font_family', array(
	   'section'  => 'modern_blogger_typography',
	   'label'    => __( 'h6 Fonts','modern-blogger'),
	   'type'     => 'select',
	   'choices'  => $modern_blogger_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('modern_blogger_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_h6_font_size',array(
		'label'	=> __('h6 Font Size','modern-blogger'),
		'section'	=> 'modern_blogger_typography',
		'setting'	=> 'modern_blogger_h6_font_size',
		'type'	=> 'text'
	));

	// Header
	$wp_customize->add_section('modern_blogger_header',array(
		'title'	=> __('Header','modern-blogger'),
		'priority' => null,
		'panel' => 'modern_blogger_panel_id',
	));

	 $wp_customize->add_setting('modern_blogger_show_search',array(
	    'default' => 'true',
	    'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	 ));
	 $wp_customize->add_control('modern_blogger_show_search',array(
	    'type' => 'checkbox',
	    'label' => __('Show/Hide Search','modern-blogger'),
	    'section' => 'modern_blogger_header'
	 ));

	$wp_customize->add_setting('modern_blogger_search_placeholder',array(
	    'default' => __('Search For News','modern-blogger'),
	    'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_search_placeholder',array(
	    'type' => 'text',
	    'label' => __('Search Placeholder text','modern-blogger'),
	    'section' => 'modern_blogger_header'
	 ));

	//Slider Section
	$wp_customize->add_section('modern_blogger_slider_section',array(
		'title'	=> __('Slider Section','modern-blogger'),
		'description'	=> __('Add slider section below.','modern-blogger'),
		'panel' => 'modern_blogger_panel_id',
	));

	$categories = get_categories();
		$cat_posts = array();
		$i = 0;
		$cat_posts[]='Select';	
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('modern_blogger_slider_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'modern_blogger_sanitize_choices',
	));
	$wp_customize->add_control('modern_blogger_slider_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select Category to display service posts','modern-blogger'),
		'section' => 'modern_blogger_slider_section',
	));
	
	$wp_customize->add_setting('modern_blogger_meta_field_separator_slider',array(
		'default'=> '.',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_meta_field_separator_slider',array(
		'label'	=> __('Add Meta Separator','modern-blogger'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','modern-blogger'),
		'section'=> 'modern_blogger_slider_section',
		'type'=> 'text'
	));

	//Services Section
	$wp_customize->add_section('modern_blogger_about',array(
		'title'	=> __('Services Section','modern-blogger'),
		'description' => __('Add About Us sections below.','modern-blogger'),
		'panel' => 'modern_blogger_panel_id',
	));

	// II Category Section 
	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
 	$i = 0;
	$pst[]='Select';  
	foreach($post_list as $post){
		$pst[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('modern_blogger_services_section_setting',array(
		'sanitize_callback' => 'modern_blogger_sanitize_choices',
	));

	$wp_customize->add_control('modern_blogger_services_section_setting',array(
		'type'    => 'select',
		'choices' => $pst,
		'label' => __('Select post','modern-blogger'),
		'section' => 'modern_blogger_about',
	));

	// category middle
	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post1[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post1[$category->slug] = $category->name;
	}

	$wp_customize->add_setting( 'modern_blogger_category1', array(
      'default'           => '',
      'sanitize_callback' => 'modern_blogger_sanitize_choices'
    ));
    $wp_customize->add_control('modern_blogger_category1',array(
		'type'    => 'select',
		'choices' => $cat_post1,
		'label' => __('Select Category to display Latest Post','modern-blogger'),
		'section' => 'modern_blogger_about',
	));

   // last post
   $args = array('numberposts' => -1);
	$post_list = get_posts($args);
 	$i = 0;
	$pst[]='Select';  
	foreach($post_list as $post){
		$pst[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('modern_blogger_add_post',array(
		'sanitize_callback' => 'modern_blogger_sanitize_choices',
	));

	$wp_customize->add_control('modern_blogger_add_post',array(
		'type'    => 'select',
		'choices' => $pst,
		'label' => __('Select post','modern-blogger'),
		'section' => 'modern_blogger_about',
	));

	$wp_customize->add_setting('modern_blogger_meta_field_separator_service',array(
		'default'=> '.',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_meta_field_separator_service',array(
		'label'	=> __('Add Meta Separator','modern-blogger'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','modern-blogger'),
		'section'=> 'modern_blogger_about',
		'type'=> 'text'
	));

	//layout setting
	$wp_customize->add_section( 'modern_blogger_theme_layout', array(
    	'title' => __( 'Blog Settings', 'modern-blogger' ),   
		'priority' => null,
		'panel' => 'modern_blogger_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('modern_blogger_layout',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	) );
	$wp_customize->add_control(new Modern_Blogger_Image_Radio_Control($wp_customize, 'modern_blogger_layout', array(
		'type' => 'radio',
		'label' => esc_html__('Select Sidebar layout', 'modern-blogger'),
		'section' => 'modern_blogger_theme_layout',
		'settings' => 'modern_blogger_layout',
		'choices' => array(
		   'Right Sidebar' => esc_url(get_template_directory_uri()) . '/images/layout3.png',
		   'Left Sidebar' => esc_url(get_template_directory_uri()) . '/images/layout2.png',
		   'One Column' => esc_url(get_template_directory_uri()) . '/images/layout1.png',
		   'Three Columns' => esc_url(get_template_directory_uri()) . '/images/layout4.png',
		   'Four Columns' => esc_url(get_template_directory_uri()) . '/images/layout5.png',
		   'Grid Layout' => esc_url(get_template_directory_uri()) . '/images/layout6.png'
	))));

	$wp_customize->add_setting('modern_blogger_blog_post_display_type',array(
		'default' => 'blocks',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_blog_post_display_type', array(
		'type' => 'select',
		'label' => __( 'Blog Page Display Type', 'modern-blogger' ),
		'section' => 'modern_blogger_theme_layout',
		'choices' => array(
		   'blocks' => __('Blocks','modern-blogger'),
		   'without blocks' => __('Without Blocks','modern-blogger'),
		),
    ));

	$wp_customize->add_setting('modern_blogger_metafields_date',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_metafields_date',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Date ','modern-blogger'),
		'section' => 'modern_blogger_theme_layout'
	));

	$wp_customize->add_setting('modern_blogger_metafields_author',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_metafields_author',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Author','modern-blogger'),
		'section' => 'modern_blogger_theme_layout'
	));

	$wp_customize->add_setting('modern_blogger_metafields_comment',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_metafields_comment',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Comments','modern-blogger'),
		'section' => 'modern_blogger_theme_layout'
	));

	$wp_customize->add_setting('modern_blogger_metafields_time',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_metafields_time',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Time','modern-blogger'),
		'section' => 'modern_blogger_theme_layout'
	));

	$wp_customize->add_setting('modern_blogger_featured_image',array(
       'default' => 'true',
       'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
    ));
    $wp_customize->add_control('modern_blogger_featured_image',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Featured Image','modern-blogger'),
       'section' => 'modern_blogger_theme_layout'
    ));

	$wp_customize->add_setting('modern_blogger_post_navigation',array(
		'default' => 'true',
		'sanitize_callback' => 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_post_navigation',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Post Navigation','modern-blogger'),
		'section' => 'modern_blogger_theme_layout'
	));

 	$wp_customize->add_setting('modern_blogger_blog_post_content',array(
    	'default' => 'Excerpt Content',
     	'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_blog_post_content',array(
		'type' => 'radio',
		'label' => __('Blog Post Content Type','modern-blogger'),
		'section' => 'modern_blogger_theme_layout',
		'choices' => array(
		   'No Content' => __('No Content','modern-blogger'),
		   'Full Content' => __('Full Content','modern-blogger'),
		   'Excerpt Content' => __('Excerpt Content','modern-blogger'),
		),
	) );

 	$wp_customize->add_setting( 'modern_blogger_post_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	) );
	$wp_customize->add_control( 'modern_blogger_post_excerpt_number', array(
		'label' => esc_html__( 'Blog Post Excerpt Number (Max 50)','modern-blogger' ),
		'section' => 'modern_blogger_theme_layout',
		'type'    => 'number',
		'settings' => 'modern_blogger_post_excerpt_number',
		'input_attrs' => array(
			'step'  => 1,
			'min'   => 0,
			'max'   => 50,
		),
		'active_callback' => 'modern_blogger_excerpt_enabled'
	) );

	$wp_customize->add_setting( 'modern_blogger_button_excerpt_suffix', array(
		'default'   => '...',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'modern_blogger_button_excerpt_suffix', array(
		'label'       => esc_html__( 'Post Excerpt Suffix','modern-blogger' ),
		'section'     => 'modern_blogger_theme_layout',
		'type'        => 'text',
		'settings'    => 'modern_blogger_button_excerpt_suffix',
		'active_callback' => 'modern_blogger_excerpt_enabled'
	) );

	//Featured Image
	$wp_customize->add_setting('modern_blogger_blog_image_dimension',array(
       'default' => 'default',
       'sanitize_callback'	=> 'modern_blogger_sanitize_choices'
    ));
    $wp_customize->add_control('modern_blogger_blog_image_dimension',array(
       'type' => 'radio',
       'label'	=> __('Blog Post Featured Image Dimension','modern-blogger'),
       'choices' => array(
            'default' => __('Default','modern-blogger'),
            'custom' => __('Custom Image Size','modern-blogger'),
        ),
      	'section'	=> 'modern_blogger_theme_layout',
    ));

    $wp_customize->add_setting( 'modern_blogger_feature_image_custom_width', array(
		'default'=> '250',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_feature_image_custom_width', array(
        'label'  => __('Featured Image Custom Width','modern-blogger'),
        'section'  => 'modern_blogger_theme_layout',
        'description' => __('Measurement is in pixel.','modern-blogger'),
        'input_attrs' => array(
            'min' => 0,
            'max' => 400,
        ),
		'active_callback' => 'modern_blogger_blog_image_dimension'
    )));

    $wp_customize->add_setting( 'modern_blogger_feature_image_custom_height', array(
		'default'=> '250',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_feature_image_custom_height', array(
        'label'  => __('Featured Image Custom Height','modern-blogger'),
        'section'  => 'modern_blogger_theme_layout',
        'description' => __('Measurement is in pixel.','modern-blogger'),
        'input_attrs' => array(
            'min' => 0,
            'max' => 400,
        ),
		'active_callback' => 'modern_blogger_blog_image_dimension'
    )));

	$wp_customize->add_setting( 'modern_blogger_feature_image_border_radius', array(
		'default'=> '0',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_feature_image_border_radius', array(
        'label'  => __('Featured Image Border Radius','modern-blogger'),
        'section'  => 'modern_blogger_theme_layout',
        'description' => __('Measurement is in pixel.','modern-blogger'),
        'input_attrs' => array(
            'min' => 0,
            'max' => 50,
        ),
    )));

	$wp_customize->add_setting( 'modern_blogger_feature_image_border_radius', array(
		'default'=> '0',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_feature_image_border_radius', array(
     	'label'  => __('Featured Image Border Radius','modern-blogger'),
     	'section'  => 'modern_blogger_theme_layout',
     	'description' => __('Measurement is in pixel.','modern-blogger'),
     	'input_attrs' => array(
         'min' => 0,
         'max' => 50,
     	),
 	)));

 	$wp_customize->add_setting( 'modern_blogger_feature_image_shadow', array(
		'default'=> '0',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_feature_image_shadow', array(
		'label'  => __('Featured Image Shadow','modern-blogger'),
		'section'  => 'modern_blogger_theme_layout',
		'description' => __('Measurement is in pixel.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 50,
		),
    )));

	$wp_customize->add_setting( 'modern_blogger_pagination_type', array(
		'default'			=> 'page-numbers',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control( 'modern_blogger_pagination_type', array(
		'section' => 'modern_blogger_theme_layout',
		'type' => 'select',
		'label' => __( 'Blog Pagination Style', 'modern-blogger' ),
		'choices' => array(
		   'page-numbers' => __('Number', 'modern-blogger' ),
	   	'next-prev' => __('Next/Prev', 'modern-blogger' ),
	)));

	$wp_customize->add_setting('modern_blogger_blog_nav_position',array(
		'default' => 'bottom',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_blog_nav_position', array(
		'type' => 'select',
		'label' => __( 'Blog Post Navigation Position', 'modern-blogger' ),
		'section' => 'modern_blogger_theme_layout',
		'choices' => array(
		   'top' => __('Top','modern-blogger'),
		   'bottom' => __('Bottom','modern-blogger'),
		   'both' => __('Both','modern-blogger')
		),
 	));

	$wp_customize->add_section( 'modern_blogger_single_post_settings', array(
		'title' => __( 'Single Post Options', 'modern-blogger' ),
		'panel' => 'modern_blogger_panel_id',
	));

	$wp_customize->add_setting('modern_blogger_single_post_breadcrumb',array(
		'default' => 'true',
		'sanitize_callback' => 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_breadcrumb',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Breadcrumb','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_single_post_date',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_date',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Date','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_single_post_author',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_author',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Author','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_single_post_comment_no',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_comment_no',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Comment Number','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_single_post_time',array(
       'default' => 'true',
       'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
    ));
    $wp_customize->add_control('modern_blogger_single_post_time',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Single Post Time','modern-blogger'),
       'section' => 'modern_blogger_single_post_settings'
    ));

	$wp_customize->add_setting('modern_blogger_metafields_tags',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_metafields_tags',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Tags','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_single_post_image',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_image',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Featured Image','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting( 'modern_blogger_post_featured_image', array(
		'default' => 'in-content',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control( 'modern_blogger_post_featured_image', array(
		'section' => 'modern_blogger_single_post_settings',
		'type' => 'radio',
		'label' => __( 'Featured Image Display Type', 'modern-blogger' ),
		'choices'		=> array(
		   'banner'  => __('as Banner Image', 'modern-blogger'),
		   'in-content' => __( 'as Featured Image', 'modern-blogger' ),
	)));

	$wp_customize->add_setting('modern_blogger_single_post_nav',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_nav',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post Navigation','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

 	$wp_customize->add_setting( 'modern_blogger_single_post_prev_nav_text', array(
		'default' => __('Previous','modern-blogger' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'modern_blogger_single_post_prev_nav_text', array(
		'label' => esc_html__( 'Single Post Previous Nav text','modern-blogger' ),
		'section'     => 'modern_blogger_single_post_settings',
		'type'        => 'text',
		'settings'    => 'modern_blogger_single_post_prev_nav_text'
	) );

	$wp_customize->add_setting( 'modern_blogger_single_post_next_nav_text', array(
		'default' => __('Next','modern-blogger' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'modern_blogger_single_post_next_nav_text', array(
		'label' => esc_html__( 'Single Post Next Nav text','modern-blogger' ),
		'section'     => 'modern_blogger_single_post_settings',
		'type'        => 'text',
		'settings'    => 'modern_blogger_single_post_next_nav_text'
	) );

	$wp_customize->add_setting('modern_blogger_single_post_comment',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_post_comment',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Single Post comment','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting( 'modern_blogger_comment_width', array(
		'default'=> '100',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_comment_width', array(
		'label'  => __('Comment textarea width','modern-blogger'),
		'section'  => 'modern_blogger_single_post_settings',
		'description' => __('Measurement is in %.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 100,
		),
    )));

	$wp_customize->add_setting('modern_blogger_comment_title',array(
		'default' => __('Leave a Reply','modern-blogger' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_comment_title',array(
		'type' => 'text',
		'label' => __('Comment form Title','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_comment_submit_text',array(
		'default' => __('Post Comment','modern-blogger' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_comment_submit_text',array(
		'type' => 'text',
		'label' => __('Comment Submit Button Label','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_related_posts',array(
		'default' => true,
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_related_posts',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Related Posts','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

	$wp_customize->add_setting('modern_blogger_related_posts_title',array(
		'default' => __('You May Also Like','modern-blogger' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_related_posts_title',array(
		'type' => 'text',
		'label' => __('Related Posts Title','modern-blogger'),
		'section' => 'modern_blogger_single_post_settings'
	));

 	$wp_customize->add_setting( 'modern_blogger_related_post_count', array(
		'default' => 3,
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	) );
	$wp_customize->add_control( 'modern_blogger_related_post_count', array(
		'label' => esc_html__( 'Related Posts Count','modern-blogger' ),
		'section' => 'modern_blogger_single_post_settings',
		'type' => 'number',
		'settings' => 'modern_blogger_related_post_count',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 6,
		),
	) );

	$wp_customize->add_setting( 'modern_blogger_post_shown_by', array(
		'default' => 'categories',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control( 'modern_blogger_post_shown_by', array(
		'section' => 'modern_blogger_single_post_settings',
		'type' => 'radio',
		'label' => __( 'Related Posts must be shown:', 'modern-blogger' ),
		'choices'		=> array(
		   'categories'  => __('By Categories', 'modern-blogger'),
		   'tags' => __( 'By Tags', 'modern-blogger' ),
	)));

	// Button option
	$wp_customize->add_section( 'modern_blogger_button_options', array(
		'title' =>  __( 'Button Options', 'modern-blogger' ),
		'panel' => 'modern_blogger_panel_id',
	));

 	$wp_customize->add_setting( 'modern_blogger_blog_button_text', array(
		'default'   => __('Read Full','modern-blogger' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'modern_blogger_blog_button_text', array(
		'label'       => esc_html__( 'Blog Post Button Label','modern-blogger' ),
		'section'     => 'modern_blogger_button_options',
		'type'        => 'text',
		'settings'    => 'modern_blogger_blog_button_text'
	) );

	$wp_customize->add_setting('modern_blogger_button_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('modern_blogger_button_padding',array(
		'label'	=> esc_html__('Button Padding','modern-blogger'),
		'section'=> 'modern_blogger_button_options',
		'active_callback' => 'modern_blogger_button_enabled'
	));

	$wp_customize->add_setting('modern_blogger_top_button_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_top_button_padding',array(
		'label'	=> __('Top','modern-blogger'),
		'input_attrs' => array(
         'step'             => 1,
			'min'              => 0,
			'max'              => 50,
     	),
		'section'=> 'modern_blogger_button_options',
		'type'=> 'number',
		'active_callback' => 'modern_blogger_button_enabled'
	));

	$wp_customize->add_setting('modern_blogger_bottom_button_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_bottom_button_padding',array(
		'label'	=> __('Bottom','modern-blogger'),
		'input_attrs' => array(
         'step'             => 1,
			'min'              => 0,
			'max'              => 50,
     	),
		'section'=> 'modern_blogger_button_options',
		'type'=> 'number',
		'active_callback' => 'modern_blogger_button_enabled'
	));

	$wp_customize->add_setting('modern_blogger_left_button_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_left_button_padding',array(
		'label'	=> __('Left','modern-blogger'),
		'input_attrs' => array(
      	'step'             => 1,
			'min'              => 0,
			'max'              => 50,
     	),
		'section'=> 'modern_blogger_button_options',
		'type'=> 'number',
		'active_callback' => 'modern_blogger_button_enabled'
	));

	$wp_customize->add_setting('modern_blogger_right_button_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_right_button_padding',array(
		'label'	=> __('Right','modern-blogger'),
		'input_attrs' => array(
         'step'             => 1,
			'min'              => 0,
			'max'              => 50,
 	 	),
		'section'=> 'modern_blogger_button_options',
		'type'=> 'number',
		'active_callback' => 'modern_blogger_button_enabled'
	));

	$wp_customize->add_setting( 'modern_blogger_button_border_radius', array(
		'default'=> 0,
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_button_border_radius', array(
      'label'  => __('Border Radius','modern-blogger'),
      'section'  => 'modern_blogger_button_options',
      'description' => __('Measurement is in pixel.','modern-blogger'),
      'input_attrs' => array(
          'min' => 0,
          'max' => 50,
      ),
		'active_callback' => 'modern_blogger_button_enabled'
 	)));

    //Sidebar setting
	$wp_customize->add_section( 'modern_blogger_sidebar_options', array(
    	'title'   => __( 'Sidebar options', 'modern-blogger'),
		'priority'   => null,
		'panel' => 'modern_blogger_panel_id'
	) );

	$wp_customize->add_setting('modern_blogger_single_page_layout',array(
		'default' => 'One Column',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
 	));
	$wp_customize->add_control('modern_blogger_single_page_layout', array(
		'type' => 'select',
		'label' => __( 'Single Page Layout', 'modern-blogger' ),
		'section' => 'modern_blogger_sidebar_options',
		'choices' => array(
		   'Left Sidebar' => __('Left Sidebar','modern-blogger'),
		   'Right Sidebar' => __('Right Sidebar','modern-blogger'),
		   'One Column' => __('One Column','modern-blogger')
		),
 	));

 	$wp_customize->add_setting('modern_blogger_single_post_layout',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
 	));
	$wp_customize->add_control('modern_blogger_single_post_layout', array(
		'type' => 'select',
		'label' => __( 'Single Post Layout', 'modern-blogger' ),
		'section' => 'modern_blogger_sidebar_options',
		'choices' => array(
		   'Left Sidebar' => __('Left Sidebar','modern-blogger'),
		   'Right Sidebar' => __('Right Sidebar','modern-blogger'),
		   'One Column' => __('One Column','modern-blogger')
		),
 	));

    //Advance Options
	$wp_customize->add_section( 'modern_blogger_advance_options', array(
    	'title' => __( 'Advance Options', 'modern-blogger' ),
		'priority'   => null,
		'panel' => 'modern_blogger_panel_id'
	) );

	$wp_customize->add_setting('modern_blogger_preloader',array(
		'default' => false,
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_preloader',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Preloader','modern-blogger'),
		'section' => 'modern_blogger_advance_options'
	));

 	$wp_customize->add_setting( 'modern_blogger_preloader_color', array(
		'default' => '#101216',
		'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_preloader_color', array(
  		'label' => __('Preloader Color', 'modern-blogger'),
		'section' => 'modern_blogger_advance_options',
		'settings' => 'modern_blogger_preloader_color',
  	)));

  	$wp_customize->add_setting( 'modern_blogger_preloader_bg_color', array(
		'default' => '#f72e1c',
		'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'modern_blogger_preloader_bg_color', array(
  		'label' => __('Preloader Background Color', 'modern-blogger'),
		'section' => 'modern_blogger_advance_options',
		'settings' => 'modern_blogger_preloader_bg_color',
  	)));

  	$wp_customize->add_setting('modern_blogger_preloader_type',array(
		'default' => 'Square',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_preloader_type',array(
		'type' => 'radio',
		'label' => __('Preloader Type','modern-blogger'),
		'section' => 'modern_blogger_advance_options',
		'choices' => array(
		   'Square' => __('Square','modern-blogger'),
		   'Circle' => __('Circle','modern-blogger'),
		)
	) );

	$wp_customize->add_setting('modern_blogger_theme_layout_options',array(
		'default' => 'Default Theme',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_theme_layout_options',array(
		'type' => 'radio',
		'label' => __('Theme Layout','modern-blogger'),
		'section' => 'modern_blogger_advance_options',
		'choices' => array(
		   'Default Theme' => __('Default Theme','modern-blogger'),
		   'Container Theme' => __('Container Theme','modern-blogger'),
		   'Box Container Theme' => __('Box Container Theme','modern-blogger'),
		),
	) );

	//404 Page Option
	$wp_customize->add_section('modern_blogger_404_settings',array(
		'title'	=> __('404 Page & Search Result Settings','modern-blogger'),
		'priority'	=> null,
		'panel' => 'modern_blogger_panel_id',
	));

	$wp_customize->add_setting('modern_blogger_404_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('modern_blogger_404_title',array(
		'label'	=> __('404 Title','modern-blogger'),
		'section'	=> 'modern_blogger_404_settings',
		'type'		=> 'text'
	));	

	$wp_customize->add_setting('modern_blogger_404_button_label',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('modern_blogger_404_button_label',array(
		'label'	=> __('404 button Label','modern-blogger'),
		'section'	=> 'modern_blogger_404_settings',
		'type'		=> 'text'
	));	

	$wp_customize->add_setting('modern_blogger_search_result_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('modern_blogger_search_result_title',array(
		'label'	=> __('No Search Result Title','modern-blogger'),
		'section'	=> 'modern_blogger_404_settings',
		'type'		=> 'text'
	));	

	$wp_customize->add_setting('modern_blogger_search_result_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('modern_blogger_search_result_text',array(
		'label'	=> __('No Search Result Text','modern-blogger'),
		'section'	=> 'modern_blogger_404_settings',
		'type'		=> 'text'
	));	

	//Responsive Settings
	$wp_customize->add_section('modern_blogger_responsive_options',array(
		'title'	=> __('Responsive Options','modern-blogger'),
		'panel' => 'modern_blogger_panel_id'
	));

	$wp_customize->add_setting('modern_blogger_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Modern_Blogger_Icon_Selector(
     	$wp_customize,'modern_blogger_menu_open_icon',array(
		'label'	=> __('Menu Open Icon','modern-blogger'),
		'section' => 'modern_blogger_responsive_options',
		'type'	  => 'icon',
	)));

	$wp_customize->add_setting('modern_blogger_mobile_menu_label',array(
		'default' => __('Menu','modern-blogger'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_mobile_menu_label',array(
		'type' => 'text',
		'label' => __('Mobile Menu Label','modern-blogger'),
		'section' => 'modern_blogger_responsive_options'
	));

	$wp_customize->add_setting('modern_blogger_menu_close_icon',array(
		'default'	=> 'fas fa-times-circle',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Modern_Blogger_Icon_Selector(
     	$wp_customize,'modern_blogger_menu_close_icon',array(
		'label'	=> __('Menu Close Icon','modern-blogger'),
		'section' => 'modern_blogger_responsive_options',
		'type'	  => 'icon',
	)));

	$wp_customize->add_setting('modern_blogger_close_menu_label',array(
		'default' => __('Close Menu','modern-blogger'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('modern_blogger_close_menu_label',array(
		'type' => 'text',
		'label' => __('Close Menu Label','modern-blogger'),
		'section' => 'modern_blogger_responsive_options'
	));

	$wp_customize->add_setting('modern_blogger_hide_topbar_responsive',array(
		'default' => true,
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_hide_topbar_responsive',array(
     	'type' => 'checkbox',
		'label' => __('Enable Top Header','modern-blogger'),
		'section' => 'modern_blogger_responsive_options',
	));

	$wp_customize->add_setting('modern_blogger_slider_button_responsive',array(
        'default' => true,
        'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_slider_button_responsive',array(
     	'type' => 'checkbox',
      	'label' => __('Enable Slider Button','modern-blogger'),
      	'section' => 'modern_blogger_responsive_options',
	));

	$wp_customize->add_setting('modern_blogger_preloader_responsive',array(
        'default' => false,
        'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_preloader_responsive',array(
     	'type' => 'checkbox',
      	'label' => __('Enable Preloader','modern-blogger'),
      	'section' => 'modern_blogger_responsive_options',
	));

	$wp_customize->add_setting('modern_blogger_backtotop_responsive',array(
        'default' => true,
        'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_backtotop_responsive',array(
     	'type' => 'checkbox',
      	'label' => __('Enable Back to Top','modern-blogger'),
      	'section' => 'modern_blogger_responsive_options',
	));

	//Woocommerce Options
	$wp_customize->add_section('modern_blogger_woocommerce',array(
		'title'	=> __('WooCommerce Options','modern-blogger'),
		'panel' => 'modern_blogger_panel_id',
	));

	$wp_customize->add_setting('modern_blogger_shop_page_sidebar',array(
		'default' => true,
		'sanitize_callback' => 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_shop_page_sidebar',array(
		'type' => 'checkbox',
		'label' => __('Enable Shop Page Sidebar','modern-blogger'),
		'section' => 'modern_blogger_woocommerce'
	));

	$wp_customize->add_setting('modern_blogger_shop_page_navigation',array(
		'default' => true,
		'sanitize_callback' => 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_shop_page_navigation',array(
		'type' => 'checkbox',
		'label' => __('Enable Shop Page Pagination','modern-blogger'),
		'section' => 'modern_blogger_woocommerce'
	));

	$wp_customize->add_setting('modern_blogger_single_product_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_product_sidebar',array(
		'type' => 'checkbox',
		'label' => __('Enable Single Product Page Sidebar','modern-blogger'),
		'section' => 'modern_blogger_woocommerce'
	));

	$wp_customize->add_setting('modern_blogger_single_related_products',array(
		'default' => true,
		'sanitize_callback' => 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_single_related_products',array(
		'type' => 'checkbox',
		'label' => __('Enable Related Products','modern-blogger'),
		'section' => 'modern_blogger_woocommerce'
	));

 	$wp_customize->add_setting('modern_blogger_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_products_per_page',array(
		'label'	=> __('Products Per Page','modern-blogger'),
		'input_attrs' => array(
         'step'             => 1,
			'min'              => 0,
			'max'              => 50,
     	),
		'section'=> 'modern_blogger_woocommerce',
		'type'=> 'number',
	));

	$wp_customize->add_setting('modern_blogger_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_products_per_row',array(
		'label'	=> __('Products Per Row','modern-blogger'),
		'choices' => array(
         '2' => '2',
			'3' => '3',
			'4' => '4',
     	),
		'section'=> 'modern_blogger_woocommerce',
		'type'=> 'select',
	));

	$wp_customize->add_setting('modern_blogger_product_border',array(
		'default' => true,
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_product_border',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide product border','modern-blogger'),
		'section' => 'modern_blogger_woocommerce',
	));

 	$wp_customize->add_setting('modern_blogger_product_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('modern_blogger_product_padding',array(
		'label'	=> esc_html__('Product Padding','modern-blogger'),
		'section'=> 'modern_blogger_woocommerce',
	));

	$wp_customize->add_setting( 'modern_blogger_product_top_padding',array(
		'default' => 10,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_top_padding', array(
		'label' => esc_html__( 'Top','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => -1,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_bottom_padding',array(
		'default' => 10,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_bottom_padding', array(
		'label' => esc_html__( 'Bottom','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => -1,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_left_padding',array(
		'default' => 10,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_left_padding', array(
		'label' => esc_html__( 'Left','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => -1,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'modern_blogger_product_right_padding',array(
		'default' => 10,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_right_padding', array(
		'label' => esc_html__( 'Right','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => -1,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'modern_blogger_product_border_radius',array(
		'default' => '0',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_product_border_radius', array(
		'label'  => __('Product Border Radius','modern-blogger'),
		'section'  => 'modern_blogger_woocommerce',
		'description' => __('Measurement is in pixel.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 50,
		)
    )));

	$wp_customize->add_setting('modern_blogger_product_button_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('modern_blogger_product_button_padding',array(
		'label'	=> esc_html__('Product Button Padding','modern-blogger'),
		'section'=> 'modern_blogger_woocommerce',
	));

	$wp_customize->add_setting( 'modern_blogger_product_button_top_padding',array(
		'default' => 10,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_button_top_padding', array(
		'label' => esc_html__( 'Top','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_button_bottom_padding',array(
		'default' => 10,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_button_bottom_padding', array(
		'label' => esc_html__( 'Bottom','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_button_left_padding',array(
		'default' => 12,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_button_left_padding', array(
		'label' => esc_html__( 'Left','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'modern_blogger_product_button_right_padding',array(
		'default' => 12,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_button_right_padding', array(
		'label' => esc_html__( 'Right','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'modern_blogger_product_button_border_radius',array(
		'default' => '0',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_product_button_border_radius', array(
		'label'  => __('Product Button Border Radius','modern-blogger'),
		'section'  => 'modern_blogger_woocommerce',
		'description' => __('Measurement is in pixel.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 50,
		)
 	)));

 	$wp_customize->add_setting('modern_blogger_product_sale_position',array(
     'default' => 'Right',
     'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_product_sale_position',array(
		'type' => 'radio',
		'label' => __('Product Sale Position','modern-blogger'),
		'section' => 'modern_blogger_woocommerce',
		'choices' => array(
		   'Left' => __('Left','modern-blogger'),
		   'Right' => __('Right','modern-blogger'),
		),
	) );

	$wp_customize->add_setting( 'modern_blogger_product_sale_font_size',array(
		'default' => '13',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_product_sale_font_size', array(
		'label'  => __('Product Sale Font Size','modern-blogger'),
		'section'  => 'modern_blogger_woocommerce',
		'description' => __('Measurement is in pixel.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 50,
		)
 	)));

 	$wp_customize->add_setting('modern_blogger_product_sale_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('modern_blogger_product_sale_padding',array(
		'label'	=> esc_html__('Product Sale Padding','modern-blogger'),
		'section'=> 'modern_blogger_woocommerce',
	));

	$wp_customize->add_setting( 'modern_blogger_product_sale_top_padding',array(
		'default' => 0,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_sale_top_padding', array(
		'label' => esc_html__( 'Top','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_sale_bottom_padding',array(
		'default' => 0,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_sale_bottom_padding', array(
		'label' => esc_html__( 'Bottom','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_sale_left_padding',array(
		'default' => 0,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_sale_left_padding', array(
		'label' => esc_html__( 'Left','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('modern_blogger_product_sale_right_padding',array(
		'default' => 0,
		'sanitize_callback' => 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_product_sale_right_padding', array(
		'label' => esc_html__( 'Right','modern-blogger' ),
		'type' => 'number',
		'section' => 'modern_blogger_woocommerce',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'modern_blogger_product_sale_border_radius',array(
		'default' => '0',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_product_sale_border_radius', array(
		'label'  => __('Product Sale Border Radius','modern-blogger'),
		'section'  => 'modern_blogger_woocommerce',
		'description' => __('Measurement is in pixel.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 50,
		)
    )));

	//footer text
	$wp_customize->add_section('modern_blogger_footer_section',array(
		'title'	=> __('Footer Section','modern-blogger'),
		'panel' => 'modern_blogger_panel_id'
	));

	$wp_customize->add_setting('modern_blogger_hide_scroll',array(
		'default' => 'true',
		'sanitize_callback'	=> 'modern_blogger_sanitize_checkbox'
	));
	$wp_customize->add_control('modern_blogger_hide_scroll',array(
     	'type' => 'checkbox',
   	'label' => __('Show / Hide Back To Top','modern-blogger'),
   	'section' => 'modern_blogger_footer_section',
	));

	$wp_customize->add_setting('modern_blogger_back_to_top',array(
		'default' => 'Right',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_back_to_top',array(
		'type' => 'radio',
		'label' => __('Back to Top Alignment','modern-blogger'),
		'section' => 'modern_blogger_footer_section',
		'choices' => array(
		   'Left' => __('Left','modern-blogger'),
		   'Right' => __('Right','modern-blogger'),
		   'Center' => __('Center','modern-blogger'),
		),
	) );

	$wp_customize->add_setting('modern_blogger_footer_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'modern_blogger_footer_bg_color', array(
		'label'    => __('Footer Background Color', 'modern-blogger'),
		'section'  => 'modern_blogger_footer_section',
	)));

	$wp_customize->add_setting('modern_blogger_footer_bg_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'modern_blogger_footer_bg_image',array(
		'label' => __('Footer Background Image','modern-blogger'),
		'section' => 'modern_blogger_footer_section'
	)));

	$wp_customize->add_setting('modern_blogger_footer_widget',array(
		'default'           => '4',
		'sanitize_callback' => 'modern_blogger_sanitize_choices',
	));
	$wp_customize->add_control('modern_blogger_footer_widget',array(
		'type'        => 'radio',
		'label'       => __('No. of Footer columns', 'modern-blogger'),
		'section'     => 'modern_blogger_footer_section',
		'description' => __('Select the number of footer columns and add your widgets in the footer.', 'modern-blogger'),
		'choices' => array(
		   '1'   => __('One column', 'modern-blogger'),
		   '2'  => __('Two columns', 'modern-blogger'),
		   '3' => __('Three columns', 'modern-blogger'),
		   '4' => __('Four columns', 'modern-blogger')
		),
	)); 

	$wp_customize->add_setting('modern_blogger_copyright_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'modern_blogger_copyright_bg_color', array(
		'label'    => __('Copyright Background Color', 'modern-blogger'),
		'section'  => 'modern_blogger_footer_section',
	)));

 	$wp_customize->add_setting('modern_blogger_copyright_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('modern_blogger_copyright_padding',array(
		'label'	=> esc_html__('Copyright Padding','modern-blogger'),
		'section'=> 'modern_blogger_footer_section',
	));

    $wp_customize->add_setting('modern_blogger_top_copyright_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_top_copyright_padding',array(
		'description'	=> __('Top','modern-blogger'),
		'input_attrs' => array(
         'step' => 1,
			'min' => 0,
			'max' => 50,
     	),
		'section'=> 'modern_blogger_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting('modern_blogger_bottom_copyright_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'modern_blogger_sanitize_float'
	));
	$wp_customize->add_control('modern_blogger_bottom_copyright_padding',array(
		'description'	=> __('Bottom','modern-blogger'),
		'input_attrs' => array(
         'step' => 1,
			'min' => 0,
			'max' => 50,
     	),
		'section'=> 'modern_blogger_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting('modern_blogger_copyright_alignment',array(
		'default' => 'center',
		'sanitize_callback' => 'modern_blogger_sanitize_choices'
	));
	$wp_customize->add_control('modern_blogger_copyright_alignment',array(
		'type' => 'radio',
		'label' => __('Copyright Alignment','modern-blogger'),
		'section' => 'modern_blogger_footer_section',
		'choices' => array(
		   'left' => __('Left','modern-blogger'),
		   'right' => __('Right','modern-blogger'),
		   'center' => __('Center','modern-blogger'),
		),
	) );

	$wp_customize->add_setting( 'modern_blogger_copyright_font_size', array(
		'default'=> '15',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new Modern_Blogger_WP_Customize_Range_Control( $wp_customize, 'modern_blogger_copyright_font_size', array(
		'label'  => __('Copyright Font Size','modern-blogger'),
		'section'  => 'modern_blogger_footer_section',
		'description' => __('Measurement is in pixel.','modern-blogger'),
		'input_attrs' => array(
		   'min' => 0,
		   'max' => 50,
		)
 	)));
	
	$wp_customize->add_setting('modern_blogger_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('modern_blogger_text',array(
		'label'	=> __('Copyright Text','modern-blogger'),
		'description'	=> __('Add some text for footer like copyright etc.','modern-blogger'),
		'section'	=> 'modern_blogger_footer_section',
		'type'		=> 'text'
	));	
}
add_action( 'customize_register', 'modern_blogger_customize_register' );	

load_template( ABSPATH . 'wp-includes/class-wp-customize-control.php' );

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

class Modern_Blogger_Image_Radio_Control extends WP_Customize_Control {

    public function render_content() {
 
        if (empty($this->choices))
            return;
 
        $name = '_customize-radio-' . $this->id;
        ?>
        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
        <ul class="controls" id='modern-blogger-img-container'>
            <?php
            foreach ($this->choices as $value => $label) :
                $class = ($this->value() == $value) ? 'modern-blogger-radio-img-selected modern-blogger-radio-img-img' : 'modern-blogger-radio-img-img';
                ?>
                <li style="display: inline;">
                    <label>
                        <input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr($value); ?>" name="<?php echo esc_attr($name); ?>" <?php
                          	$this->link();
                          	checked($this->value(), $value);
                          	?> />
                        <img role="img" src='<?php echo esc_url($label); ?>' class='<?php echo esc_attr($class); ?>' />
                    </label>
                </li>
                <?php
            endforeach;
            ?>
        </ul>
        <?php
    } 
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Modern_Blogger_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Modern_Blogger_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Modern_Blogger_Customize_Section_Pro(
			$manager,
			'modern_blogger_pro_link',
				array(
					'priority'   => 9,
					'title'    => esc_html__( 'Modern Blogger Pro', 'modern-blogger' ),
					'pro_text' => esc_html__( 'Go Pro', 'modern-blogger' ),
					'pro_url'  => esc_url('https://www.themesglance.com/themes/blogger-wordpress-theme/')
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'modern-blogger-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'modern-blogger-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Modern_Blogger_Customize::get_instance();