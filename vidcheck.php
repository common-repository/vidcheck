<?php
/*
  Plugin Name: VidCheck
  Description: VidCheck is a web platform that makes video fact-checking more standardized for fact-checkers, easy to read and understand for audiences, and scalable for platforms & fact-checkers. VidCheck can be used in cases where claims being fact-checked are part of the video such as political speeches, news content, documentaries, any other type of commentary, manipulated content, etc.
  Version: 1.0
  Author: Factly
  Plugin URI: https://factly.in/
*/
//creating database
global $jal_db_version;
$jal_db_version = '1.0';

function vid_jal_install()
{
    global $wpdb;
    global $jal_db_version;
    $table_name1 = $wpdb->prefix . 'vidcheck_ratings ';
    $table_name2 = $wpdb->prefix . 'vidcheck_claimant ';
    $table_name3 = $wpdb->prefix . 'vidcheck_video ';
    $table_name4 = $wpdb->prefix . 'vidcheck_claim ';
    $table_name5 = $wpdb->prefix . 'posts ';

    $charset_collate = $wpdb->get_charset_collate();

    $sql1 = "CREATE TABLE $table_name1 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name longtext NOT NULL,
		slug text NOT NULL,
		description text NOT NULL,
		numericvalue bigint(12), 
        color text NOT NULL,
        bg_color text NOT NULL,
        fe_image text NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

    $sql2 = "CREATE TABLE $table_name2 (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name longtext NOT NULL,
            slug text NOT NULL,
            description text NOT NULL,
            tagline text NOT NULL,
            imageName text NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

    $sql3 = "CREATE TABLE $table_name3 (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title longtext NOT NULL,
    url text NOT NULL,
    summary text NOT NULL,
    claim_sources text,
    status text NULL,
    post_id bigint(12),
    total_duration bigint(12),
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY  (id)
) $charset_collate;";

    $sql4 = "CREATE TABLE $table_name4 (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    fact longtext NOT NULL,
    claim longtext,
    start_time longtext,
    end_time longtext,
    claimant_id bigint(12),
    rating_id bigint(12),
    review_sources text,
    description text,
    is_claim text,
    video_id bigint(12),
    vid_check_id bigint(12),
    claim_date date,
    checked_date date,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY  (id)
) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql1);
    dbDelta($sql2);
    dbDelta($sql3);
    dbDelta($sql4);
    //dbDelta($sql5);

    add_option('jal_db_version', $jal_db_version);
}
register_activation_hook(__FILE__, 'vid_jal_install');

//adding in menu


//User Role Premissions 
$administrator = get_role('administrator');
$editor = get_role('editor');
$editor->add_cap('vidcheck_access_levels');
$author = get_role('author');
$author->add_cap('vidcheck_access_levels');
$administrator->add_cap('vidcheck_access_levels');

function vid_at_try_menu()
{
    //adding plugin in menu
    add_menu_page('VidCheck List', //page title
    'VidCheck', //menu title
    'vidcheck_access_levels', //capabilities
    'vidchecks-list', //menu slug
    'vidchecks'
    //function
    );
    add_submenu_page(null, //parent page slug
    'claim_delete', //$page_title
    'Claim Delete', // $menu_title
    'vidcheck_access_levels', // $capability
    'claim_delete', // $menu_slug,
    'vid_claim_delete'
    // $function
    );
    //adding submenu to a menu
    add_submenu_page('vidchecks-list', //parent page slug
    'rating_list', //page title
    'Ratings', //menu titel
    'vidcheck_access_levels', //manage optios
    'rating_list', //slug
    'vid_rating_list'
    //function
    );
    


//    adding submenu to a menu
    add_submenu_page('vidchecks-list',
    'claimant_list', //page title
    'Claimants', //menu titel
    'vidcheck_access_levels', //manage optios
    'Claimant_List', //slug
    'vid_claimant_list'
    //function
    );
    add_submenu_page(null, //parent page slug
    'rating_update', //$page_title
    'Rating Update', // $menu_title
    'vidcheck_access_levels', // $capability
    'Rating_Update', // $menu_slug,
    'vid_rating_update'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'rating_delete', //$page_title
    'Rating Delete', // $menu_title
    'vidcheck_access_levels', // $capability
    'Rating_Delete', // $menu_slug,
    'vid_rating_delete'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'rating_view', //$page_title
    'Rating View', // $menu_title
    'vidcheck_access_levels', // $capability
    'Rating_View', // $menu_slug,
    'vid_rating_view'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'Add New VidCheck', //$page_title
    'Add New', // $menu_title
    'vidcheck_access_levels', // $capability
    'add-new-vidcheck', // $menu_slug,
    'vid_vidcheck_add'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'claimant_update', //$page_title
    'Claimant Update', // $menu_title
    'vidcheck_access_levels', // $capability
    'Claimant_Update', // $menu_slug,
    'vid_claimant_update'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'claimant_view', //$page_title
    'Claimant View', // $menu_title
    'vidcheck_access_levels', // $capability
    'Claimant_View', // $menu_slug,
    'vid_claimant_view'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'claimant_delete', //$page_title
    'Claimant Delete', // $menu_title
    'vidcheck_access_levels', // $capability
    'Claimant_Delete', // $menu_slug,
    'vid_claimant_delete'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'vidcheck_delete', //$page_title
    'Vidcheck Delete', // $menu_title
    'vidcheck_access_levels', // $capability
    'Vidcheck_Delete', // $menu_slug,
    'vid_vidcheck_delete'
    // $function
    );
    // add_submenu_page(null, //parent page slug
    // 'vidcheck_update', //$page_title
    // 'Vidcheck Update', // $menu_title
    // 'vidcheck_access_levels', // $capability
    // 'Vidcheck_Update', // $menu_slug,
    // 'vidcheck_update'
    // // $function
    // );
    add_submenu_page(null, //parent page slug
    'add_new_claim', //$page_title
    'Add_Claim', // $menu_title
    'vidcheck_access_levels', // $capability
    'add_new_claim', // $menu_slug,
    'vid_add_new_claim'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'edit_new_claim', //$page_title
    'edit_Claim', // $menu_title
    'vidcheck_access_levels', // $capability
    'edit_new_claim', // $menu_slug,
    'vid_edit_new_claim'
    // $function
    );
    add_submenu_page(null, //parent page slug
    'update_claim', //$page_title
    'update_Claim', // $menu_title
    'vidcheck_access_levels', // $capability
    'update_claim', // $menu_slug,
    'vid_update_claim'
    // $function
    );

    add_submenu_page(null, //parent page slug
    'no_access_vid', //$page_title
    'no_access_vid', // $menu_title
    'vidcheck_access_levels', // $capability
    'VidCheck_NoAccess', // $menu_slug,
    'vid_no_access_vid'
    // $function
    );
   
}



