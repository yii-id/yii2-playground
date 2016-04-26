<?php

use yii\web\View;
use app\classes\widgets\Source;
use app\classes\widgets\Route;
use app\classes\widgets\Author;

/* @var $this View */
if (empty($this->title)) {
    $config = Route::get();
    if (isset($config)) {
        $this->title = $config['label'];
    }
}
?>
<?php $this->beginContent('@app/views/layouts/adminlte.php'); ?>
<section class="content-header">
    <?= Author::widget() ?>
</section>
<section class="content">
    <div class="box box-default box-solid">
        <div class="box-header"><h3 class="box-title">Output</h3></div>
        <div class="box-body">
            <?= $content ?>
        </div>
    </div>
    <div class="box box-default box-solid">
        <div class="box-header"><h3 class="box-title">Source</h3>
            <div class="box-tools"></div>
        </div>
        <div class="box-body">
            <?= Source::widget() ?>
        </div>
    </div>
</section>

<?php
$this->endContent();
