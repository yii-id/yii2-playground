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
            <th field="code" sortable="true" width="180">Code</th>
            <th field="name" sortable="true" width="160">Name Product</th>
            <th field="category_id" sortable="true" width="160">Category</th>
            <th field="status" sortable="true" width="260">Status</th>
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
                <th>Code</th>
                <td><input name="code" class="easyui-textbox" required="true"></td>
            </tr>
            <tr>
                <th>Name Product</th>
                <td><input name="name" class="easyui-textbox" ></td>
            </tr>
            <tr>
                <th>Kategori Id</th>
                <td><input name="category_id" class="easyui-textbox" ></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><input name="status" class="easyui-textbox" ></td>
            </tr>
        </table>
    </form>
</div>