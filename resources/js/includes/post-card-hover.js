export default function () {
    $('.stretched-link').hover(
        function () {
            $(this).parent().parent().css('background-color', '#e7f0f0')
        },
        function () {
            $(this).parent().parent().css('background-color', 'white')
        }
    )
}
