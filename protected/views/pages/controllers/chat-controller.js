function ($scope, getUser, fApplyScope, $filter) {
    $scope.user = getUser(webClientId);
    $scope.messages = [];
    $scope.inpChat = '';

    firebase.database().ref('messages').orderByKey().limitToLast(100).on('child_added', function (snap) {
        var msg = snap.val();
        msg.key = snap.key;
        msg.ftext = $filter('nl2br')(msg.text);
        $scope.messages.push(msg);
        fApplyScope();
    });

    $scope.send = function ($event) {
        var txt = $scope.inpChat.trim();
        if (txt !== '' && $event.which === 13 && !$event.shiftKey) { //
            firebase.database().ref('messages').push({
                uid: webClientId,
                time:{'.sv':'timestamp'},
                text:txt,
            });
            $scope.inpChat = '';
        }
    }
    
    $scope.getUser = function (uid) {
        return getUser(uid);
    }
}