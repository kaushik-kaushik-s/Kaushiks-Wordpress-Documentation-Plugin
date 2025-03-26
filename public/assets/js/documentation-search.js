jQuery(document).ready(function($) {
    $('.documentation-search-form').on('submit', function(e) {
        var searchQuery = $('.documentation-search-field').val();
        
        $.ajax({
            url: docSearchParams.ajaxurl,
            type: 'POST',
            data: {
                action: 'documentation_search',
                query: searchQuery
            },
            success: function(response) {
                $('.documentation-search-results').html(response);
            }
        });
        
        e.preventDefault();
    });
});