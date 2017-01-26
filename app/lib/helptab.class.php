<?php

/**
 * Class TmxHelpTab
 * Author: Md. Hasan Shahriar
 * 26th Jan, 2017
 * hsleonis2@gmail.com
 */
class TmxHelpTab{

    /**
     * Tabs to be shown.
     * @var $tabs array
     */
    private $tabs;

    /**
     * Page id(s) where the tabs will be shown.
     * @var $page string or array or null
     */
    private $page;

    /**
     * TmxHelpTab constructor.
     * @param array $tabs
     */
    public function __construct(){}

    /**
     * Create help tabs
     * @param null,string,array $page
     * @param array $tabs
     */
    public function create($page=null, $tabs=array())
    {
        $this->tabs = is_array($tabs)?$tabs:array();
        $this->page = $page;

        add_action( "load-{$GLOBALS['pagenow']}", array( $this, 'add_tabs' ), 20 );
    }

    /**
     * Add help tabs to current screen
     */
    public function add_tabs()
    {
        // Get screen after page load
        $screen = get_current_screen();

        if($this->page!==null){
            if(is_array($this->page) && !in_array($screen->id, $this->page) ) {return;}
            else if(!is_array($this->page) && $screen->id !== $this->page) {return;}
        }

        foreach ( $this->tabs as $id => $data )
        {
            $screen->add_help_tab( array(
                'id'       => $id,
                'title'    => __( $data['title'], 'some_textdomain' ),
                'content'  => '<p>Some stuff that stays above every help text</p>',
                'callback' => array( $this, 'prepare' )
            ) );
        }
    }

    /**
     * Stuff that stays above every help text.
     * @param $screen
     * @param $tab
     */
    public function prepare( $screen, $tab )
    {
        printf(
            '<p>%s</p>'
            ,__(
                $tab['callback'][0]->tabs[ $tab['id'] ]['content']
                ,'dmb_textdomain'
            )
        );
    }
}