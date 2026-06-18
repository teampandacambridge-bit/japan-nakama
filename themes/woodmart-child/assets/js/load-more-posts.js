jQuery(function ($) {
    var currentPage = 1;
    var maxPages = ajax_object.max_pages;
    var pageCat = ajax_object.page_cat;

    console.log("sdjnflks;s;;;;;");

    function loadPosts(page) {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_posts',
                page: page,
                page_cat: pageCat,
            },
            success: function (response) {
                if (response) {
                    $('#card-archive-list').html(response); // Replace current posts
                    currentPage = page; // Update the current page
                    updatePagination();
                    scrollToLocation();
                }
            },
            error: function () {
                console.error('An error occurred while loading posts.');
            }
        });
    }

    function scrollToLocation() {
        let target = document.getElementById('archive-list-scroll-to-target');
        target.scrollIntoView({ behavior: 'smooth' });
    }

    function updatePagination() {
        $('#prev-page').prop('disabled', currentPage <= 1);
        $('#next-page').prop('disabled', currentPage >= maxPages);
    }

    // Initial Pagination Setup
    updatePagination();

    // Use event delegation
    $(document).on('click', '#prev-page', function () {
        console.log("Prev clickedssssssdslknf;sldfn");
        if (currentPage > 1) {
            loadPosts(currentPage - 1);
        }
    });

    $(document).on('click', '#next-page', function () {
        console.log("Next clicked");
        if (currentPage < maxPages) {
            loadPosts(currentPage + 1);
        }
    });

});
