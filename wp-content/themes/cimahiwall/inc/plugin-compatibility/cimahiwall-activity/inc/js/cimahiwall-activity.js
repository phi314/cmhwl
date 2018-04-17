/**
 * Created by phi314 on 17/04/18.
 */

jQuery( function ( $ ) {
    $('#loadmore').on('click', function () {

        var last_activity_id = $(this).val();

        // Do ajax Load more
        $.post(cimahiwall.ajax_url, {last_activity_id: last_activity_id, action: 'load_more_activity' }, function (data) {

            var data = $.parseJSON(data);

            if( data.activities_left <= 0) {
                $('#loadmore').remove();
            }

            if( data.result.length > 0) {
                var last_activity = data.result[data.result.length - 1];
                var last_activity_id = last_activity.activity_id;

                $('#loadmore').val(last_activity_id);

                $.each(data.result, function( index, value ) {

                    var $media = " " +
                        "<div class='media border-bottom py-2'>" +
                        "<!-- Avatar -->" +
                        value.avatar +
                        "<!-- /. Avatar -->" +
                        "<div class='media-body'>" +
                        "<p class='mt-0'>" +
                        "<a href=''>" + value.display_name + "</a> " +
                        value.activity_text +
                        "<small class='d-block'>" + value.activity_date + "</small>" +
                        "</p>" +
                        "<div>" +
                        "<a href='" + value.post_link + "'>" +
                        "<div class='row'>" +
                        "<div class='col-4 col-md-3'>" +
                        value.featured_image +
                        "</div>" +
                        "<div class='col-8 col-md-9 my-auto pl-0'>" +
                        "<p class='pl-0'>" +
                        value.name +
                        "<small class='d-block'><em>";

                    if( value.comment != null )
                        $media += '"' + value.comment + '"';

                    $media += "</em></small>" +
                        "</p>" +
                        "</div>" +
                        "</div>" +
                        "</a>" +
                        "</div>" +
                        "</div>";

                    $('#activity-container').append( $media );
                });
            }

        });
    });

});