/**
 * Copyright 2014 Bruce Ingalls
 * global angular
 */

angular.module('bookmarkApp', [
  'ngCookies',
  'angular-md5',
  'controllers'
]);

//module.run(function($http) {
//  $httpProvider.defaults.headers.post = 'Content-Type: application/json';
//});

angular.module('controllers', [])
  .controller('AddCtrl', ['$scope', '$http', function ($scope, $http) {
      "use strict";
      $scope.addBm = function () {
        $http({method: 'GET', url: './views/add.php'})
          .success(function () {
            $scope.addmsg = 'bookmark added';
            //listBm();  //requires a service
        }).error(function () {
            $scope.addmsg = 'Failed to add bookmark';
        });
      };
    }])
  .controller('BmCtrl', ['$scope', '$cookies', function ($scope, $cookies) {
      "use strict";
      if (!$cookies.bmid) {
        $scope.bmsg = 'No user ID found. must set email:';
      }
    }])
  .controller('EmailCtrl', ['$scope', 'md5', '$cookies', function ($scope, md5, $cookies) {
      "use strict";
      $scope.addEmail = function () {
        var hash = md5.createHash($scope.email || '');
        $scope.emailmsg = 'Set your email as an ID';
        $cookies.bmid = hash;   //must match app/bookmark.php
      };
    }])
  //ToDo: turn this into a service
  .controller('ListCtrl', ['$scope', '$http', function ($scope, $http) {
      "use strict";
        $scope.listBm = function() {
          $http.defaults.headers.post["Content-Type"] = 'Content-Type: application/json';
          $http({method: 'POST', url: './views/list.php'})
          .success(function (data) {
            $scope.listmsg = data;
          }).error(function () {
            $scope.listmsg = 'Bookmarks cannot be listed';
          });
        };
    }])
  ;

