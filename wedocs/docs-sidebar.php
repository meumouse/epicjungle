<div class="cs-sidebar col-lg-3 pt-lg-5">

    <div class="cs-offcanvas-collapse" id="help-sidebar">

        <div class="cs-offcanvas-cap navbar-box-shadow px-4 mb-3">

            <h5 class="mt-1 mb-0"><?php echo esc_html__( 'Sidebar', 'epicjungle' ); ?></h5>

            <button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="help-sidebar">
              	<span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="cs-offcanvas-body px-4 pt-3 pt-lg-0 pl-lg-0 pr-lg-2 pr-xl-4" data-simplebar><?php
            do_action( 'ej_wedocs_sidebar' );
        ?></div>
    </div>

</div>