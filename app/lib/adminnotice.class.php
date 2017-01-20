<?php

/**
 * Class TmxAdminNotice
 * WordPress Admin Notice showcase
 * @author Md. Hasan Shahriar
 * @date 20th Jan, 2017
 */
class TmxAdminNotice{

    /**
     * Notice class e.g.: error, info, success, warning, update-nag etc.
     * @var $class string
     */
    private $class;

    /**
     * Message to show
     * @var $msg string
     */
    private $msg;

    /**
     * Is dissmissable by close button
     * @var $dismiss boolean
     */
    private $dismiss;

    /**
     * Add paragraph as message wrapper
     * @var $autop bool
     */
    private $autop;

    /**
     * Value to check as condition
     * @var $value mixed
     */
    private $value;

    /**
     * Check with $value, 0=equal, 1=greater than, -1=less than
     * @var $condition int
     */
    private $condition;

    /**
     * The value to check with (i.e.: standard value)
     * @var $mark mixed
     */
    private $mark;

    /**
     * Language to use
     * @var $textdomain string
     */
    private $textdomain;

    /**
     * TmxAdminNotice constructor.
     * @param array $args
     */
    public function __construct($args=array())
    {
        $this->class = isset($args['class'])?$args['class']:'info';
        $this->msg = isset($args['msg'])?$args['msg']:'';
        $this->dismiss = isset($args['dismiss'])?boolval($args['dismiss']):false;
        $this->autop = isset($args['autop'])?boolval($args['autop']):true;
        $this->value = isset($args['value'])?$args['value']:null;
        $this->mark = isset($args['mark'])?$args['mark']:null;
        $this->condition = (isset($args['condition']) && in_array($args['condition'],array(0,1,-1)))?$args['condition']:0;
        $this->textdomain = isset($args['textdomain'])?$args['textdomain']:'themeaxe';

        add_action( 'admin_notices', array($this, 'all_admin_notice' ));
    }

    public function all_admin_notice()
    {
        // Class
        if(in_array($this->class, array('error', 'warning', 'success', 'info')))
            $this->class = 'notice notice-'.$this->class;

        // Message and Textdomain
        $this->msg = __( $this->msg, $this->textdomain );

        // Autop
        if($this->autop)
            $this->msg = "<p>".$this->msg."</p>";
        
        // Dismissable
        $this->dismiss = $this->dismiss?'is-dismissible':'';
        
        // Value, Condition and Mark
        if($this->value!==null && $this->mark!==null){
            if(($this->condition==1) && ($this->value > $this->mark) ||
                ($this->condition==0) && ($this->value == $this->mark) ||
                ($this->condition==-1) && ($this->value < $this->mark))
                    $this->message();
        }
        else {
            $this->message();
        }
    }
    
    private function message()
    {
        printf( '<div class="%1$s %2$s">%3$s</div>', $this->class, $this->dismiss ,$this->msg );
    }
}