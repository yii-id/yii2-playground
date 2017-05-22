<i page-title="View {{id}}"></i>
<h1>View {{id}}.</h1> Back to <a  href=".">main</a>
<div>
    <a ng-if="id > 1" ng-href="view/{{id - 1}}">Prev</a>
    &nbsp;
    <a ng-if="id < 6" ng-href="view/{{id + 1}}">Next</a>
</div>
<b>Current Path = {{ $location.path()}}</b>

<script>
    function ($scope, $routeParams, $location) {
        $scope.id = parseInt($routeParams.id, 10);
        $scope.$location = $location;
    }
</script>