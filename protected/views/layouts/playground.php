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
        <div class="box-header"><h3 class="box-title">Output</h3>
            <div class="box-tools pull-right">
                <a href="#disqus_thread" class="btn btn-box-tool"><i class="fa fa-comments-o"></i></a>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?= $content ?>
        </div>
    </div>
    <div class="box box-default box-solid">
        <div class="box-header"><h3 class="box-title">Source</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?= Source::widget() ?>
        </div>
    </div>
</section>

<?php
$this->endContent();
