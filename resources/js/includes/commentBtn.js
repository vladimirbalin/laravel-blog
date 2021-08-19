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
            function publish() {
                $this.text('Published');
                $published_at.text(res.data.published_at);
                $this.attr('data-status', 0);
            }

            function unpublish() {
                $this.text('Draft');
                $this.attr('data-status', 1);
            }

            function switchClasses() {
                let classes = $this.attr('class').split(/\s+/);
                classes = classes.map((className) =>
                    className === 'btn-success' ? 'btn-danger' :
                        className === 'btn-danger' ? 'btn-success' :
                            className)
                $this.attr('class', classes.join(' '));
            }

            switchClasses();
            if (status === 1) {
                publish()
            } else {
                unpublish()
            }
        }).catch(function (e) {
            console.log(e)
        })
    })

}

export default commentBtnClickHandler;
