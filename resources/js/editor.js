$(document).ready(function () {
    $('[data-summernote]').each(function () {
        var options = {
            height: 300,
            lang: 'ru-RU'
        };
        if ($(this).data('summernote') == 'airMode') {
            options['airMode'] = true;
        }
        $(this).summernote(options);
    });
});
