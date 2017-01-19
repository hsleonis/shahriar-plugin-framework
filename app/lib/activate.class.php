<?php
namespace SHAHRIAR;

class Activator{
    public static function run(){
        flush_rewrite_rules();
    }
}