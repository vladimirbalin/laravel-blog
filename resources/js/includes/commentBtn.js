function commentBtnClickHandler() {
    $('.publish_comment_btn').click(function (event) {
        event.preventDefault();

        let $this = $(this),
            route = $this.attr('href'),
            status = parseInt($this.attr('data-status')),
            id = parseInt($this.attr('data-comment')),
            $published_at = $('#published_at-' + id);


        axios.patch(route, {
            status: status
        }).then(function (res) {

            function showPublishBtn() {
                $this.removeClass('btn-danger');
                $this.addClass('btn-success');
                $this.text('Published');
                $published_at.text(res.data.published_at);
                $this.attr('data-status', 0);
            }

            function showUnpublishBtn() {
                $this.removeClass('btn-success');
                $this.addClass('btn-danger');
                $this.text('Draft');
                $this.attr('data-status', 1);
            }

            if (parseInt(res.data.status) === 0) {
                showUnpublishBtn();
            } else {
                showPublishBtn();
            }
        }).catch(function (e) {
            console.log(e)
        })
    })

}

export default commentBtnClickHandler;
