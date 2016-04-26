
String.prototype.addParam = function (params) {
    return this + (/\?/.test(this) ? '&' : '?') + $.param(params);
}

$('#dg').datagrid({
    singleSelect: true,
    method: 'get',
    rownumbers: true,
    url: opts.dataUrl,
    pagination: true,
});

$('#btn-new').linkbutton({
    onClick: function () {
        opts.action = 'new';
        opts.row = undefined;
        $('#form').form('clear');
        $('#dialog').dialog('open');
    }
});
$('#btn-edit').linkbutton({
    onClick: function () {
        opts.row = $('#dg').datagrid('getSelected');
        if (opts.row) {
            opts.action = 'edit';
            $('#form').form('load', opts.row);
            $('#dialog').dialog('open');
        }
    }
});
$('#btn-delete').linkbutton({
    onClick: function () {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Confirm', 'Yakin akan menghapus ini?', function (r) {
                if (r) {
                    var url = opts.deleteUrl.addParam({id: row.id});
                    $.post(url, {}, function (data) {
                        if (data.type == 'error') {
                            $.messager.alert('Alert', data.message, 'alert');
                        } else {
                            $('#dg').datagrid('reload');
                        }
                    });
                }
            });
        }
    }
});
// search
$('#inp-search').keypress(function (e) {
    if (e.which == 13) { // jika enter
        $('#dg').datagrid('reload', {
            q: $('#inp-search').val(),
        });
    }
});

$('#form').form({
    iframe: false,
    success: function (data) {
        if (data.type == 'error') {
            $.messager.alert('Alert', data.message, 'alert');
        } else {
            $('#dg').datagrid('reload');
        }
        opts.row = undefined;
        $('#dialog').dialog('close');
    }
});
$('#dialog').dialog({
    buttons: [{
            text: 'Save',
            iconCls: 'icon-save',
            handler: function () {
                var url = opts.saveUrl;
                if (opts.action == 'edit') {
                    url = url.addParam({id: opts.row.id})
                }
                $('#form').form('submit', {
                    url: url,
                });

            }
        }, {
            text: 'Cancel',
            iconCls: 'icon-cancel',
            handler: function () {
                $('#dialog').dialog('close');
            }
        }]
});