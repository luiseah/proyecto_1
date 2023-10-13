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

/**
 * @param $data
 * @return void
 */
function response($data){
    die(json_encode($data));
}
