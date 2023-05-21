<?php
/**
 * Class to setup taxonomies meta
 *
 * @package epicjungle
 */

class EpicJungle_Post_Taxonomies {

    public function __construct() {
        // Add form fields
        add_action( 'category_add_form_fields',     array( $this, 'add_taxonomy_fields' ), 10 );
        add_action( 'category_edit_form_fields',    array( $this, 'edit_taxonomy_fields' ), 10, 2 );
        add_action( 'post_tag_add_form_fields',     array( $this, 'add_taxonomy_fields' ), 10 );
        add_action( 'post_tag_edit_form_fields',    array( $this, 'edit_taxonomy_fields' ), 10, 2 );

        // Save Values
        add_action( 'create_term',                  array( $this, 'save_taxonomy_fields' ), 10, 3 );
        add_action( 'edit_term',                    array( $this, 'save_taxonomy_fields' ), 10, 3 );

    }

    /**
     * Add taxonomy fields.
     *
     * @return void
     */
    public function add_taxonomy_fields() {
        ?>
        <div id="background-color" class="form-field term-group">
            <label for="category_bg"><?php esc_html_e( 'Background Color - Hex Value', 'epicjungle' ); ?></label>
            <input type="text" id="category_bg" name="category_bg" class="upload_hex_value" value autocomplete="off">
            <div id="tax-bg-wrapper"></div>
        </div>
        <?php
    }

    /**
     * Edit Category fields.
     *
     * @param mixed $term Term being edited
     * @param mixed $taxonomy Taxonomy of the term being edited
     */
    public function edit_taxonomy_fields( $term, $taxonomy ) {
        ?>
        <tr id="background-color" class="form-field term-group-wrap">
            <th scope="row">
                <label for="category_bg"><?php esc_html_e( 'Background Color - Hex Value', 'epicjungle' ); ?></label>
            </th>
            
            <td>
                <?php $cat_bg = get_term_meta ( $term->term_id, 'category_bg', true ); ?>
                <input type="text" id="category_bg" name="category_bg" class="upload_hex_value" value="<?php echo esc_attr( $cat_bg ); ?>">
            </td>
        </tr>


        <?php
    }

    /**
     * Save taxonomy fields.
     *
     * @param mixed $term_id Term ID being saved
     * @param mixed $tt_id
     * @return void
     */
    public function save_taxonomy_fields( $term_id, $tt_id, $taxonomy ) {

        if ( isset( $_POST['category_bg'] ) ) {
            update_term_meta( $term_id, 'category_bg', $_POST['category_bg'] );
        }
    }
}

new EpicJungle_Post_Taxonomies;