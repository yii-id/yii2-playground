$('#check-all').change(function (){
    $('#migration-list .check').prop('checked',$(this).prop('checked'));
});

$('#migration-list .check').change(function (){
    $('#check-all').prop('checked',$('#migration-list .check').length == $('#migration-list .check:checked').length);
});