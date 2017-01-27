<?php

/**
 * Class TmxThemeSupport
 */
class TmxThemeSupport{

    /**
     * Theme support options
     * @var $options array
     */
    private $options;

    /**
     * TmxThemeSupport constructor.
     */
    public function __construct($args=array())
    {
        $this->options = is_array($args)?$args:array();
        add_action( 'after_setup_theme', array($this, 'theme_features') );
        add_action( 'init', array($this, 'update_image_size') );
        add_action( 'init', array($this, 'remove_image_size') );
    }

    /**
     * Apply theme features
     * feed
     * formats
     * thumbnails
     * thumbnail-size
     * image-size
     * background
     * header
     * html5
     * title
     * editor-style
     * textdomain
     * custom
     */
    public function theme_features()
    {
        // Add theme support for Automatic Feed Links
        if(isset($this->options['feed']) && $this->options['feed'])
            add_theme_support( 'automatic-feed-links' );

        // Add theme support for Post Formats
        /* array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat' ) */
        if( isset($this->options['formats']) && is_array($this->options['formats']) )
            add_theme_support( 'post-formats',$this->options['post-formats'] );

        // Add theme support for Featured Images
        /* array( 'post', 'page', 'movie' ) */
        if( isset($this->options['thumbnails']) && is_array($this->options['thumbnails']) )
            add_theme_support( 'post-thumbnails', $this->options['thumbnails'] );

        // Set custom thumbnail dimensions
        /* array(
            'width' => 400,
            'height' => 300,
            'corp' => array('top','left')
        ) */
        if( isset($this->options['thumbnail-size']) && is_array($this->options['thumbnail-size']) ){
            $w = isset($this->options['thumbnail-size']['width'])?$this->options['thumbnail-size']['width']:150;
            $h = isset($this->options['thumbnail-size']['height'])?$this->options['thumbnail-size']['height']:150;
            $corp = isset($this->options['thumbnail-size']['corp'])?$this->options['thumbnail-size']['corp']:true;

            set_post_thumbnail_size( $w, $h, $corp );
        }

        // Set custom image sizes
        if( isset($this->options['image-size']) && is_array($this->options['image-size']) ){
            foreach ($this->options['image-size'] as $img){
                if(!isset($img['name'])) continue;

                $w = isset($img['width'])?$img['width']:150;
                $h = isset($img['height'])?$img['height']:150;
                $corp = isset($img['corp'])?$img['corp']:true;

                add_image_size( $img['name'], $w, $h, $corp );
            }
        }

        // Add theme support for Custom Background
        /* array(
            'default-color'          => 'FFFFFF',
            'default-image'          => '%1s/images/background.png',
            'default-repeat'         => 'repeat',
            'default-position-x'     => '100',
            'wp-head-callback'       => '_custom_background_callback',
            'admin-head-callback'    => '_admin_head_callback',
            'admin-preview-callback' => '_admin_preview_callback',
        ); */
        if( isset($this->options['background']) && is_array($this->options['background']) )
            add_theme_support( 'custom-background', $this->options['background'] );

        // Add theme support for Custom Header
        /* array(
            'default-image'          => '#',
            'width'                  => 400,
            'height'                 => 300,
            'flex-width'             => true,
            'flex-height'            => true,
            'uploads'                => true,
            'random-default'         => true,
            'header-text'            => true,
            'default-text-color'     => '#000000',
            'wp-head-callback'       => '_cusytom_header_callback',
            'admin-head-callback'    => '_admin_head_callback',
            'admin-preview-callback' => '_admin_preview_callback',
            'video'                  => true,
            'video-active-callback'  => 'is_front_page',
        ) */
        if( isset($this->options['header']) && is_array($this->options['header']) )
            add_theme_support( 'custom-header', $this->options['header'] );

        // Add theme support for HTML5 Semantic Markup
        // array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' )
        if( isset($this->options['html5']) && is_array($this->options['html5']) )
            add_theme_support( 'html5', $this->options['html5'] );

        // Add theme support for document Title tag
        if(isset($this->options['title']) && $this->options['title'])
            add_theme_support( 'title-tag' );

        // Add theme support for custom CSS in the TinyMCE visual editor
        if(isset($this->options['editor-style']) && $this->options['editor-style'])
            add_editor_style( $this->options['editor-style'] );

        // Add theme support for Translation
        if(isset($this->options['textdomain']) && isset($this->options['textdomain-dir']))
            load_theme_textdomain( $this->options['textdomain'], $this->options['textdomain-dir'] );

        // Custom theme options for plugin support etc.
        /* array( 'woocommerce' ) */
        if( isset($this->options['custom']) && is_array($this->options['custom']) ){
            foreach ($this->options['custom'] as $slug)
                add_theme_support( $slug );
        }
    }

    public function update_image_size()
    {

    }

    public function remove_image_size()
    {

    }
}