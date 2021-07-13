require('./bootstrap');

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

$('.like').click(function (event) {
    event.preventDefault();

    let $this = $(this),
        count = $this.attr('data-count'),
        active = $this.hasClass('active'),
        route = $this.closest('button').attr('data-route');

    axios.patch(route, {}).then(function (res) {
        $this.attr('data-count', res.data.count);
        $this.toggleClass('active');
    }).catch(function (e) {
        console.log(e)
    })
})

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
            let classes = $this.attr('class').split(/\s+/);
            classes = classes.map((className) =>
                className === 'btn-success' ? 'btn-danger' :
                    className === 'btn-danger' ? 'btn-success' :
                        className)
            $this.attr('class', classes.join(' '));

            $this.text('Published');
            $published_at.text(res.data.published_at);
            $this.attr('data-status', 0);
        }

        function unpublish() {
            let classes = $this.attr('class').split(/\s+/);
            classes = classes.map((className) =>
                className === 'btn-success' ? 'btn-danger' :
                    className === 'btn-danger' ? 'btn-success' :
                        className)
            $this.attr('class', classes.join(' '));

            $this.text('Draft');
            $this.attr('data-status', 1);
        }

        if (status === 1) {
            publish()
        } else {
            unpublish()
        }
    }).catch(function (e) {
        console.log(e)
    })
})
