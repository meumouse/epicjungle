<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$max_pages = isset( $GLOBALS['wp_query']->max_num_pages ) ? $GLOBALS['wp_query']->max_num_pages : 1;
if ( $max_pages < 2 ) {
    return;
}

$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
$links = paginate_links( apply_filters( 'epicjungle_posts_pagination_args', [
    'type'      => 'array',
    'mid_size'  => 2,
    'prev_next' => false,
] ) );

?>
<nav class="d-flex justify-content-between mb-4" aria-label="<?php
/* translators: aria-label for posts navigation wrapper */
echo esc_attr_x( 'Posts navigation', 'front-end', 'epicjungle' ); ?>">
    <ul class="pagination justify-content-center">
        <?php if ( $paged && 1 < $paged ) : ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo esc_url( get_previous_posts_page_link() ); ?>">
                    <i class="fe-chevron-left"></i>
                    <span class="sr-only"><?php echo esc_html_x( 'Prev', 'front-end', 'epicjungle' ); ?></span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <ul class="pagination justify-content-center">
        <li class="page-item d-sm-none">
            <span class="page-link page-link-static"><?php echo esc_html( "{$paged} / {$max_pages}" ); ?></span>
        </li>
        <?php foreach ( $links as $link ) : ?>
            <?php if ( false !== strpos( $link, 'current' ) ) : ?>
                <li class="page-item active d-none d-sm-block">
                    <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                </li>
            <?php else : ?>
                <li class="page-item d-none d-sm-block">
                    <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <ul class="pagination justify-content-center">
        <?php if ( $paged && $paged < $max_pages ) : ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo esc_url( get_next_posts_page_link() ); ?>">
                    <span class="sr-only"><?php echo esc_html_x( 'Next', 'front-end', 'epicjungle' ); ?></span>
                    <i class="fe-chevron-right"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
        
