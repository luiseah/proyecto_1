<?php
/** Functions **/

function plugin(){
    static $plugin;
    if( ! $plugin ){
        $plugin = new \Uniqoders\MyPlugin\Plugin();
        do_action( "plugin", $plugin );
    }
    return $plugin;
}