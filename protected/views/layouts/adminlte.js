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
        $.post(opts.changeCollapseUrl, {style: opts.collapse ? 0 : 1});
        opts.collapse = !opts.collapse;
    });
}

