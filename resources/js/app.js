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

$('.like_btn').click(function (event) {
    event.preventDefault();

    const $this = $(event.target);
    const route = $this.closest('button').attr('data-route');
    const $svg = $this.closest('button').find('svg');
    const $counter = $('#likes-count')[0];

    function plusCounter() {
        if ($counter) $counter.textContent = parseInt($counter.textContent) + 1;
    }

    function minusCounter() {
        if ($counter) $counter.textContent = parseInt($counter.textContent) - 1;
    }

    axios.patch(route, {}).then(function (res) {
        $svg.attr('fill', function (index, attr) {
            if (attr === 'red') {
                minusCounter()
                return 'white';
            } else {
                plusCounter()
                return 'red';
            }
        })
    }).catch(function (e) {
        console.log(e)
    })
})
