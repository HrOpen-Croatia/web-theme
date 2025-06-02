<?php get_header(); ?>
<main>
    <div class="container animated zoomIn fast">
        <div class="terminal-output">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    echo '<h1>' . get_the_title() . '</h1>';
                    the_content();
                endwhile;
            else :
                echo '<p>No posts found.</p>';
            endif;
            ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>