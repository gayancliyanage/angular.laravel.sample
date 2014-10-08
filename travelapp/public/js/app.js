var myApp = angular.module('myApp',[
	'ngRoute',
	'travelControllers'
	]);
myApp.config(['$routeProvider',function($routeProvider){
	$routeProvider.
	when('/logo',{
		templateUrl:'partials/logo.html'
	}).
	when('/list/:strtLoc/:endLoc', {
    templateUrl: 'partials/list.html',
    controller: 'ListController'
 	 }).
	when('/details/:itemId', {
    templateUrl: 'partials/details.html',
    controller: 'DetailsController'
  	}).
  	when('/routes', {
    templateUrl: 'partials/routes.html',
    controller: 'RoutesController'
  	}).
  	when('/routes_detials/:itemId', {
    templateUrl: 'partials/routes_detials.html',
    controller: 'RoutesDetailsController'
  	}).
  	when('/map', {
    templateUrl: 'partials/map.html',
    controller: 'MapController'
  	}).
  	when('/settings', {
    templateUrl: 'partials/settings.html',
    controller: 'SettingsController'
  	}).
	otherwise({
		redirectTo:'/logo'
	});
}]);