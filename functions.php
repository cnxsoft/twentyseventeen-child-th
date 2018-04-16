<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/* JLA - Set excerpts length to 160 words */
function custom_excerpt_length( $length ) {
	return 160;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
 
  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/default.jpg";
  }
  return $first_img;
}

add_filter('document_title_parts', 'dq_override_post_title', 10);
function dq_override_post_title($title){
   // change title for singular blog post
    if( is_singular( 'post' ) ){
        $title['site'] = ''; //optional
    } else {
        $title['tagline'] = '';
    }
    return $title;
}

/* Add nofollow to Continue reading link */
function twentyseventeen_excerpt_more_child( $link ) {
        if ( is_admin() ) {
                return $link;
        }

        $link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link" rel="nofollow">%2$s</a></p>',
                esc_url( get_permalink( get_the_ID() ) ),
                /* translators: %s: Name of current post */
                sprintf( __( 'Continue reading...<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
        );
        return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more_child', 999);
?>
