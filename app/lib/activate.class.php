<?php
namespace SHAHRIAR;

class Activator{
    
    public function __construct()
    {
        register_activation_hook( __FILE__, array( $this, 'run' ) );
    }

    public function run(){
        flush_rewrite_rules();
    }
}