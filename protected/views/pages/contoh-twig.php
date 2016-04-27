<?php

use yii\web\View;
use app\models\ContactInfo;

/* @var $this View */
?>
<?php
$id = Yii::$app->getRequest()->get('id');
if ($id) {
    $model = ContactInfo::findOne($id);
}
if (!isset($model)) {
    $model = new ContactInfo();
}
if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
    // kalau sudah tersimpan, redirect
    Yii::$app->getResponse()->redirect(['site/page', 'view' => 'contoh-twig']);
    return;
}

// list data terakhir
$contacts = ContactInfo::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();
echo $this->render('twig/index.twig', ['contacts' => $contacts]);

// view data terakhir
$contact = ContactInfo::find()->orderBy(['id' => SORT_DESC])->one();
echo $this->render('twig/view.twig', ['contact' => $contact]);

// form
echo $this->render('twig/form.twig', ['model' => $model]);
