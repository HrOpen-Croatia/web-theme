<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php 
    // SEO Title tag implementation
    if (is_front_page()) : ?>
        <title><?php bloginfo('name'); ?> <?php bloginfo('description'); ?></title>
    <?php elseif (is_singular()) : ?>
        <title><?php single_post_title(); ?> <?php bloginfo('name'); ?></title>
    <?php elseif (is_archive()) : ?>
        <title><?php wp_title(''); ?> <?php bloginfo('name'); ?></title>
    <?php elseif (is_search()) : ?>
        <title>Search Results for "<?php echo get_search_query(); ?>" <?php bloginfo('name'); ?></title>
    <?php elseif (is_404()) : ?>
        <title>Page Not Found <?php bloginfo('name'); ?></title>
    <?php else : ?>
        <title><?php wp_title(''); ?> <?php bloginfo('name'); ?></title>
    <?php endif; ?>
    
    <!-- Meta description -->
    <?php if (is_singular()) : ?>
        <meta name="description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
    <?php else : ?>
        <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:locale" content="<?php echo get_locale(); ?>">
    <meta property="og:type" content="<?php echo is_single() ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo is_singular() ? single_post_title('', false) : bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo is_singular() ? esc_attr(wp_strip_all_tags(get_the_excerpt(), true)) : bloginfo('description'); ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <?php if (is_singular() && has_post_thumbnail()) : ?>
        <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>">
    <?php endif; ?>
    
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo is_singular() ? single_post_title('', false) : bloginfo('name'); ?>">
    <meta name="twitter:description" content="<?php echo is_singular() ? esc_attr(wp_strip_all_tags(get_the_excerpt(), true)) : bloginfo('description'); ?>">
    <?php if (is_singular() && has_post_thumbnail()) : ?>
        <meta name="twitter:image" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>">
    <?php endif; ?>
    
    <!-- Favicon -->
    <?php if (function_exists('has_site_icon') && has_site_icon()) : ?>
        <?php wp_site_icon(); ?>
    <?php endif; ?>
    
    <link rel="stylesheet" href="https://unpkg.com/terminal.css@0.7.4/dist/terminal.min.css">
    <?php wp_head(); ?>
</head>
<body <?php body_class('terminal'); ?>>
    <?php if (function_exists('wp_body_open')) {
        wp_body_open();
    } ?>
    <div class="container">
        <div class="terminal-nav">
            <header class="terminal-logo">
                <div class="logo terminal-prompt">
                    <a class="no-style site-name" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>:~#
                </div>
            </header>
            <nav class="terminal-menu">
                <ul vocab="https://schema.org/" typeof="BreadcrumbList">
                    <?php
                    $locations = get_nav_menu_locations();
                    if (isset($locations['primary'])) {
                        $menu_id = $locations['primary'];
                        $menu_items = wp_get_nav_menu_items($menu_id);

                        if ($menu_items) {
                            $position = 1;
                            foreach ($menu_items as $item) {
                                if ($item->menu_item_parent == 0) { // samo top-level stavke
                                    echo '<li property="itemListElement" typeof="ListItem">';
                                    echo '<a property="item" typeof="WebPage" href="' . esc_url($item->url) . '">';
                                    echo '<span property="name">' . esc_html($item->title) . '</span>';
                                    echo '</a>';
                                    echo '<meta property="position" content="' . $position . '">';
                                    echo '</li>';
                                    $position++;
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>