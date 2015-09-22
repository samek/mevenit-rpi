'use strict';

/**
 * @ngdoc overview
 * @name mevenboxAngApp
 * @description
 * # mevenboxAngApp
 *
 * Main module of the application.
 */

var MevenBoxApp = angular
  .module('mevenboxAngApp', [
    'ngAnimate',
    'ngAria',
    'ngCookies',
    'ngMessages',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'mevenBoxControllers',

  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'main'
      })
      .when('/connect', {
        templateUrl: '../views/connect.html',
        controller: 'ConnectCtrl',
        controllerAs: 'connect'
      })
      .when('/loading', {
        templateUrl: '../views/loading.html',
        controller: 'LoadingCtrl',
        controllerAs: 'loading'
      })
      .when('/info', {
        templateUrl: '../views/info.html',
        controller: 'InfoCtrl',
        controllerAs: 'info'
      })
      .otherwise({
        redirectTo: '/'
      });
  });


MevenBoxApp.directive('netmask',function(){
  return {
    require: 'ngModel',
    link: function(scope,elem,attrs,ctrl){
      ctrl.$validators.netmask = function (modelValue,viewValue){
        if (ctrl.$isEmpty(modelValue)){
          return true;
        }
        var matcher;
        if ( (matcher = viewValue.match(/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/)) != null){
          var i;
          var availableMasks = ["255","254","252","248","240","224","192","128","0"];
          var previous = "255";
          for(i=1;i<5;i++) {
            if (previous === "255" && ( availableMasks.indexOf(matcher[i]) !== -1 )) {
              previous = matcher[i];
            }
            else {
              if( matcher[i] !== "0"){
                return false;
              }
            }
          }
          return true;
        }
        else{
          return false;
        }
      }
    }
  }
});

MevenBoxApp.directive('ipaddress',function(){
  return {
    require: 'ngModel',
    link: function(scope,elem,attrs,ctrl){
      ctrl.$validators.ipaddress = function (modelValue,viewValue){
        if (ctrl.$isEmpty(modelValue)){
          return true;
        }
        var matcher;
        if ( (matcher = viewValue.match(/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/)) != null){
          var i;
          var previous = "255";
          for(i=1;i<5;i++) {
            var octet =  parseInt(matcher[i]);
            if (octet > 255) return false;
          }
          return true;
        }
        else{
          return false;
        }
      }
    }
  }
});


MevenBoxApp.directive('ngUpdateHidden',function() {
  return function(scope, el, attr) {
    var model = attr['ngModel'];
    scope.$watch(model, function(nv) {
      el.val(nv);
    });

  };
})
