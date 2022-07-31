<?php

/*
 * Plugin Name: CB Portfolio Work
 * Description: This plugin for slowing your recent/profolio work
 * Version: 1.0
 * Author: Md Abul Bashar
 * Author URI: https://www.facebook.com/hmbashar/
 * Text Domain: cbpw
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue scripts and styles.
 */
function cb_pwork_stylesheet_enque() {
    $cb_pwork_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'cb_pwork_stylesheet',  $cb_pwork_url . "/css/style.css");
}
add_action( 'wp_enqueue_scripts', 'cb_pwork_stylesheet_enque' );


function cb_pwork_general_function() {
	add_image_size( 'our-work', 400, 300, true );
}
add_action('after_setup_theme', 'cb_pwork_general_function');

// Register Custom Post Types

function cb_pwork_post_type() {
	register_post_type( 'our-works',
					   array(
						   'labels' => array(
							   'name' => __( 'Our Works' ),
							   'singular_name' => __( 'Our Work' ),
							   'add_new' => __( 'Add Work' ),
							   'add_new_item' => __( 'Add New  Work' ),
							   'edit_item' => __( 'Edit Work' ),
							   'new_item' => __( 'New Work' ),
							   'view_item' => __( 'View Our Works' ),
							   'not_found' => __( 'Sorry, we couldn\'t find the works you are looking for.' )
						   ),
						   'public' => true,
						   'publicly_queryable' => true,
						   'exclude_from_search' => false,
						   'menu_icon'		=> 'dashicons-portfolio',
						   'menu_position' => 14,
						   'has_archive' => false,
						   'hierarchical' => false,
						   'capability_type' => 'page',
						   'rewrite' => array( 'slug' => 'our-work' ),
						   'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail' )
					   )
					  );
}

add_action( 'init', 'cb_pwork_post_type' );


// Custom Taxonomy
function cb_pwork_custom_taxonomy() {

	register_taxonomy(
		'work_category',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		'our-works',                  //post type name
		array(
			'hierarchical'          => true,
			'label'                         => 'Work Category',  //Display name
			'query_var'             => true,
			'show_admin_column'             => true,
			'rewrite'                       => array(
				'slug'                  => 'work-cat', // This controls the base slug that will display before each term
				'with_front'    => true // Don't display the category base before
				)
			)
	);

}
add_action( 'init', 'cb_pwork_custom_taxonomy');



function cb_pwork_our_works_loop($atts, $content = NULL) {
   
	ob_start();
	?>
	<div class="cb_pwork-our-works-area">
		
		<?php 
			$our_works = new WP_Query(array(
				'post_type'	=> 'our-works', 
				'posts_per_page' => 8,
			));
									  
		if($our_works->have_posts()) : while($our_works->have_posts()) : $our_works->the_post();
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); // get thumbnail full size
	
	
		?>
		<!-- Single Our Work -->	
		
		<div class="cb_pwork-our-works">
			<div class="cb_pwork-our-work-thumb">
				<?php the_post_thumbnail('our-work');
				    the_excerpt();
				?>
			</div>
			<div class="cb_pwork-our-work-content">
				<div class="cb_pwork-our-work-icons">
					<a href="<?php the_permalink();?>"><i class="fas fa-link"></i></a>
					<a href="<?php echo esc_url($featured_img_url);?>"><i class="fas fa-search"></i></a>
				</div>
				<div class="cb_pwork-our-work-title">
					<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
					<p>
						<?php 
						  $cb_pwork_work_cats = get_the_terms(get_the_ID(), 'work_category');								

							if(is_array($cb_pwork_work_cats)) {
							  foreach ($cb_pwork_work_cats as $cb_pwork_cat) {
								 $work_cat_slug = get_term_link($cb_pwork_cat->slug, 'work_category');								 
								echo '<a href="'.esc_url($work_cat_slug).'">'.esc_html($cb_pwork_cat->name).'</a>';
							  }
							}
						?>
						
					</p>
				</div>
				
				
			</div>
		</div>		
		<!--/single our work-->
		<?php endwhile; endif; ?>
		
		
	</div>
	
	
	<?php
	return ob_get_clean();
}
add_shortcode('cb-pwork-our-works', 'cb_pwork_our_works_loop');


require_once( __DIR__ . '/elementor-addon/elementor-addon.php' );