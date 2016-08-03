<?php

use yii\web\View;

//use yii\helpers\Html;

/* @var $this View */
$js = <<<'JS'
new Vue({
    el: '#inp-notif',
    data: {msg:''},
    methods: {
        addMsg: function(){
            if(this.msg.trim()){
                vNotif.pushMsg(this.msg);
                this.msg = '';
            }
        }
    }
});
JS;
$this->registerJs($js, View::POS_END);
?>
<div class="input-group col-sm-6" id="inp-notif">
    <input type="text" class="form-control" v-model="msg" v-on:keypress.enter="addMsg">
    <span class="input-group-btn">
        <button type="button" class="btn btn-info btn-flat" v-on:click="addMsg">Add Massage</button>
    </span>
</div>

