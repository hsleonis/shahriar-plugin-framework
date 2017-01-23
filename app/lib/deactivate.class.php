<?php
namespace SHAHRIAR;

class Deactivator{

    public function __construct()
    {
        register_deactivation_hook( __FILE__, array( 'Deactivator', 'run' ) );
    }
    
    public function run(){
        flush_rewrite_rules();
    }
}