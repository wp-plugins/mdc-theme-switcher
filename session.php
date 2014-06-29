<?php
add_action('init', 'simpleSessionStart', 1);
add_action('wp_logout', 'simpleSessionDestroy');
add_action('wp_login', 'simpleSessionDestroy');

function simpleSessionStart() {
    if(!session_id())session_start();
}
             
function simpleSessionDestroy() {
    session_destroy ();
}

function simpleSessionGet($key, $default='') {
    if(isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } else {
        return $default;
    }
}

function simpleSessionSet($key, $value) {
    $_SESSION[$key] = $value;
}