function vid_all_vidchecks_details()
{
    include_once (Vid_check_ROOTDIR . 'all-vidchecks.php');
}



function vid_VidchechWithParams($params)
{
    include_once (Vid_check_ROOTDIR . 'single-vidcheck.php');

}



function vid_create_vidcheck_types()
{
    register_post_type('vid_check', array(
        'labels' => array(
            'name' => __('Vid Checks') ,
            'singular_name' => __('Vid Check')
        ) ,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'vid_check'
        ) ,
        // 'show_in_rest' => true,
        'show_in_menu' => false,
    ));
}


function vid_add_my_post_types_to_query($query)
{
    if (is_home() && $query->is_main_query()) $query->set('post_type', array(
        'post',
        'vid_check'
    ));
    return $query;
}

function vid_custom_post_type()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Movies', 'Post Type General Name', 'twentytwenty') ,
        'singular_name' => _x('Movie', 'Post Type Singular Name', 'twentytwenty') ,
        'menu_name' => __('Movies', 'twentytwenty') ,
        'parent_item_colon' => __('Parent Movie', 'twentytwenty') ,
        'all_items' => __('All Movies', 'twentytwenty') ,
        'view_item' => __('View Movie', 'twentytwenty') ,
        'add_new_item' => __('Add New Movie', 'twentytwenty') ,
        'add_new' => __('Add New', 'twentytwenty') ,
        'edit_item' => __('Edit Movie', 'twentytwenty') ,
        'update_item' => __('Update Movie', 'twentytwenty') ,
        'search_items' => __('Search Movie', 'twentytwenty') ,
        'not_found' => __('Not Found', 'twentytwenty') ,
        'not_found_in_trash' => __('Not found in Trash', 'twentytwenty') ,
    );

    // Set other options for Custom Post Type
    $args = array(
        'label' => __('movies', 'twentytwenty') ,
        'description' => __('Movie news and reviews', 'twentytwenty') ,
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
        ) ,
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies' => array(
            'genres'
        ) ,
        /* A hierarchical CPT is like Pages and can have
         * Parent and child items. A non-hierarchical CPT
         * is like Posts.
        */
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
    );
    // Registering your Custom Post Type
    register_post_type('movies', $args);

}

/* Hook into the 'init' action so that the function
 * Containing our post type registration is not
 * unnecessarily executed.
*/



// returns the root directory path of particular plugin
define('Vid_check_ROOTDIR', plugin_dir_path(__FILE__));
//Vidcheck CRUD

require_once (Vid_check_ROOTDIR . 'vidchecks/vidchecks.php');
require_once (Vid_check_ROOTDIR . 'vidchecks/edit_new_claim.php');
require_once (Vid_check_ROOTDIR . 'vidchecks/add_new_claim.php');
require_once (Vid_check_ROOTDIR . 'vidchecks/claim_delete.php');

//Ratings CRUD
require_once (Vid_check_ROOTDIR . 'ratings/rating_list.php');
require_once (Vid_check_ROOTDIR . 'ratings/rating_update.php');
require_once (Vid_check_ROOTDIR . 'ratings/rating_delete.php');
require_once (Vid_check_ROOTDIR . 'ratings/rating_view.php');

//Claimant CRUD
require_once (Vid_check_ROOTDIR . 'claimant/claimant_list.php');
require_once (Vid_check_ROOTDIR . 'claimant/claimant_update.php');
require_once (Vid_check_ROOTDIR . 'claimant/claimant_delete.php');
require_once (Vid_check_ROOTDIR . 'claimant/claimant_view.php');
require_once (Vid_check_ROOTDIR . 'no_access_vid.php');
require_once (Vid_check_ROOTDIR . 'vidchecks-add.php');
require_once (Vid_check_ROOTDIR . 'vidcheck_delete.php');
require_once (Vid_check_ROOTDIR . 'update_claim.php');

add_action('admin_menu', 'vid_at_try_menu');
add_action('init', 'vid_create_vidcheck_types');
add_action('pre_get_posts', 'vid_add_my_post_types_to_query');
add_action('init', 'vid_custom_post_type', 0);
add_shortcode("all-vidchecks", "vid_all_vidchecks_details");
add_shortcode("single-vidchecks", 'vid_VidchechWithParams');


?>