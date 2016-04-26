<?php

use yii\web\View;
use yii\helpers\Markdown;
use yii\helpers\HtmlPurifier;

/* @var $this View */
$request = Yii::$app->getRequest();
// ambil data yg sudah pernah diimput dari cache.
$data = Yii::$app->getCache()->get(__FILE__);
if ($data === false) {
    $data = [];
}
if ($request->getIsAjax()) {
    $this->context->layout = false;
    $text = $request->post('text', '');
    if (strlen($text) > 3426) { // inputnya jangan panjang-panjang. kasihan servernya :D
        $text = substr($text, 0, 3426);
    }
    $text = HtmlPurifier::process(Markdown::process($text, 'mdm'));
    if ($request->post('action') == 'save') { // simpan ke cache
        array_unshift($data, $text); // taruh data baru sebagai yg pertama
        $data = array_slice($data, 0, 5); // ambil hanya 5 data terakhir
        // disimpan di cache aja. wong cuma contoh aja kok :D
        Yii::$app->getCache()->set(__FILE__, $data);
    }
    echo $text;
    return;
}
$this->registerJs($this->render('js/markdown-editor.js'));
?>
<div class="nav-tabs-justified">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#pane-input" data-toggle="tab">Write</a></li>
        <li ><a href="#pane-preview" data-toggle="tab" id="btn-preview">Preview</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="pane-input">
            <div style="padding: 5px;">
                <textarea id="text-input" class="form-control"></textarea>
            </div>
        </div>
        <div class="tab-pane" id="pane-preview">
            <div style="padding: 5px;">
                
            </div>
        </div>
    </div>
</div>
<div>
    <button class="btn btn-success" id="btn-save">Save</button>
</div>

<h3>Data tersimpan:</h3>
<div id="list-tersimpan">
    <?php foreach ($data as $row): ?>
        <div class="list-item"><?= $row; ?></div>
    <?php endforeach; ?>
</div>