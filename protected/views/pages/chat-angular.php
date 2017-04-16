<?php

use yii\web\View;
use dee\angularjs\Module;

//use yii\helpers\Html;

/* @var $this View */
$this->registerJsFile('https://www.gstatic.com/firebasejs/3.7.8/firebase.js', ['position' => View::POS_HEAD]);
$firebaseConfig = json_encode(Yii::$app->params['firebase.web.config']);
$credential = json_decode(file_get_contents(Yii::getAlias('@app/config/firebase-credential.json')), true);
$time = time();

$clientId = 'client_' . Yii::$app->profile->id;
$claims = [
    'uid' => $clientId,
    'iss' => $credential['client_email'],
    'sub' => $credential['client_email'],
    "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
    'iat' => $time,
    'exp' => $time + 3600,
];
$token = Firebase\JWT\JWT::encode($claims, $credential['private_key'], 'RS256');
$clientId = json_encode($clientId);
$js = <<<JS
    firebase.initializeApp($firebaseConfig);
    firebase.auth().signInWithCustomToken("$token");
    var webClientId = $clientId;
JS;
$this->registerJs($js, View::POS_HEAD);
list(, $mainUrl) = Yii::$app->getAssetManager()->publish('@app/assets/main');
Module::$moduleAssets['relativeDate'] = $mainUrl . '/js/angular-relative-date.js'
?>
<div ng-app="myApp">
    <?php
    Module::begin([
        'name' => 'myApp',
        'options' => ['ng-controller' => 'ChatController', 'class' => 'row'],
        'preJsFile' => 'js/chat-pre.js',
        'depends' => ['relativeDate'],
        'controllers' => [
            'ChatController' => [
                'sourceFile' => 'controllers/chat-controller.js'
            ]
        ],
        'components' => [
            'chatMessage' => [
                'template' => $this->render('templates/chat-message.php', ['mainUrl' => $mainUrl]),
                'bindings' => [
                    'message' => '<',
                    'user' => '<',
                ]
            ]
        ],
    ])
    ?>
    <div class="col-lg-4 col-lg-offset-8">
        <div class="input-group">
            <input type="text" placeholder="Type Name ..." class="form-control" ng-model="user.val.name">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat" ng-click="setUserName()">Set Name</button>
            </span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Simple Chat</h3>
            </div>
            <div class="box-body">
                <div class="direct-chat-messages">
                    <chat-message ng-repeat="message in messages| orderBy:'time'" message="message" user="getUser(message.uid)"></chat-message>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <textarea type="text" placeholder="Type Message ..." class="form-control" ng-model="inpChat"
                              ng-keypress="send($event)"></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php Module::end(); ?>
</div>