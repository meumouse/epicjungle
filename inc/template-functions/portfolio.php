<?php
/**
 * Template functions related to portfolio
 *
 */

if ( ! function_exists( 'epicjungle_page_wrapper_start' ) ) {
    function epicjungle_page_wrapper_start() {

        if ( ! is_post_type_archive( 'jetpack-portfolio' ) ) {
            return;
        }

        $class = 'cs-page-wrapper';

        ?><main class="<?php echo esc_attr( $class ); ?>"><?php
    }
}

if ( ! function_exists( 'epicjungle_page_wrapper_end' ) ) {
    function epicjungle_page_wrapper_end() {

        if ( ! is_post_type_archive( 'jetpack-portfolio' ) ) {
            return;
        }

        ?></main><?php
    }
}

if ( ! function_exists( 'epicjungle_portfolio_header' ) ) :

function epicjungle_portfolio_header() { 
    ?><section class="position-relative bg-dark pt-7 pb-5 pb-md-7 bg-size-cover bg-fixed" style="background-image: url(img/demo/web-studio/cubes-bg.jpg);">
        <div class="cs-shape cs-shape-bottom cs-shape-curve bg-body">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
                <path fill="currentColor" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
            </svg>
        </div>
        <div class="container bg-overlay-content text-center pt-md-6 pt-lg-7 py-5 my-lg-3">
            <h1 class="text-light mb-0">Portfolio<span class="h2 d-inline-block bg-faded-primary text-primary px-3 py-2 rounded-lg ml-3">Style</span></h1>
        </div>
    </section><?php  
}

endif;

if ( ! function_exists( 'epicjungle_section_portfolio_content_start' ) ) :
    /**
    * Function for Section Portfolio Content Start
    */
    function epicjungle_section_portfolio_content_start() { ?>
        <section class="container overflow-hidden py-5 py-md-6 py-lg-7">
            <div class="cs-masonry-filterable pt-3 pt-md-0">
                 <?php epicjungle_portfolio_filters(); ?>
                 <div class="cs-masonry-grid" data-columns="3">
            <?php }

endif;

if ( ! function_exists( 'epicjungle_loop_portfolio' ) ) :
    /**
    * Function for Portfolio loop
    */
    function epicjungle_loop_portfolio() {
        $terms  = get_the_terms( get_the_ID(), 'jetpack-portfolio-tag' );
        $groups = '';
        $groups_arr = [];

        if ( is_array( $terms ) ) {
            foreach( $terms as $term ) {
                $groups_arr[] = $term->slug;
            }
        }

        $groups = implode( '","', $groups_arr );
        
        ?><div class='cs-grid-item' data-groups='[&quot;<?php echo esc_attr( $groups ); ?>&quot;]'>
            <a class="card card-hover border-0 box-shadow" href="<?php echo esc_url( get_permalink() ); ?>"><?php 

                epicjungle_portfolio_image_display(); 

                ?><div class="card-body text-center"><?php 

                    epicjungle_portfolio_title_display();

                    epicjungle_portfolio_category_display(); 
                
                ?></div>
            </a>
        </div><!-- /.cs-grid-item --><?php  
    }
endif;

if ( ! function_exists( 'epicjungle_portfolio_image_display' ) ) :
    /**
    * Function to display Portfolio Image
    */
    function epicjungle_portfolio_image_display() {  
       the_post_thumbnail('full', ['class' => 'card-img-top','alt'=> "..."]);
    }

endif;

if ( ! function_exists( 'epicjungle_portfolio_title_display' ) ) :
    /**
    * Function to display Portfolio Title
    */
    function epicjungle_portfolio_title_display() { ?>
        <h3 class="h5 nav-heading mb-2"><?php the_title();?></h3>
   <?php  }

endif;

if ( ! function_exists( 'epicjungle_portfolio_category_display' ) ) :

    function epicjungle_portfolio_category_display() { ?>
        <p class="font-size-sm text-muted mb-2"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ' ) ); ?></p>
   <?php }

endif;


/**
* Function for Section Portfolio Content end
*/
if ( ! function_exists( 'epicjungle_section_portfolio_content_end' ) ) :

function epicjungle_section_portfolio_content_end() { ?>
                </div>
            </div>
        </section>
    <?php  }

endif;

if ( ! function_exists( 'epicjungle_portfolio_pagination' ) ) :
    /**
     * Output the pagination.
     */
    function epicjungle_portfolio_pagination() {
        epicjungle_bootstrap_pagination( null, true, 'justify-content-center');
    }

endif;

if ( ! function_exists( 'epicjungle_portfolio_filters' ) ) :
    /**
    * Output the portfolio category filter.
    */
    function epicjungle_portfolio_filters() {

        $portfolio_cats = array();

        while ( have_posts() ) :
            the_post();

            $portfolio_types = get_the_terms( get_the_ID(), 'jetpack-portfolio-tag' );
            if ( ! $portfolio_types || is_wp_error( $portfolio_types ) ) {
                $portfolio_types = array();
            }

            $portfolio_types = array_values( $portfolio_types );

            foreach ( array_keys( $portfolio_types ) as $key ) {
                _make_cat_compat( $portfolio_types[ $key ] );          
            }

            foreach ( $portfolio_types as $portfolio_type ) {
                $portfolio_cats[ $portfolio_type->slug] = $portfolio_type->name;
            }

        endwhile; ?>

        <ul class="cs-masonry-filters nav nav-tabs justify-content-center mt-2 pb-4">          
            <li class="nav-item">
                <a class="nav-link active" href="#" data-group="all">All</a>
            </li>
            <?php foreach ( $portfolio_cats as $key => $portfolio_cat ): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-group="<?php echo esc_attr( $key ); ?>" ><?php echo esc_html( $portfolio_cat ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php }
endif;