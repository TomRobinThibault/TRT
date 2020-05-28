<?php

/*
 * 
 * Function Tools
 * 
 * 
 */
function isCurrentPage($current, $page) {
    if ($current == $page){
        return "active";
    }
    return "";
}