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

/* JLA - Set excerpts length to 720 characters? */
function custom_excerpt_length( $length ) {
	return 720;
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
/* Remove Continue reading link */
function twentyseventeen_excerpt_more_child( $link ) {
        return ' [...]';
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more_child', 999);

/* Add nofollow to link to comments */
function add_nofollow_to_comments_popup_link () {
	return 'rel="nofollow"';
}
add_filter ( 'comments_popup_link_attributes', 'add_nofollow_to_comments_popup_link' ); 

/* Disable BIG image scaling introduced in WP 5.3 */
add_filter( 'big_image_size_threshold', '__return_false' );


/* Enable shortcodes in widgets */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);
?>
