<div class="direct-chat-msg right" ng-if="$ctrl.isMe()">
    <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-right">Me</span>
        <span class="direct-chat-timestamp pull-left">{{$ctrl.message.time| relativeDate}}</span>
    </div>
    <img src="<?= Yii::getAlias('@mainUrl') ?>/img/user-me.jpg" class="direct-chat-img">
    <div class="direct-chat-text" ng-bind-html="$ctrl.message.ftext"></div>
</div>
<div class="direct-chat-msg" ng-if="!$ctrl.isMe()">
    <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-left">{{$ctrl.user.val.name}}</span>
        <span class="direct-chat-timestamp pull-right">{{$ctrl.message.time| relativeDate}}</span>
    </div>
    <img src="<?= Yii::getAlias('@mainUrl') ?>/img/user-you.jpg" class="direct-chat-img">
    <div class="direct-chat-text" ng-bind-html="$ctrl.message.ftext"></div>
</div>
<script>
    function () {
        var $ctrl = this;
        $ctrl.isMe = function () {
            return $ctrl.message.uid === webClientId;
        }
    }
</script>