import httpService from "../services/axiosWithCsrfFromMetaTag";
import $ from "jquery";

export default function adminPublishButton(btnClass, dataId, requestFieldName) {
    $(btnClass).click(function (event) {
        const $this = $(event.target);
        const route = $this.attr('data-route');
        const checked = $this.prop('checked') ? 1 : 0;
        const id = $this.closest('tr').data(dataId);
        const $publishedAt = $this.closest('td').siblings('.published_at');

        httpService.put(route, {
            id: id,
            [requestFieldName]: checked
        }).then(function (res) {
            const updatedPost = res.data;

            if (updatedPost[requestFieldName] === 1) {
                $publishedAt.text(updatedPost.published_at);
            } else {
                $publishedAt.text('Not published');
            }
        }).catch(function (e) {
            console.log(e)
        })
    })
}
