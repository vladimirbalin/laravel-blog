require('./bootstrap');

import adminPublishButton from "./includes/admin-publish-btn";
import likeBtn from "./includes/like-btn";
import addNotifications from './includes/notifications';
import cardHover from './includes/post-card-hover';


$(document).ready(function () {
    adminPublishButton('.is_published', 'post-id', 'is_published');
    adminPublishButton('.status', 'comment-id', 'status');
    likeBtn();
    cardHover();

    if (window.Laravel && window.Laravel.userId) {
        axios.get('/blog/notifications')
            .then(res => {
                let count = res.data.count,
                    databaseNotifications = res.data.lastFive,
                    target = '#notifications';

                addNotifications({}, databaseNotifications, target, count)

                window.Echo.private(`user.${window.Laravel.userId}`)
                    .notification(function (newNotification) {
                        addNotifications(newNotification, databaseNotifications, target, ++count);
                    });
            })
            .catch(e => {
                console.log(e)
            })
    }
});


