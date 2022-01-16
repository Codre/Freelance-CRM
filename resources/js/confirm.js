$(document).on('click', '.js-confirm', function (e) {
    e.preventDefault();
    var $el = $(this);

    swal({
        title: $el.data('confirm-title') ? $el.data('confirm-title') : translate('errors.confirm.title'),
        text: $el.data('confirm-text') ? $el.data('confirm-text') : null,
        icon: "warning",
        dangerMode: true,
        buttons: [translate('errors.confirm.cancel'), translate('errors.confirm.confirm')],
    })
        .then((willDelete) => {
            if (willDelete) {
                if ($el.attr('type') === 'submit') {
                    $el.closest('form').submit();
                } else {
                    window.location.href = $el.attr('href');
                }
            }
        });
});
