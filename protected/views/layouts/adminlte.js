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

if(typeof sse == 'undefined'){
    var sse = new EventSource(chatUrl);
    
    sse.addEventListener('unread', function (e) {
    var data = JSON.parse(e.data);
    if (data.count > 0) {
        $('#msg-notif').text(data.count);
        $('#msg-notif').attr('title', data.count + ' pesan baru');
    } else {
        $('#msg-notif').text('');
        $('#msg-notif').attr('title', '');
    }
});
}