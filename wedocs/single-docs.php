<?php
/**
 * The template for displaying a single doc
 *
 * To customize this template, create a folder in your current theme named "wedocs" and copy it there.
 *
 * @package weDocs
 */

get_header(); ?>

    <?php
        /**
         * @since 1.4
         *
         * @hooked wedocs_template_wrapper_start - 10
         */
        do_action( 'wedocs_before_main_content' );
    ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <div class="cs-sidebar-enabled">
            <div class="container">
                 <div class="row"><?php
                      wedocs_get_template_part( 'docs', 'sidebar' ); ?>
             <div class="col-lg-9 cs-content py-4" itemscope itemtype="http://schema.org/Article">
                
                    <?php epicjungle_wedocs_breadcrumbs(); ?>
                <div class="d-md-flex justify-content-between pb-2 mb-4">
                     <?php the_title( '<h1 class="mr-3"  style="max-width: 38rem;">', '</h1>' ); ?>
                     
                          <!-- .entry-header -->
                        <span class="font-size-sm text-muted text-md-nowrap pt-2">
                            <?php ej_wedocs_article_published_date(); ?>
                        </span>
                </div>
                           
                            <?php ej_wedocs_single_doc_content(); ?>
                      

                            <footer class="entry-footer wedocs-entry-footer"><?php
                            /**
                             * 
                             */
                            

                            ?></footer>

                    
                    </div>
                </div>
            </div><!-- .wedocs-single-content -->
        </div><!-- .wedocs-single-wrap -->

    <?php endwhile; ?>

    <?php
        /**
         *
         * @hooked wedocs_template_wrapper_end - 10
         */
        do_action( 'wedocs_after_main_content' );
    ?>

<?php get_footer(); ?>
