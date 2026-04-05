<?php
/**
 * extract_body_html($path): returns the inner HTML between <body> and </body> of an HTML file.
 * Simple and defensive; if it can't find body tags it returns the full file.
 */
function extract_body_html($path){
    if(!is_readable($path)) return '';
    $s = file_get_contents($path);
    $s = preg_replace('#<!--.*?-->#s','',$s); // strip comments (simple)
    if(preg_match('#<body[^>]*>(.*)</body>#is',$s,$m)){
        return $m[1];
    }
    return $s;
}

