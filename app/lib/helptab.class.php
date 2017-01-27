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
     * Tab id
     * @var $tab_to_remove string
     */
    private $tab_to_remove;

    /**
     * Page id(s) where the sidebar will be shown.
     * @var $sidebarpage string or array or null
     */
    private $sidebarpage;

    /**
     * Content to be displayed on help tab sidebar.
     * @var $sidebarcontent string
     */
    private $sidebarcontent;

    /**
     * TmxHelpTab constructor.
     * @param array $tabs
     */
    public function __construct(){}

    /**
     * Check screen id
     * @return bool
     */
    private function check_screen($page)
    {
        $screen = get_current_screen();
        
        if($page!==null){
            if($GLOBALS['pagenow']!=='admin.php'){
                if(is_array($page) && !in_array($screen->id, $page) ) {return false;}
                else if(!is_array($page) && $screen->id !== $page) {return false;}
            }
            /*elseif(isset($_GET['page']) && $GLOBALS['pagenow']=='admin.php'){
                if(is_array($this->page) && !in_array($_GET['page'], $this->page) ) {return;}
                else if(!is_array($this->page) && $_GET['page'] !== $this->page) {return;}
            }
            // Not working on custom admin pages*/
        }
        
        return true;
    }

    /**
     * Create help tabs
     * @param null,string,array $page
     * @param array $tabs
     */
    public function create($page=null, $tabs=array(), $top=true)
    {
        $this->tabs = is_array($tabs)?$tabs:array();
        $this->page = $page;

        if($top)
            add_action( "load-{$GLOBALS['pagenow']}", array( $this, 'add_tabs' ), 20 );
        else
            add_action( "admin_head-{$GLOBALS['pagenow']}", array( $this, 'add_tabs' ), 20 );
    }

    /**
     * Add help tabs to current screen
     */
    public function add_tabs()
    {
        // Get screen after page load
        $screen = get_current_screen();

        if($this->check_screen($this->page)){
            foreach ( $this->tabs as $id => $data )
            {
                $screen->add_help_tab( array(
                    'id'       => $id,
                    'title'    => __( $data['title'], 'themeaxe' ),
                    'content'  => '',
                    'callback' => array( $this, 'prepare' )
                ) );
            }
        }
    }

    /**
     * Remove help tabs
     * @param null,id $id
     */
    public function remove($id=null)
    {
        $this->tab_to_remove = $id;
        add_action( "admin_head", array( $this, 'remove_tabs' ) );
    }

    /**
     * Remove tabs from admin
     */
    public function remove_tabs()
    {
        // Get screen after page load
        $screen = get_current_screen();

        if($this->tab_to_remove===null)
            $screen->remove_help_tabs();
        else
            $screen->remove_help_tab($this->tab_to_remove);
    }

    /**
     * Add sidebar to help tabs
     * @param null $page
     * @param string $content
     */
    public function sidebar( $page=null, $content='' )
    {
        $this->sidebarpage = $page;
        $this->sidebarcontent = $content;
        
        add_action( "admin_head-{$GLOBALS['pagenow']}", array( $this, 'add_sidebar' ), 25 );
    }

    /**
     * Add sidebar
     */
    public function add_sidebar()
    {
        // Get screen after page load
        $screen = get_current_screen();
        
        if($this->check_screen($this->sidebarpage)){
            $screen->set_help_sidebar( $this->sidebarcontent );
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