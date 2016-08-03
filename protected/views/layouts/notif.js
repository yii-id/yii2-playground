notifData = {
    msgs: []
};
vNotif = new Vue({
    el:'#notif-push',
    data:notifData,
    methods: {
        read:function(i){
            this.msgs.splice(i,1);
            return false;
        },
        readAll:function (){
            this.msgs = [];
            return false;
        },
        pushMsg:function (msg){
            this.msgs.push(msg);
        }
    }
});

