<?php get_header(); ?>

<section class="page-content">

    <div class="grid-container">
        <div class="grid-x grid-padding-x align-center">
            <div class="medium-8 large-10 cell">

                <div class="search-list">

                    <p class="found"><?php echo "Found " . $wp_query->found_posts . " results for \"" . get_search_query() . "\"" ?></p>

                    <?php if ( have_posts() ) : ?>
                        <?php global $wp_query; ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <div class="container">
                                <article <?php post_class('search-result'); ?>>
    
                                    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    
                                    <p class="dateline">
                                        <?php echo get_post_type_labels( get_post_type_object( get_post(get_the_id())->post_type ) )->singular_name; ?>
                                        &nbsp;|&nbsp;
                                        Last updated <?php the_time('jS F Y'); ?>
                                    </p>
    
                                    <?php the_excerpt(); ?>
    
                                    <p class="permalink">
                                        <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
                                    </p>
    
                                </article>
                            </div>

                        <?php endwhile; ?>

                        <div class="pagination">
                            <?php
                            global $wp_query;

                            $big = 999999999; // need an unlikely integer

                            echo paginate_links( array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format' => '?paged=%#%',
                                'current' => max( 1, get_query_var('paged') ),
                                'total' => $wp_query->max_num_pages,
                                'prev_text' => '<i class="far fa-chevron-left"></i>',
                                'next_text' => '<i class="far fa-chevron-right"></i>'
                            ) );
                            ?>
                        </div>

                    <?php else: ?>

                        <?php // No search results ?>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

</section>
<?php get_footer(); ?>
