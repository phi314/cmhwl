/**
 * Created by phi314 on 17/04/18.
 */

jQuery( function ( $ ) {

    /*
        Load more function
     */
    $('#loadmore').on('click', function () {
        var last_activity_id = $(this).val();
        var user_id = $('#user-id').val();
        var all_user = $('#all-user').val();
        var $loadmoreBtn = $('#loadmore');

        // Ajax Loadmore
        $.ajax({
            type: 'POST',
            url: cimahiwall.ajax_url,
            data: {
                user_id: user_id,
                all_user: all_user,
                last_activity_id: last_activity_id,
                action: 'load_more_activity'
            },
            beforeSend: function() {
                $loadmoreBtn.text('Loading . . .')
            },
            success: function( data ) {
                $loadmoreBtn.text('Load more')

                var data = $.parseJSON(data);

                // remove load more button if there is no activity to load more
                if( data.activities_left <= 0) {
                    $loadmoreBtn.remove();
                }

                if( data.result.length > 0) {
                    var last_activity = data.result[data.result.length - 1];
                    var last_activity_id = last_activity.activity_id;
                    $loadmoreBtn.val(last_activity_id); // set last activity id to button
                    $.each(data.result, function( index, value ) {
                        var $templateActivity = $('#activityTemplate').html();
                        $templateActivity = $templateActivity.replace(/{avatar}/g, value.avatar );
                        $templateActivity = $templateActivity.replace(/{display_name}/g, value.display_name );
                        $templateActivity = $templateActivity.replace(/{activity_text}/g, value.activity_text );
                        $templateActivity = $templateActivity.replace(/{activity_date}/g, value.activity_date );
                        $templateActivity = $templateActivity.replace(/{post_link}/g, value.post_link );
                        $templateActivity = $templateActivity.replace(/{featured_image}/g, value.featured_image );
                        $templateActivity = $templateActivity.replace(/{name}/g, value.name );
                        $templateActivity = $templateActivity.replace(/{user_link}/g, value.user_link );
                        value.comment = ( value.comment != null ) ? '"' + value.comment + '"' : "";
                        $templateActivity = $templateActivity.replace(/{comment}/g, value.comment );
                        $('#activity-container').append( $templateActivity );
                    });
                }
            }
        });
    });

    /*
        Follow and Unfollow function
     */
    $('.form-follow-user').on('submit', function(e){

        e.preventDefault();
        var $form = $(this);
        var user_id = $(this).find('input[name=user_id]').val();
        $form = $('form.user-id-' + user_id);
        var nonce = $form.find('input[name=_wpnonce]').val();
        var $unfollow = $form.find('input[name=unfollow]');
        var $button = $form.find('button');

        $.ajax({
            type: 'POST',
            url: cimahiwall.ajax_url,
            data: {
                user_id: user_id,
                nonce: nonce,
                action: 'log_follow_user',
                unfollow: $unfollow.val()
            },
            success: function (data) {
                data = JSON.parse( data );
                if( 'result' in data) {
                    if( data.status == 'follow' ) {
                        $button.addClass('btn-filled');
                        $button.text('Following');
                        $form.append('<input type="hidden" name="unfollow">');
                    }
                    else if( data.status == 'unfollow' ) {
                        $button.removeClass('btn-filled');
                        $button.text('Follow');
                        $unfollow.remove();
                    }
                }
            }
        });
    });
});