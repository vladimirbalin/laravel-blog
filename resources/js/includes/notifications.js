let notifications = [];

const NOTIFICATION_TYPES = {
    follow: 'App\\Notifications\\UserFollowed',
    newPost: 'App\\Notifications\\NewPost',
    like: 'App\\Notifications\\BlogPostLiked'
};


function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    notifications.slice(0, 5);

    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if (notifications.length) {
        let htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
        $('#quantity-sum').text(notifications.length)
    } else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
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
        const name = notification.data.liked_user_name;
        text += `<strong>${name}</strong> liked your post`;
    }
    return text;
}

export default addNotifications;
