(function ($) {

    jQuery.fn.reviews = function (e_review) {

        /* Save the product ID */
        var post_id = $("#review_post_id").data('postid');
        var show_reviews_action = $(".show-reviews").data('action');
        var average_rating_action = $(".average-rating").data('action');
        var add_review_action = $(".add-review").data('action');

        /* Get and show the current reviews for the product */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: show_reviews_action,
            data: {post_id: post_id},
            success: function (response) {
                if(response.success){
                    $("" + e_review + " .show-reviews").html(response.data);
                    ratingPassive(".show-reviews");
                    bgTransfer();
                }
            }
        });

        /* Get and show the average rating for the product */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: average_rating_action,
            data: {post_id: post_id},
            success: function (response) {
                if(response.success){
                    $("" + e_review + " .average-rating").html(response.data);
                    ratingPassive(".average-rating");
                }
            }
        });

        /* Insert the HTML review form */
        $("" + e_review + " .add-review").append('<form class="form-add-review" role="form" id="form-add-review" class="form-add-review" ><h2>'+LANG_ADDREVIEWS+'</h2><div class="form-group select rating-new  margin-top-25">' +
            '<div class="submit-field">\n' +
            '<select id="rating-new" name="rating-new"><option value="1">1 '+LANG_STAR+'</option><option value="2">2 '+LANG_STAR+'</option><option value="3">3 '+LANG_STAR+'</option><option value="4">4 '+LANG_STAR+'</option><option value="5">5 '+LANG_STAR+'</option></select>\n' +
            '</div>' +
            '</div><div class="submit-field form-group"><h5>'+LANG_REVIEWS+'<span class="mandatory">*</span> </h5><div><textarea name="comments" id="comments" class="form-control review-comments" placeholder="'+LANG_YOURREVIEWS+'" rows="3" data-validation="required"  data-validation-error-msg="'+LANG_ENTER_REVIEW+'"></textarea></div></div><div class="form-group"><div><button type="submit" class="btn btn-primary" id="submit_review">'+LANG_SUBMITREVIEWS+'</button></div></div></form><div class="notice"></div>');



        /* Load the rating stars using the barrating jquery plugin */
        $("" + e_review + " #rating-new").barrating({
            showSelectedRating:true
        });

        /* Validate and process the rating & review form */
        $.validate({
            modules : 'security',
            form : '#form-add-review',
            onSuccess : function () { // If validation is valid we process the form
                var rating = $("" + e_review + " #rating-new").val();
                var message = $("" + e_review + " #comments").val();
                $('#submit_review').addClass('bookme-progress');
                /* Make ajax call to our PHP file to save the review & rating */
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: add_review_action,
                    data: {post_id: post_id, message: message, rating: rating},
                    cache : false,
                    success : function (response) {
                        $('#submit_review').removeClass('bookme-progress');
                        $("" + e_review + " .add-review #form-add-review").fadeOut(600);
                        $("" + e_review + " .add-review .notice").append(response.message).fadeIn(1500);
                    }
                });

                return false;

            }
        });

    }

})(jQuery);

function bgTransfer() {
    //disable-on-mobile

    $(".bg-transfer").each(function () {
        $(this).css("background-image", "url(" + $(this).find("img").attr("src") + ")");
    });
}

function ratingPassive(element){
    $(element).find(".rating-passive").each(function() {
        for( var i = 0; i <  5; i++ ){
            if( i < $(this).attr("data-rating") ){
                $(this).find(".stars").append("<figure class='active fa fa-star'></figure>")
            }
            else {
                $(this).find(".stars").append("<figure class='fa fa-star'></figure>")
            }
        }
    });
}
