/**
 * Functions in admin single product page epicjungle
 * 
 * @since 1.7.0
 */

/**
 * Disable input term warranty if display is false
 * 
 */
jQuery(function($) {
  if ($('#ejsp_show_warranty_term').attr('checked')) {
    $('#ejsp_warranty_single_product').prop('disabled', false);
  }
  else {
      $('#ejsp_warranty_single_product').prop('disabled', true);
  }
});

/**
 * Disable input term return if display is false
 * 
 */
jQuery(function($) {
  if ($('#ejsp_show_return_term').attr('checked')) {
    $('#ejsp_return_single_product').prop('disabled', false);
  }
  else {
      $('#ejsp_return_single_product').prop('disabled', true);
  }
});