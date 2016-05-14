## Oleh Misbahul D Munir <misbahuldmunir@gmail.com>

`Captcha` dengan persamaan matematik. Install extensionnya dari [mdmsoft/yii2-captcha](https://github.com/mdmsoft/yii2-captcha).
Ada 3 tingkat kesulitan yang bisa dipilih. Untuk mengaturnya bisa dengan menset property level dari `CaptchaAction`
atau dengan menset nilai `Yii::$app->params['mdm.captcha.level']`.

>>app\controllers\SiteController::actions()
>>@app/views/pages/captcha.php#24-34 | html

