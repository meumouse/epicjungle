<?php
/**
 * Navbar Dashboard
 *
 */

?>

<header class="header-navbar-dashboard cs-header navbar navbar-expand-lg navbar-dark navbar-floating<?php echo epicjungle_navbar_is_sticky() ? ' navbar-sticky' : ''; ?>" data-scroll-header="">
    <div class="container px-0 px-xl-3"><?php
        do_action( 'epicjungle_navbar_dashboard' ); 
    ?></div>
</header>

 <?php if ( apply_filters('epicjungle_enable_slanted_bg', true ) ) { ?>
    <div class="epicjungle-slanted-bg-header position-relative bg-gradient" style=" height: 480px; ">
        <div class="cs-shape cs-shape-bottom cs-shape-slant bg-secondary d-none d-lg-block">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 260">
                <polygon fill="currentColor" points="0,257 0,260 3000,260 3000,0"></polygon>
            </svg>
        </div>
    </div><?php
} ?>
