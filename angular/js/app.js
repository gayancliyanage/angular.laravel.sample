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
	otherwise({
		redirectTo:'/logo'
	});
}]);