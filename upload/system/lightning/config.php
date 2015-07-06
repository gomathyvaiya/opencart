<?php

// Set true to turn widget into icon (a bit buggy)
$light_small_widget = false;

// Optimization engine
$light_optimize = true;
    $light_hard_optimization = false; // Optimizations that may change products sortings
    $light_group_queries = true; // Disable if have problems with SEO urls or categories display
    $light_optimize_backend = false;

// Cache SQL queries
$light_cache_sql = true;
    $light_sqltime = 24 * 60; // SQL Cache life time in minutes
    $light_cache_only_slow_sql = true; // Cache slow queries only
    // Queries that take more then 0.05 sec are considered slow

    // SQL Caches immune time in sec, specify if you get frequent data updates
    $light_sql_frontend_delay = 0;

$light_cache_ajax = true; // Cache AJAX requests

$light_cache_pages = true;
    $light_pregenerate = true; // Automatically pregenerate pages cache
    $light_pagetime = 2 * 60; // Page cache life time in minutes
    $light_max_pagetime = 24 * 60; // Time when page is considered too old to be shown before regeneration
    // Pages and AJAX requests may be served from cache, even if cache is outdated and will be updated right after display.
    // This will not happen if cache is considered too old.

    $light_cache_critical_only = true; // Cache selected pages only
    // Disable this option to cache all pages.
    // Take a note, that it will require much storage space and may bring more extensions conflicts

    $light_convert_currencies = true; // Use one cached page for serving all currencies

    // Selected pages list
    $light_critical_list = 'common/home product/category product/manufacturer product/special information/sitemap maintenance/maintenance journal2/assets/css journal2/assets/js';

    // Do not cache this pages
    $light_ignore_list = 'error/not_found ajaxcompare geoip feed/ cart captcha buy/ checkout account/ affiliate/ amazon ebay/ payment/ product/compare review mxship';

    // Cache this pages even they match previous list
    $light_not_ignore_list = 'account/login account/register account/forgotten account/return/insert buy/signup affiliate/login affiliate/register affiliate/forgotten';

    // List of modules that need to be updated through AJAX after page load
    $light_ajax_update_list = 'browse random recent module/viewed geoip';

    $light_ignore_url_params = 'utm_source _openstat from gclid yclid';

    // Track last modified pages time and serve Last-Modified and Not Modified headers
    $light_track_last_modified = false;

    // Generate separate page caches for mobiles and tablets
    // Don't activate it until you are really certain that your shop is showing something wrong to mobile visitors
    $light_distinct_gadgets = true;
        $light_treat_tablets_as = "pc"; // Can be one of the following: "tablet", "mobile" or "pc"