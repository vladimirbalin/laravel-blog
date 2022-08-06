import httpService from "../services/axiosWithCsrfFromMetaTag";

export default function likeBtn() {
    $('.like').click(function (event) {
        event.preventDefault();

        let $this = $(this),
            route = $this.closest('button').attr('data-route');

        httpService.patch(route, {}).then(function (res) {
            $this.attr('data-count', res.data.count);
            $this.toggleClass('active');
        }).catch(function (e) {
            console.log(e)
        })
    })
}
