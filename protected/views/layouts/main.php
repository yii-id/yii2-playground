<?php

use yii\web\View;

/* @var $this View */
?>
<?php $this->beginContent('@app/views/layouts/adminlte.php'); ?>
<section class="content">
    <?= $content ?>
</section>

<?php
$this->endContent();
