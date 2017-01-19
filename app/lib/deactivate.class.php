<?php
namespace SHAHRIAR;

class Deactivator{
    public static function run(){
        flush_rewrite_rules();
    }
}