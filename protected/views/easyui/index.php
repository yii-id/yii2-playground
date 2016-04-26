<?php

use yii\web\View;
use app\assets\EasyuiAsset;
use yii\helpers\Url;
use app\classes\widgets\SelectThemeEasyui;

/* @var $this View */
$opts = [
    'dataUrl' => Url::to(['data']),
    'saveUrl' => Url::to(['save']),
    'deleteUrl' => Url::to(['delete']),
];

$this->registerJs('var opts = ' . json_encode($opts) . ';');
EasyuiAsset::register($this);
$this->registerJs($this->render('script.js'));
$css = <<<CSS
#form tr {
    height: 40px;
}
CSS;
$this->registerCss($css);
?>
<table id="dg" style="width: 100%;" toolbar="#dg-toolbar">
    <thead>
        <tr>
            <th field="name" sortable="true" width="180">Nama</th>
            <th field="email" sortable="true" width="160">Email</th>
            <th field="phone" sortable="true" width="160">Telpon</th>
            <th field="keterangan" sortable="true" width="260">Keterangan</th>
        </tr>
    </thead>
</table>
<div id="dg-toolbar">
    <a id="btn-new" iconCls="icon-add">Add</a>
    <a id="btn-edit" iconCls="icon-edit">Edit</a>
    <a id="btn-delete" iconCls="icon-remove">Delete</a>
    <span><input id="inp-search"></span>
    <span style="float: right;"><?= SelectThemeEasyui::widget([
        
    ])?></span>
</div>
<div id="dialog" closed="true" modal="true" title=""
     style="width: 400px;height: auto;">
    <form id="form" method="post">
        <table width="100%">
            <tr>
                <th>Nama</th>
                <td><input name="name" class="easyui-textbox" required="true"></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input name="email" class="easyui-textbox" ></td>
            </tr>
            <tr>
                <th>Telpon</th>
                <td><input name="phone" class="easyui-textbox" ></td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td><input name="keterangan" class="easyui-textbox" ></td>
            </tr>
        </table>
    </form>
</div>