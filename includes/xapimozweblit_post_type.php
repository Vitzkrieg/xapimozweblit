<?php



/*
|--------------------------------------------------------------------------
| CUSTOM POST TYPE FUNCTIONS
|--------------------------------------------------------------------------
*/


if ( ! function_exists('register_xapimozweblit_post_type') ) {

    // Register Custom Post Type
    function register_xapimozweblit_post_type() {

        $labels = array(
            'name'                => _x( 'xAPIMozWebLits', 'Post Type General Name', 'xAPIMozWebLit' ),
            'singular_name'       => _x( 'xAPIMozWebLit', 'Post Type Singular Name', 'xAPIMozWebLit' ),
            'menu_name'           => __( 'xAPIMozWebLit', 'xAPIMozWebLit' ),
            'parent_item_colon'   => __( 'Parent xAPIMozWebLit', 'xAPIMozWebLit' ),
            'all_items'           => __( 'All xAPIMozWebLit', 'xAPIMozWebLit' ),
            'view_item'           => __( 'View xAPIMozWebLit', 'xAPIMozWebLit' ),
            'add_new_item'        => __( 'Add New xAPIMozWebLit', 'xAPIMozWebLit' ),
            'add_new'             => __( 'New xAPIMozWebLit', 'xAPIMozWebLit' ),
            'edit_item'           => __( 'Edit xAPIMozWebLit', 'xAPIMozWebLit' ),
            'update_item'         => __( 'Update xAPIMozWebLit', 'xAPIMozWebLit' ),
            'search_items'        => __( 'Search xAPIMozWebLits', 'xAPIMozWebLit' ),
            'not_found'           => __( 'No xAPIMozWebLits found', 'xAPIMozWebLit' ),
            'not_found_in_trash'  => __( 'No xAPIMozWebLits found in Trash', 'xAPIMozWebLit' ),
        );
        $rewrite = array(
            'slug'                => 'xapimozweblit',
            'with_front'          => true,
            'pages'               => true,
            'feeds'               => true,
        );
        $capabilities = array(
            'edit_post'           => 'edit_xapimozweblit',
            'read_post'           => 'read_xapimozweblit',
            'delete_post'         => 'delete_xapimozweblit',
            'edit_posts'          => 'edit_xapimozweblits',
            'edit_others_posts'   => 'edit_others_xapimozweblits',
            'publish_posts'       => 'publish_xapimozweblits',
            'read_private_posts'  => 'read_private_xapimozweblits',
        );
        $args = array(
            'label'               => __( 'xapimozweblit', 'xapimozweblit' ),
            'description'         => __( 'xAPIMozWebLit Posts', 'xAPIMozWebLit' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'mozweblit' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => plugins_url('xapimozweblit/images/16px-WebLitStd-avatar.png', dirname(dirname(__FILE__))),
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => 'xapimozweblit',
            'rewrite'             => $rewrite,
            'capabilities'        => $capabilities,
        );
        register_post_type( 'xapimozweblit', $args );

    }

    // Hook into the 'init' action
    add_action( 'init', 'register_xapimozweblit_post_type', 0 );

}


/*
|--------------------------------------------------------------------------
| CUSTOM TAXONOMY FUNCTIONS
|--------------------------------------------------------------------------
*/


if ( ! function_exists('mozweblit_taxonomy') ) {

    // Register Custom Taxonomy
    function mozweblit_taxonomy()  {
        if (taxonomy_exists('mozweblit')){
            return;
        }

        $labels = array(
            'name'                       => _x( 'MozWebLits', 'Taxonomy General Name', 'xapimozweblit' ),
            'singular_name'              => _x( 'MozWebLit', 'Taxonomy Singular Name', 'xapimozweblit' ),
            'menu_name'                  => __( 'MozWebLit', 'xapimozweblit' ),
            'all_items'                  => __( 'All MozWebLits', 'xapimozweblit' ),
            'parent_item'                => __( 'Parent MozWebLit', 'xapimozweblit' ),
            'parent_item_colon'          => __( 'Parent MozWebLit:', 'xapimozweblit' ),
            'new_item_name'              => __( 'New MozWebLit Name', 'xapimozweblit' ),
            'add_new_item'               => __( 'Add New MozWebLit', 'xapimozweblit' ),
            'edit_item'                  => __( 'Edit MozWebLit', 'xapimozweblit' ),
            'update_item'                => __( 'Update MozWebLit', 'xapimozweblit' ),
            'separate_items_with_commas' => __( 'Separate MozWebLits with commas', 'xapimozweblit' ),
            'search_items'               => __( 'Search MozWebLits', 'xapimozweblit' ),
            'add_or_remove_items'        => __( 'Add or remove MozWebLits', 'xapimozweblit' ),
            'choose_from_most_used'      => __( 'Choose from the most used MozWebLits', 'xapimozweblit' ),
        );
        $rewrite = array(
            'slug'                       => 'mozweblit',
            'with_front'                 => true,
            'hierarchical'               => true,
        );
        $capabilities = array(
            'manage_terms'               => 'manage_mozweblits',
            'edit_terms'                 => 'edit_mozweblits',
            'delete_terms'               => 'delete_mozweblits',
            'assign_terms'               => 'assign_mozweblits',
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'query_var'                  => 'mozweblit',
            'rewrite'                    => $rewrite,
            'capabilities'               => $capabilities,
        );
        register_taxonomy( 'mozweblit', 'xapimozweblit', $args );

    }

    // Hook into the 'init' action
    add_action( 'init', 'mozweblit_taxonomy', 0 );

}

?>