'use strict'

var app = angular.module("myApp", []);

app.controller('mainCtrl', ['$scope', function ($scope) {
    // ...
}]);

app.controller('itemCtrl', ['$scope', function ($scope) {
    $scope.items = [{id: 1}];

    $scope.addRecord = function () {
        var newItemNo = $scope.items.length + 1;
        $scope.items.push({'id': newItemNo});
    };

    $scope.removeRecord = function ($index) {
        $scope.items.splice($index, 1);
    };
}]);
