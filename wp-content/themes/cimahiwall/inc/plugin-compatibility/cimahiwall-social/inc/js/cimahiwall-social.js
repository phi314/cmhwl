/**
 * Created by phi314 on 17/04/18.
 */

jQuery( function ( $ ) {

    /*
        Load more Activity function
     */
    $('#loadmore').on('click', function (e) {
        var last_activity_id = $(this).val();
        var user_id = $('#user-id').val();
        var mode = $('#mode').val();
        var $loadmoreActivityBtn = $('#loadmore');
        e.preventDefault();

        // prevent double click
        if( $loadmoreActivityBtn.data('requestRunning') ) {
            return;
        }
        $loadmoreActivityBtn.data('requestRunning', true);

        // Ajax Loadmore
        $.ajax({
            type: 'POST',
            url: cimahiwall.ajax_url,
            data: {
                user_id: user_id,
                mode: mode,
                last_activity_id: last_activity_id,
                action: 'load_more_activity'
            },
            beforeSend: function() {
                $loadmoreActivityBtn.text('Loading . . .')
            },
            success: add_activity_to_list,
            complete: function() {
                $loadmoreActivityBtn.data('requestRunning', false);
            }
        });
    });

    /*
        Load more Friends function
     */
    $('.loadmore-friends').on('click', function (e) {
        var user_id = $('#user-id').val();
        var last_user_id = $(this).data('last-user-id');
        var last_follow_id = $(this).data('last-follow-id');
        var follow_type = $('#follow_type').val();
        var $friendsContainer = $('#friends-container-' + follow_type);
        var $loadmoreFriendsBtn = $(this);
        e.preventDefault();

        // prevent double click
        if( $loadmoreFriendsBtn.data('requestRunning') ) {
            return;
        }
        $loadmoreFriendsBtn.data('requestRunning', true);

        // Ajax Loadmore
        $.ajax({
            type: 'POST',
            url: cimahiwall.ajax_url,
            data: {
                follow_type: follow_type,
                last_user_id: last_user_id,
                last_follow_id: last_follow_id,
                user_id: user_id,
                action: 'load_more_friends'
            },
            beforeSend: function() {
                $loadmoreFriendsBtn.text('Loading . . .')
            },
            success: function( data ) {
                add_friends_to_list( data, $friendsContainer )
            },
            complete: function() {
                $loadmoreFriendsBtn.data('requestRunning', false);
            }
        });
    });

    /*
        Append activity after ajax
     */
    function add_activity_to_list( data ) {
        var $loadmoreBtn = $('#loadmore');
        $loadmoreBtn.text('Load more');

        data = $.parseJSON(data);

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
                $templateActivity = $templateActivity.replace(/{activity_id}/g, value.activity_id );
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

    /*
        Append friends after ajax
     */
    function add_friends_to_list( data, $friendsContainer ) {
        var $loadmoreFriendsBtn = $('.loadmore-friends');
        $loadmoreFriendsBtn.text('Load more');

        data = $.parseJSON(data);

        // remove load more button if there is no activity to load more
        if( data.friends_left <= 0) {
            $loadmoreFriendsBtn.remove();
        }

        if( data.result.length > 0) {

            var last_friend = data.result[data.result.length - 1];
            var last_friend_id = last_friend.friend_id;
            var last_follow_id = last_friend.follow_id;
            $loadmoreFriendsBtn.data('last-user-id', last_friend_id); // set last user id to button
            $loadmoreFriendsBtn.data('last-follow-id', last_follow_id); // set last follow id to button

            $.each(data.result, function( index, value ) {
                var $templateFriend = $('#friendTemplate').html();
                $templateFriend = $templateFriend.replace(/{friend_id}/g, value.ID );
                $templateFriend = $templateFriend.replace(/{avatar}/g, value.avatar );
                $templateFriend = $templateFriend.replace(/{user_link}/g, value.user_link );
                $templateFriend = $templateFriend.replace(/{display_name}/g, value.display_name );

                var has_follow = value.has_follow;
                var has_follow_text = 'Follow';
                var unfollow_input = '';
                var has_follow_class = '';
                if( has_follow == true) {
                    has_follow_class = "btn-filled";
                    unfollow_input = "<input type='hidden' name='unfollow'>";
                    has_follow_text = 'Following'
                }
                $templateFriend = $templateFriend.replace(/{has_follow_text}/g, has_follow_text );
                $templateFriend = $templateFriend.replace(/{unfollow_input}/g, unfollow_input );
                $templateFriend = $templateFriend.replace(/{has_follow_class}/g, has_follow_class );

                $friendsContainer.append( $templateFriend );
            });
        }
    }

    /*
        Delete activity
     */
    $('#activity-container').on('click', '.btn-remove-activity', function( e ){
        e.preventDefault();
        var activity_id = $(this).data('activity-id');
        $.ajax({
            type: 'POST',
            url: cimahiwall.ajax_url,
            data: {
                activity_id: activity_id,
                action: 'delete_activity'
            },
            beforeSend: function() {
                var $activity = $('#activity-' + activity_id);
                $activity.hide('slow', function(){ $activity.remove(); });
            }
        });
    });

    /*
        Follow and Unfollow function
     */
    $('body').on('submit', '.form-follow-user', function(e){
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