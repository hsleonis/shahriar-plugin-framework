<?php
/**
 * ThemeAxe Custom Posts
 *
 * @package     Shahriar
 * @author      Md. Hasan Shahriar <info@themeaxe.com>
 * @since       1.0.1
 */
namespace SHAHRIAR;

class TmxCustomPost {

    /**
     * Contains custom post type name
     * @var string
     */
    private $post;

    /**
     * Contains post type labels
     * @var array
     */
    private $labels;

    /**
     * Contains post type options
     * @var array
     */
    private $options;

    /**
     * TmxCustomPost constructor.
     * @param $post string
     *
     * @since 1.0.1
     */
    public function __construct($post, $options=array(), $labels=array())
    {
        $this->post = $post;
        $this->labels = $labels;
        $this->options = $options;
        $this->hooks();
    }

    /**
     * Register Custom Post Type
     *
     * @since 1.0.1
     */
    public function tmx_custom_post_type()
    {
        $labels = array(
            'name'                  => _x( $this->post , 'Post Type General Name', 'themeaxe' ),
            'singular_name'         => _x( $this->post , 'Post Type Singular Name', 'themeaxe' ),
            'menu_name'             => __( $this->post , 'themeaxe' ),
            'name_admin_bar'        => __( $this->post , 'themeaxe' ),
            'archives'              => __( $this->post.' Archives', 'themeaxe' ),
            'parent_item_colon'     => __( 'Parent '.$this->post.':', 'themeaxe' ),
            'all_items'             => __( 'All '.$this->post, 'themeaxe' ),
            'add_new_item'          => __( 'Add New '.$this->post, 'themeaxe' ),
            'add_new'               => __( 'Add New', 'themeaxe' ),
            'new_item'              => __( 'New '.$this->post, 'themeaxe' ),
            'edit_item'             => __( 'Edit '.$this->post, 'themeaxe' ),
            'update_item'           => __( 'Update '.$this->post, 'themeaxe' ),
            'view_item'             => __( 'View '.$this->post, 'themeaxe' ),
            'search_items'          => __( 'Search '.$this->post, 'themeaxe' ),
            'not_found'             => __( 'Not found', 'themeaxe' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'themeaxe' ),
            'featured_image'        => __( 'Featured Image', 'themeaxe' ),
            'set_featured_image'    => __( 'Set featured image', 'themeaxe' ),
            'remove_featured_image' => __( 'Remove featured image', 'themeaxe' ),
            'use_featured_image'    => __( 'Use as featured image', 'themeaxe' ),
            'insert_into_item'      => __( 'Insert into '.$this->post, 'themeaxe' ),
            'uploaded_to_this_item' => __( 'Uploaded to this '.$this->post, 'themeaxe' ),
            'items_list'            => __( $this->post.' list', 'themeaxe' ),
            'items_list_navigation' => __( $this->post.' list navigation', 'themeaxe' ),
            'filter_items_list'     => __( 'Filter '.$this->post.' list', 'themeaxe' ),
        );
        $args = array(
            'label'                 => __( $this->post, 'themeaxe' ),
            'description'           => __( $this->post, 'themeaxe' ),
            'labels'                => wp_parse_args( $this->labels, $labels ),
            'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'taxonomies'            => array( 'category' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-admin-post',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type( $this->post, wp_parse_args( $this->options, $args) );
    }

    /**
     * Attach hooks
     *
     * @since 1.0.1
     */
    private function hooks()
    {
        add_action( 'init', array($this, 'tmx_custom_post_type'), 0);
    }
}