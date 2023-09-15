<?php
/**
 * Template Name: Custom home page
 */
get_header(); ?>

<main id="maincontent" role="main">
 <?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<!-- slider section --> 
<section id="slider-section" class=""> 
  <div class="owl-carousel">
    <?php $modern_blogger_catData=  get_theme_mod('modern_blogger_slider_category');
      if($modern_blogger_catData){
      $page_query = new WP_Query(array( 'category_name' => esc_html( $modern_blogger_catData ,'modern-blogger')));?>
        <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
          <div class="slider-box">
            <?php the_post_thumbnail(); ?>
            <div class="slider-content">
              <div class="inner-content">
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><span class="entry-author"> <?php the_author(); ?></span><span class="screen-reader-text"><?php the_author(); ?></span>
                </a>
                <span class="seperator px-2"><?php echo esc_html(get_theme_mod('modern_blogger_meta_field_separator_slider', '.'));?></span>
                <a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><span class="entry-date"><?php echo esc_html( get_the_date() ); ?></span><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span>
                </a>
                <span class="seperator px-2"><?php echo esc_html(get_theme_mod('modern_blogger_meta_field_separator_slider', '.'));?></span> 
                  <i class="fas fa-thumbs-up" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','modern-blogger'), __('0 Comments','modern-blogger'), __('% Comments','modern-blogger') ); ?></span> 
              </div>
              <h1 class="pt-0"><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a>
              </h1>
              <p class=""><?php $excerpt = get_the_excerpt(); echo esc_html( modern_blogger_string_limit_words( $excerpt, 20)); ?>
              </p>
              <a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html('Read More','modern-blogger'); ?><i class="fas fa-arrow-right ms-1"></i><span class="screen-reader-text"><?php echo esc_html('Read More','modern-blogger'); ?></span>
              </a>
            </div>
          </div>
        <?php endwhile;
        wp_reset_postdata();
      } 
    ?>
  </div>
</section>

<!-- Services section -->
<section id="category-section" class="mt-lg-5 mt-md-5 mt-4"> 
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12 position-relative">
        <?php
        $modern_blogger_postData1 = get_theme_mod('modern_blogger_services_section_setting');
        if($modern_blogger_postData1){
          $args = array( 'name' => esc_html($modern_blogger_postData1 ,'modern-blogger'));
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post(); ?>
              <div class="abt-image w-100">
                <?php the_post_thumbnail(); ?>
              </div>
              <div class="mid-content">
                <?php if( get_theme_mod( 'modern_blogger_metafields_date',true) != '') { ?>
                  <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><span class="entry-author"> <?php the_author(); ?></span><span class="screen-reader-text"><?php the_author(); ?></span>
                  </a>
                  <span class="seperator px-2"><?php echo esc_html(get_theme_mod('modern_blogger_meta_field_separator_service', '.'));?></span><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><span class="entry-date"><?php echo esc_html( get_the_date() ); ?></span><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a>
                <?php }?>
                <span class="seperator px-2"><?php echo esc_html(get_theme_mod('modern_blogger_meta_field_separator_service', '.'));?></span> 
                <i class="fas fa-thumbs-up" aria-hidden="true"></i><span class="entry-comments pe-3"> <?php comments_number( __('0 Comments','modern-blogger'), __('0 Comments','modern-blogger'), __('% Comments','modern-blogger') ); ?></span> 
              </div>
              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></h2>     
              <p class=""><?php $excerpt = get_the_excerpt(); echo esc_html( modern_blogger_string_limit_words( $excerpt, 25)); ?></p>
              <a href="<?php the_permalink(); ?>" class="read-full-text"><?php echo esc_html('READ FULL STORY','modern-blogger'); ?><span class="screen-reader-text"><?php echo esc_html('READ FULL STORY','modern-blogger'); ?></span></a>
            <?php endwhile; 
            wp_reset_postdata();?>
          <?php else : ?>
            <div class="no-postfound"></div>
          <?php
        endif; }?>
      </div>

  <!-- post middle -->
      <div class="col-lg-4 col-md-8 mt-lg-0 mt-md-3 mt-3">
        <?php 
          $modern_blogger_catData=  get_theme_mod('modern_blogger_category1');
          if($modern_blogger_catData){
          $page_query = new WP_Query(array( 'category_name' => esc_html($modern_blogger_catData,'modern-blogger')));?>
          <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
          <div class="middle-part position-relative">
            <div class="abt-img-box w-100 "><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></div>
            <div class="post-middle-content">
              <?php if( get_theme_mod( 'modern_blogger_metafields_date',true) != '') { ?>
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><span class="entry-author"> <?php the_author(); ?></span><span class="screen-reader-text"><?php the_author(); ?></span></a>
                <span class="seperator px-1"><?php echo esc_html(get_theme_mod('modern_blogger_meta_field_separator_service', '.'));?></span> <a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><span class="entry-date"><?php echo esc_html( get_the_date() ); ?></span><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a>
                  <?php }?>
                <span class="seperator px-1"><?php echo esc_html(get_theme_mod('modern_blogger_meta_field_separator_service', '.'));?></span> 
                <i class="fas fa-thumbs-up" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','modern-blogger'), __('0 Comments','modern-blogger'), __('% Comments','modern-blogger') ); ?></span>
            </div>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a>
            </h2>         
            <a href="<?php the_permalink(); ?>" class="read-full-text"><?php echo esc_html('READ FULL STORY','modern-blogger'); ?><span class="screen-reader-text"><?php echo esc_html('READ FULL STORY','modern-blogger'); ?></span></a>
            <div class="clearfix"></div>
          </div>
          <?php endwhile;
          wp_reset_postdata();   
          }        
        ?>  
      </div>
      
  <!-- select last post -->
      <div class="col-lg-2 col-md-4 mt-lg-0 mt-md-3 mb-4">
        <?php
          $modern_blogger_postData1 = get_theme_mod('modern_blogger_add_post');
          if($modern_blogger_postData1){
            $args = array( 'name' => esc_html($modern_blogger_postData1 ,'modern-blogger'));
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="last-post">
                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a>
                  </h2> 
                  <div class="add-post position-relative">
                    <?php the_post_thumbnail(); ?>         
                  </div>    
                  <a href="<?php the_permalink(); ?>" class="read-full"><?php echo esc_html('READ FULL','modern-blogger'); ?><span class="screen-reader-text"><?php echo esc_html('READ FULL','modern-blogger'); ?></span></a> 
                </div>
              <?php endwhile; 
              wp_reset_postdata();?>
            <?php else : ?>
              <div class="no-postfound"></div>
            <?php
          endif; }?>
      </div>
    </div>
  </div>
</section>
<?php do_action('modern_blogger_after_category_section'); ?>

  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <div class="entry-content"><?php the_content(); ?></div>
    <?php endwhile; // end of the loop. ?>
  </div>
</main>

<?php get_footer(); ?>