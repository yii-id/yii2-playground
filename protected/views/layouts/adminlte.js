function skinAdmin(opts) {
    $('#select-skin').change(function () {
        $.post(opts.changeSkinUrl, {
            style: $('#select-skin').val(),
        }, function (r) {
            $('body').removeClass(opts.skin)
                .addClass('skin-' + r);
            opts.skin = 'skin-' + r;
        })
    });

    $($.AdminLTE.options.sidebarToggleSelector).click(function () {
        opts.collapse = opts.collapse == 'yes' ? 'no' : 'yes';
        $.post(opts.changeCollapseUrl, {style: opts.collapse});
    });
}

