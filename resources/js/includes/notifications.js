const NOTIFICATION_TYPES = {
    follow: 'App\\Notifications\\UserFollowedNotification',
    newPost: 'App\\Notifications\\NewPostNotification',
    like: 'App\\Notifications\\BlogPostLikedNotification'
};


function addNotifications(newNotification = {},
                          dbNotifications = [],
                          target,
                          count) {
    const hasNewNotification = !$.isEmptyObject(newNotification);
    const hasDatabaseNotifications = dbNotifications.length;
    if (hasNewNotification) {
        $(target + 'Menu').append(makeNotification(newNotification));
    } else if (hasDatabaseNotifications) {
        let htmlElements = dbNotifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').append(htmlElements.join(''));
    }

    $(target + 'Menu').find('.dropdown-header').text('Last notifications:');
    $(target).addClass('has-notifications')
    $('#quantity-sum').text(count)
    $('.all-read').removeClass('disabled');

    if (!hasDatabaseNotifications && !hasNewNotification) {
        $(target + 'Menu').find('.dropdown-header').html('No notifications');
        $('#quantity-sum').text('')
        $(target).removeClass('has-notifications');
        $('.all-read').addClass('disabled');
    }
}

function makeNotification(notification) {
    let to = routeNotification(notification);
    let notificationText = makeNotificationText(notification);

    return '<li><a class="m-2" href="' + to + '">' + notificationText + '</a></li>';
}

function routeNotification(notification) {
    let to = `?read=${notification.id}`;
    if (notification.type === NOTIFICATION_TYPES.follow) {
        to = 'blog/profile/' + notification.data.follower_id + to;
    } else if (notification.type === NOTIFICATION_TYPES.newPost) {
        const postId = notification.data.post_id;
        to = `blog/posts/${postId}` + to;
    } else if (notification.type === NOTIFICATION_TYPES.like) {
        const postId = notification.data.post_id;
        to = `blog/posts/${postId}` + to;
    }
    return '/' + to;
}

function makeNotificationText(notification) {
    let text = '';
    if (notification.type === NOTIFICATION_TYPES.follow) {
        const name = notification.data.follower_name;
        text += `<strong>${name}</strong> followed you`;
    } else if (notification.type === NOTIFICATION_TYPES.newPost) {
        const name = notification.data.following_name;
        text += `<strong>${name}</strong> published a new post`;
    } else if (notification.type === NOTIFICATION_TYPES.like) {
        const name = notification.data.liker_name;
        const id = notification.data.post_id;
        text += `<strong>${name}</strong> liked your post #${id}`;
    }
    return text;
}

export default addNotifications;
