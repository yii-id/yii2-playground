$('#btn-preview').click(function () {
    $.post(window.location.url, {
        text: $('#text-input').val()
    }, function (html) {
        $('#pane-preview > div').html(html);
    });
});
$('#btn-save').click(function () {
    $.post(window.location.url, {
        text: $('#text-input').val(),
        action: 'save'
    }, function (html) {
        $('#list-tersimpan').prepend('<div class="list-item">' + html + '</div>');
    });
});
