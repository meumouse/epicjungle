/**
 * Product search in AJAX
 * 
 * @since 1.6.0
 */
(function($){

    "use strict";

    function productSearch(form,query,currentQuery,timeout){

        var search   = form.find('.search'),
            category = form.find('.category');

        form.next('.search-results').html('').addClass('d-none');

        query = query.trim();

        if (query.length >= 3) {

            if (timeout) {
                clearTimeout(timeout);
            }

            form.next('.search-results').removeClass('empty');

            $("#preloader-search-products").removeClass('d-none');
            $("#clear-search-results").removeClass('d-none');

            if (query != currentQuery) {
                timeout = setTimeout(function() {

                    $.ajax({
                        url:opt.ajaxUrl,
                        type: 'post',
                        data: { action: 'search_product', keyword: query, category: category.val() },
                        success: function(data) {
                            currentQuery = query;

                            $("#preloader-search-products").addClass('d-none');
                            $("#clear-search-results").removeClass('d-none');

                            if (!form.next('.search-results').hasClass('empty')) {

                                if (data.length) {
                                    form.next('.search-results').html('<ul>'+data+'</ul>').removeClass('d-none');
                                } else {
                                    form.next('.search-results').html(opt.noResults).removeClass('d-none');
                                }

                            }

                            clearTimeout(timeout);
                            timeout = false;


                        }
                    });

                }, 500);
            }
        } else {

            $("#preloader-search-products").addClass('d-none');
            $("#clear-search-results").addClass('d-none');
            form.next('.search-results').empty().addClass('d-none').addClass('empty');

            clearTimeout(timeout);
            timeout = false;

        }
    }

    $('form[name="product-search"]').each(function(){

        var form          = $(this),
            search        = form.find('.search'),
            category      = form.find('.category'),
            currentQuery  = '',
            timeout       = false;

        category.on('change',function(){
            currentQuery  = '';
            var query = search.val();
            productSearch(form,query,currentQuery,timeout);
        });

        search.keyup(function(){
            var query = $(this).val();
            productSearch(form,query,currentQuery,timeout);
        });

    });

})(jQuery);

jQuery(function($){
    $("#clear-search-results").click(function() {

        $("#clear-search-results").addClass('d-none');
        $("#epicjungle-input-search").val('');
        $(".search-results").addClass("d-none");
    });
});