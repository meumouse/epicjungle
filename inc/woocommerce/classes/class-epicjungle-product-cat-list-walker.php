<?php
/**
 * EpicJungle_WC_Product_Cat_List_Walker class
 *
 * @extends     Walker
 * @class       EpicJungle_WC_Product_Cat_List_Walker
 * @version     1.0.0
 * @author      MeuMouse.com
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'EpicJungle_WC_Product_Cat_List_Walker', false ) ) :

class EpicJungle_WC_Product_Cat_List_Walker extends Walker {

    /**
     * What the class handles.
     *
     * @var string
     */
    public $tree_type = 'product_cat';

    /**
     * DB fields to use.
     *
     * @var array
     */
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
        'slug'   => 'slug',
    );

    public $current_term_id = '';

    public $is_current_cat = false;

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of category. Used for tab indentation.
     * @param array $args Will only append content if style argument value is 'list'.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // if ( 'list' != $args['style'] ) {
        //     return;
        // }

        $indent = str_repeat( "\t", $depth );
        
        $children_id = '';
        if ( ! empty( $this->current_term_id ) ) {
            $children_id = 'id="children-of-term-' . $this->current_term_id . '"';
        }

        $children_class = 'collapse';

        if ( $this->is_current_cat ) {
            $children_class .= ' show';
        }
        
        $output .= "$indent<ul $children_id class='children $children_class'>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of category. Used for tab indentation.
     * @param array $args Will only append content if style argument value is 'list'.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        // if ( 'list' != $args['style'] ) {
        //     return;
        // }

        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $cat
     * @param int $depth Depth of category in reference to parents.
     * @param array $args
     * @param integer $current_object_id
     */
    public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $output .= '<li class="cat-item cat-item-' . $cat->term_id;
        $child_indicator = '';
        $count           = '';
        $class           = '';
        $this->current_term_id = $cat->term_id;
        $this->is_current_cat  = false;

        if ( $args['current_category'] == $cat->term_id ) {
            $output .= ' current-cat';
            $this->is_current_cat  = true;
        }

        if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
            $output .= ' current-cat-parent';
            $this->is_current_cat  = true;
        }

        if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
            $output .= ' cat-parent';
            $collapsed_class = 'collapsed';
            if ( $this->is_current_cat ) {
                $collapsed_class = '';
            }
            $child_indicator = '<a href="#" data-toggle="collapse" data-target="#children-of-term-' . $cat->term_id . '" class="widget-link ' . $collapsed_class . '"></a>';

            $class .= $collapsed_class;
        }


        $count = ' <small class="text-muted pl-1 ml-2">' . $cat->count . '</small>';

        $output .= '"><a class="cs-widget-link" href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">' . $cat->name . $count  . '</a>';
        $output .= $child_indicator;
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $cat
     * @param int $depth Depth of category. Not used.
     * @param array $args Only uses 'list' for whether should append to output.
     */
    public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max.
     * depth and no ignore elements under that depth. It is possible to set the.
     * max depth to include all depths, see walk() method.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
        if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
            return;
        }
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

endif;
