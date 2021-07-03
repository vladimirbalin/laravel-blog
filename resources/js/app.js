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
    const id = $this.closest('button').attr('data-id');
    const $svg = $this.closest('button').find('svg');
    const $counter = $(`.likes-count[data-id=${id}]`)[0] ||
        $('#likes-count')[0];

    function plusCounter(responseCount) {
        if ($counter) $counter.textContent = responseCount;
    }

    function minusCounter(responseCount) {
        if ($counter) $counter.textContent = responseCount;
    }

    axios.patch(route, {}).then(function (res) {
        $svg.attr('fill', function (index, attr) {
            if (attr === 'red') {
                minusCounter(res.data.count)
                return 'white';
            } else {
                plusCounter(res.data.count)
                return 'red';
            }
        })
    }).catch(function (e) {
        console.log(e)
    })
})
