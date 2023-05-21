<?php
/**
 * EpicJungle hooks
 *
 * @package epicjungle
 */

/**
 * Page
 *
 */
add_action( 'epicjungle_page', 'epicjungle_breadcrumb', 10 );
add_action( 'epicjungle_page', 'epicjungle_page_header', 20 );
add_action( 'epicjungle_page', 'epicjungle_page_content', 30 );

/**
 * Comments
 */

add_filter( 'edit_comment_link',  'epicjungle_edit_comment_link', 20, 3 );

/**
 * Blog
 *
 */

add_filter( 'epicjungle_get_breadcrumb', 'epicjungle_get_post_breadcrumb', 99, 2 );

add_action( 'epicjungle_posts_content_before', 'epicjungle_breadcrumb', 10 );
add_action( 'epicjungle_posts_content_before', 'epicjungle_archive_header', 10 );


add_action( 'epicjungle_loop_post_sticky', 'epicjungle_featured_badge', 10 );
add_action( 'epicjungle_loop_post_sticky', 'epicjungle_sticky_post_thumbnail', 20 );
add_action( 'epicjungle_loop_post_sticky', 'epicjungle_sticky_post_card_body_wrap_start', 30 );
add_action( 'epicjungle_loop_post_sticky', 'epicjungle_loop_post_card_body', 40 );

add_action( 'epicjungle_loop_post_sticky', 'epicjungle_sticky_post_card_body_wrap_end', 60 );


add_action( 'epicjungle_loop_after', 'epicjungle_loop_paging_nav_wrap_start', 10 );
add_action( 'epicjungle_loop_after', 'epicjungle_results_count', 20 );
add_action( 'epicjungle_loop_after', 'epicjungle_pagination', 30 );
add_action( 'epicjungle_loop_after', 'epicjungle_loop_paging_nav_wrap_end', 40 );

/**
 * Single Post
 *
 */
add_action( 'epicjungle_single_post', 'epicjungle_single_post_header', 10 );
add_action( 'epicjungle_single_post', 'epicjungle_single_post_meta', 20 );
add_action( 'epicjungle_single_post', 'epicjungle_single_post_content', 30 );

add_action( 'epicjungle_single_post_bottom', 'epicjungle_single_post_footer', 10 );
add_action( 'epicjungle_single_post_bottom', 'epicjungle_single_post_nav', 20 );
add_action( 'epicjungle_single_post_bottom', 'epicjungle_display_comments', 30 );
add_action( 'epicjungle_single_post_bottom', 'epicjungle_single_related_posts', 40 );


add_action( 'epicjungle_share', 'epicjungle_share_display', 10 );

/**
 * Protected Post Custom Password Form
 */
add_filter( 'the_password_form', 'epicjungle_post_protected_password_form' );

/**
 * Comments
 */

add_filter( 'comment_form_default_fields', 'epicjungle_comment_form_default_fields', 20 );


/**
 * Navbar Solid
 *
 */
add_action( 'epicjungle_navbar_solid', 'epicjungle_navbar_toggler', 10 );
add_action( 'epicjungle_navbar_solid', 'epicjungle_navbar_brand', 20 );
add_action( 'epicjungle_navbar_solid', 'epicjungle_offcanvas', 40 );
add_action( 'epicjungle_navbar_solid', 'epicjungle_dashboard_user_account', 30 );

/**
 * Navbar Dashboard
 *
 */
add_action( 'epicjungle_navbar_dashboard', 'epicjungle_navbar_toggler', 10 );
add_action( 'epicjungle_navbar_dashboard', 'epicjungle_navbar_brand', 20 );
add_action( 'epicjungle_navbar_dashboard', 'epicjungle_offcanvas', 30 );
add_action( 'epicjungle_navbar_dashboard', 'epicjungle_dashboard_user_account', 30 );

/**
 * Navbar Shop
 *
 */
add_action( 'navbar_shop_topbar', 'epicjungle_navbar_shop_topbar', 10 );

add_action( 'epicjungle_before_navbar', 'epicjungle_site_search', 10 );

add_action( 'epicjungle_navbar_shop', 'epicjungle_navbar_toggler', 10 );
add_action( 'epicjungle_navbar_shop', 'epicjungle_navbar_brand', 20 );
add_action( 'epicjungle_navbar_shop', 'epicjungle_offcanvas', 40 );
add_action( 'epicjungle_navbar_shop', 'epicjungle_header_icons_links', 50 );

add_action( 'epicjungle_header_links', 'epicjungle_navbar_search', 10 );
add_action( 'epicjungle_header_links', 'epicjungle_shop_user_account',  20 );
add_action( 'epicjungle_header_links', 'epicjungle_navbar_cart',  30 );

