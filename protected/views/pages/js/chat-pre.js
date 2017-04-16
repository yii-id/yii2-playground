myApp.filter('nl2br', ['$sce', function ($sce) {
        return function (msg) {
            var result = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
            return $sce.trustAsHtml(result);
        }
    }]);

myApp.factory('fApplyScope', ['$rootScope', function ($rootScope) {
        return function () {
            if ($rootScope.$$phase != '$apply' && $rootScope.$$phase != '$digest') {
                $rootScope.$apply();
            }
        };
    }]);

myApp.factory('getUser', ['fApplyScope', function (fApplyScope) {
        var users = {};
        return function (uid) {
            if (users[uid] == undefined) {
                users[uid] = {
                    val: {},
                };
                firebase.database().ref('users/' + uid).on('value', function (su) {
                    users[uid].val = su.val() || {};
                    fApplyScope();
                });
            }
            return users[uid];
        };
    }]);