<i page-title="Main"></i>
<ul>
    <li ng-repeat="item in items"><a ng-href="view/{{item.id}}">{{item.value}}</a></li>
</ul>
<script>
function ($scope) {
        $scope.items = [
            {id: 1, value: 'Satu'},
            {id: 2, value: 'Dua'},
            {id: 3, value: 'Tiga'},
            {id: 4, value: 'Empat'},
            {id: 5, value: 'Lima'},
            {id: 6, value: 'Enam'},
        ];
    }
</script>