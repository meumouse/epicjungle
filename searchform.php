<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="sr-only"><?php echo esc_html__( 'Search for:', 'epicjungle' ); ?></label>
    <div class="input-group-overlay">
        <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe-search"></i></span></div>
        <input type="search" class="search-field form-control prepended-form-control" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'epicjungle' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>
    </div>
</form>