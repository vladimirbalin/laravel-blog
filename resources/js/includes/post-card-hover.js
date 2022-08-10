export default function () {
    const pages = [
        {
            page: 'dashboard',
            classOfLink: '.stretched-link-dashboard',
            parentToPaint: 'tr'
        },
        {
            page: 'posts.index',
            classOfLink: '.stretched-link-post-card',
            parentToPaint: '.card'
        }];

    pages.forEach(function (page) {
        $(page.classOfLink).hover(
            function () {
                $(this).closest(page.parentToPaint).css('background-color', '#e7f0f0')
            },
            function () {
                $(this).closest(page.parentToPaint).css('background-color', 'white')
            }
        )
    })
}
