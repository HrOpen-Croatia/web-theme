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
                <ul>
                    <?php
                    $locations = get_nav_menu_locations();
                    if (isset($locations['primary'])) {
                        $menu_id = $locations['primary'];
                        $menu_items = wp_get_nav_menu_items($menu_id);

                        // Organiziraj hijerarhiju
                        $menu_tree = [];
                        foreach ($menu_items as $item) {
                            if (!$item->menu_item_parent) {
                                $menu_tree[$item->ID] = [
                                    'item' => $item,
                                    'children' => [],
                                ];
                            } else {
                                $menu_tree[$item->menu_item_parent]['children'][] = $item;
                            }
                        }

                        foreach ($menu_tree as $entry) {
                            echo '<li>';
                            echo '<a href="' . esc_url($entry['item']->url) . '">' . esc_html($entry['item']->title) . '</a>';

                            if (!empty($entry['children'])) {
                                echo '<ul>';
                                foreach ($entry['children'] as $child) {
                                    echo '<li><a href="' . esc_url($child->url) . '">' . esc_html($child->title) . '</a></li>';
                                }
                                echo '</ul>';
                            }

                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>