function adminPublishBtnHandler() {
    $('.is_published').click(function (event) {
        const $this = $(event.target);
        const route = $this.attr('data-route');
        const checked = $this.prop('checked') ? 1 : 0;
        const id = $this.closest('tr').data('id');

        axios.put(route, {
            id: id,
            is_published: checked
        }).then(function (res) {
            $this.closest('tr').css('background-color', checked === 1 ? '' : '#ececec');
        }).catch(function (e) {
            console.log(e)
        })
    })
}

export default adminPublishBtnHandler;