/**
 * Navbar Button
 *
 */
add_action( 'epicjungle_navbar_button', 'epicjungle_navbar_toggler', 10 );
add_action( 'epicjungle_navbar_button', 'epicjungle_navbar_brand', 20 );
add_action( 'epicjungle_navbar_button', 'epicjungle_offcanvas', 40 );
add_action( 'epicjungle_navbar_button', 'epicjungle_navbar_action_button', 30 );

/**
 * Navbar Social
 *
 */

add_action( 'epicjungle_before_navbar', 'epicjungle_site_search', 10 );

add_action( 'epicjungle_navbar_social', 'epicjungle_navbar_toggler', 10 );
add_action( 'epicjungle_navbar_social', 'epicjungle_navbar_brand', 20 );
add_action( 'epicjungle_navbar_social', 'epicjungle_offcanvas', 40 );
add_action( 'epicjungle_navbar_social', 'epicjungle_navbar_social_tool_links', 50 );

add_action( 'epicjungle_social_header_links', 'epicjungle_navbar_search', 10 );
add_action( 'epicjungle_social_header_links', 'epicjungle_navbar_social_links',  20 );


/**
 * Modal
 */
add_action( 'epicjungle_before_header', 'epicjungle_wc_modal_in_navbar', 20 );
add_action( 'epicjungle_before_header', 'epicjungle_offcanvas_toggler', 30 );
add_action( 'epicjungle_before_header', 'epicjungle_navbar_modal', 40 );


add_action( 'epicjungle_before_404', 'epicjungle_wc_modal_in_navbar', 20 );


add_filter( 'epicjungle_enable_boxshadow', 'epicjungle_404_page_boxshadow' );


/**
 * Footer
 *
 */

add_action( 'epicjungle_footer',            'epicjungle_footer_default_widgets', 10 );
add_action( 'epicjungle_footer',            'epicjungle_footer_default_copyright', 20 );


add_action( 'epicjungle_after_footer',      'epicjungle_scroll_to_top', 10 );
add_action( 'epicjungle_after_footer',      'epicjungle_handheld_toolbar', 20 );


add_action( 'epicjungle_handheld_toolbar',  'epicjungle_handheld_toolbar_toggle_blog_sidebar', 10 );

add_action( 'epicjungle_footer_simple',     'epicjungle_footer_links', 10 );
add_action( 'epicjungle_footer_simple',     'epicjungle_footer_default_copyright_text', 20 );


add_action( 'epicjungle_footer_simple_2',   'epicjungle_social_media_links', 20 );
add_action( 'epicjungle_footer_simple_2',   'epicjungle_footer_default_copyright_text', 10 );

add_action( 'epicjungle_footer_shop',       'epicjungle_footer_shop_widgets', 10 );
add_action( 'epicjungle_footer_shop',       'epicjungle_footer_shop_bottom_bar', 20 );

add_action( 'epicjungle_footer_blog',       'epicjungle_footer_blog_top_bar', 10 );
add_action( 'epicjungle_footer_blog',       'epicjungle_footer_blog_bottom_bar', 20 );

add_action( 'epicjungle_footer_v6',         'epicjungle_footer_v6_widgets', 10 );
add_action( 'epicjungle_footer_v6',         'epicjungle_footer_default_copyright_text', 20 );

add_action( 'epicjungle_footer_v7',         'epicjungle_footer_v7_widgets', 10 );

add_action( 'epicjungle_footer_v8',         'epicjungle_footer_v8_widgets', 10 );

add_action( 'epicjungle_footer_v9',         'epicjungle_footer_default_copyright_text', 10 );

add_filter( 'pre_get_avatar_data',      'epicjungle_custom_uploaded_pre_avatar_override', 10, 2 );
add_filter( 'get_avatar_url',           'epicjungle_custom_uploaded_avatar_url_override', 10, 3 );
add_filter( 'get_avatar_data',          'epicjungle_custom_uploaded_avatar_override', 10, 2 );

/**
 * Nav Menu Widget Handle Custom Fields
 */
add_filter( 'in_widget_form',          'epicjungle_custom_widget_nav_menu_options', 10, 3 );
add_filter( 'widget_update_callback',  'epicjungle_custom_widget_nav_menu_options_update', 10, 4 );
add_filter( 'widget_nav_menu_args',    'epicjungle_custom_widget_nav_menu_args', 20, 4 );

add_action( 'coming_soon',          'epicjungle_coming_soon_content', 10 );

require get_template_directory() . '/inc/template-hooks/portfolio.php';