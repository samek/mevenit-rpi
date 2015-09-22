'use strict';

/**
 * @ngdoc function
 * @name mevenboxAngApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the mevenboxAngApp
 */

var mevenBoxControllers = angular.module('mevenBoxControllers', []);
var hostname="http://10.0.1.3:8000";
//var hostname='http://private-38c7f8-mevenbox.apiary-mock.com';
mevenBoxControllers.controller('MainCtrl', ['$scope', '$http','$interval','$location',
    function($scope, $http,$interval,$location) {

      $scope.online = null;
      $scope.status = null;

      $scope.reboot = reboot;
      $scope.updateDevice = updateDevice;
      $scope.factoryReset = factoryReset;
      $scope.resetNetwork = resetNetwork;

      activate();

      ////

      function activate() {
        getData();
        getStatus();
      }


      function reboot() {
        $http.get(hostname+'/api/device/reboot').success(ActionData);
      }

      function resetNetwork() {
        $http.get(hostname+'/api/device/resetnetwork').success(ActionData);
      }

      function updateDevice() {
        $http.get(hostname+'/api/status/online').success(ActionData);
      }

      function factoryReset() {
        $http.get(hostname+'/api/device/factoryreset').success(ActionData);
      }

      function update() {
        $http.get(hostname+'/api/device/update').success(ActionData);
      }

      function ActionData(data) {
        $scope.action = data.data;
        console.log('Action',$scope.action);
        $location.path('loading');
      }


      function getData() {
        $http.get(hostname+'/api/status/online').success(dataLoaded);
      }

      function getStatus() {
        $http.get(hostname+'/api/status/').success(StatusDataLoaded);
      }

      function dataLoaded(data) {
        $scope.online = data.data.connected;
        console.log('Online',$scope.online);
      }

      function StatusDataLoaded(data) {
        $scope.status = data.data;
        $scope.eth    = data.data.network.interfaces_default.settings.eth0;
        $scope.wlan   = data.data.network.interfaces_default.settings.wlan0;
        console.log('Status',$scope.status);
      }




      $interval(function(){
        getStatus();
      }.bind(this), 5000);

    }
  ]
);






mevenBoxControllers.controller('FormWifiController', ['$scope', '$http','$interval','$location',
    function($scope, $http,$interval,$location) {

      $scope.master = {};
      $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
      $scope.update = function(wlan) {
        $scope.master = angular.copy(wlan);
        $scope.master.dev='wlan0';
        console.log('mother fucker',wlan);
        //$http.post(hostname+'/api/network/setup/', {msg:$scope.master}).success(dataPosted);
        $http({
          method : 'POST',
          url : hostname+'/api/network/setup/',
          data : $scope.master
        }).success(dataPosted);
      };

      $scope.reset = function() {
        $scope.wlan = angular.copy($scope.master);
      };

      $scope.reset();

      function dataPosted(data) {
        //$scope.online = data.data.connected;
        console.log('POST DELA');
        $location.path('loading');
      }

    }
  ]
);


mevenBoxControllers.controller('FormEthController', ['$scope', '$http','$interval','$location',
    function($scope, $http,$interval,$location) {
      $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
      $scope.master = {};
      $scope.master.dhcp=1;



      //$scope.eth.dhcp=0;

      $scope.update = function(eth) {
        $scope.master = angular.copy(eth);
        $scope.master.dev='eth0';
        //console.log('mother fucker',eth);
       // $http.get(hostname+'/api/network/setup/', {msg:eth}).success(dataPosted);

        $http({
          method : 'POST',
          url : hostname+'/api/network/setup/',
          data : $scope.master
        }).success(dataPosted);

      };

      $scope.reset = function() {
        $scope.eth = angular.copy($scope.master);
      };

      $scope.reset();

      function dataPosted(data) {
        //$scope.online = data.data.connected;
        console.log('POST DELA',data);
        $location.path('loading');
      }

    }
  ]
);


mevenBoxControllers.controller('ConnectCtrl', ['$scope', '$http','$interval','$window',
    function($scope, $http,$interval,$window) {

      $scope.online = null;
      $scope.status = null;

      activate();

      ////

      function activate() {
        getData();

      }


      function getData() {
        $http.get(hostname+'/api/pair').success(dataLoaded);
      }


      function dataLoaded(data) {
        $scope.pair = data.data;
        if (data.data.status==1) {
          $window.location.href=data.data.slideshowUrl;
        }
        console.log('Pair',$scope.pair);
      }



      $interval(function(){
        getData();
      }.bind(this), 5000);

    }
  ]
);


mevenBoxControllers.controller('InfoCtrl', ['$scope', '$http','$interval','$window',
    function($scope, $http,$interval,$window) {


      $scope.info = null;

      activate();

      ////

      function activate() {
        getData();

      }


      function getData() {
        $http.get(hostname+'/api/settings').success(dataLoaded);
      }


      function dataLoaded(data) {
        $scope.info = data.data;

      }

    }
  ]
);



mevenBoxControllers.controller('LoadingCtrl', ['$scope', '$http','$interval','$window',
    function($scope, $http,$interval,$window) {




    }
  ]
);
