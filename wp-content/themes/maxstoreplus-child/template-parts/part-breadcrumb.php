<?php
$args = array(
    'container'       => 'div',
    'before'          => '',
    'after'           => '',
    'show_on_front'   => true,
    'network'         => false,
    'show_title'      => true,
    'show_browse'     => false,
    'labels'          => array(
    	'home' => 'home'
    ),
    'post_taxonomy'   => array(),
    'echo'            => true
);
if(  !is_front_page()){
    maxstoreplus_breadcrumb_trail($args);
}
?>