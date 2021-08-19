require('./bootstrap');
import commentBtnClickHandler from "./includes/commentBtn";
import adminPublishBtnHandler from "./includes/adminPublishBtn";
import likeBtnClickHandler from "./includes/likeBtn";
import addNotifications from './includes/notifications';


$(document).ready(function () {
    commentBtnClickHandler();
    adminPublishBtnHandler();
    likeBtnClickHandler();
    if (Laravel.userId) {
        $.get(Laravel.notificationsRoute, function (data) {
            addNotifications(data, "#notifications");
        });
    }
});




