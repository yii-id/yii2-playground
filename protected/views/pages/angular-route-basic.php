<?php
use yii\web\View;
use dee\angularjs\NgRoute;
//use yii\helpers\Html;
/* @var $this View */

$preJs = <<<JS
test.directive('pageTitle', function () {
    return {
        restrict: 'A',
        scope: {
            pageTitle: '@'
        },
        link: function (scope) {
            jQuery('title').text(scope.pageTitle);
        }
    };
});
JS;
?>
<div ng-app="test">
    <?=
    NgRoute::widget([
        'name' => 'test',
        'html5Mode' => true,
        'baseUrl' => 'angular-route-basic/',
        'preJs' => $preJs,
        'routes' => [
            '/' => [
                'templateFile' => 'templates/basic-main.php',
            ],
            '/view/:id' => [
                'templateFile' => 'templates/basic-view.php',
            ],
            '*' => [
                'redirectTo' => '/',
            ],
        ],
    ])
    ?>
</div>