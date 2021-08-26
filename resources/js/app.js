import notifications from "./includes/notifications";

require('./bootstrap');
import commentBtnClickHandler from "./includes/commentBtn";
import adminPublishBtnHandler from "./includes/adminPublishBtn";
import likeBtnClickHandler from "./includes/likeBtn";
import addNotifications from './includes/notifications';


$(document).ready(function () {
    commentBtnClickHandler();
    adminPublishBtnHandler();
    likeBtnClickHandler();
    if (window.Laravel && window.Laravel.userId) {

        axios.get('/blog/notifications')
            .then(res => {
                let count = res.data.count,
                    databaseNotifications = res.data.lastFive,
                    target = '#notifications';

                addNotifications({}, databaseNotifications, target, count)
                console.log(typeof databaseNotifications)
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


