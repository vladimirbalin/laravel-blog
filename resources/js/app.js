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
