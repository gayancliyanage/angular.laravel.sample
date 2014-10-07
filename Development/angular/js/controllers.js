var travelControllers = angular.module('travelControllers',[]);

travelControllers.factory('Service', function() {
 
 var Service = {
    from:0,
    to:0
  };
 
 return Service;
});

travelControllers.controller('SuggestionsFromController', ['$scope', '$http','$routeParams','Service', function($scope, $http, $routeParams, Service) {
  
  $http.get('http://54.172.130.168/bus_stops').success(function(data) {
       
       $scope.suggestions = data;    
        $scope.sugShow = false;
    });

  	$scope.clickFromLocation = function clickFromLocation()
     {
     	$scope.sugShow = true;
     	$scope.toShow = false;
     };
     $scope.selectFromLocation = function selectFromLocation($id, $fromLocation)
     {
        Service.from = $id;
     	$scope.sugShow = false;
     	$scope.formLocation = $fromLocation;
     	$scope.fromLocationID = $id;
     
     };
   
}]);

travelControllers.controller('SuggestionsToController', ['$scope', '$http','Service', function($scope, $http,  Service) {
  
    
    $scope.clickToLocation = function clickToLocation()
    {
        var url = 'http://54.172.130.168/routing_optoins/'+ Service.from;
        $http.get(url).success(function(data) {
         $scope.toSuggestions = data;    
         $scope.toShow = true;
    	});
    };
     $scope.selectToLocation = function selectToLocation($id, $toLocation)
     {
     	$scope.toShow = false;
     	$scope.toLocation = $toLocation;
     	$scope.toLocationID = $id;
     	Service.to = $id;
     };
     $scope.toLocationListLeave = function toLocationListLeave()
     {
     	$scope.toShow = false;
     }
     
}]);

travelControllers.controller('SearchController', ['$scope', '$http','Service', function($scope, $http,Service) {

    $scope.to = Service.to;
    $scope.from = Service.from;
    $scope.SearchButtonClick = function SearchButtonClick()
    {
    	$scope.changeRoute('#/list/'+Service.from+'/'+Service.to); 
	}

	$scope.changeRoute = function(url, forceReload) {
	    $scope = $scope || angular.element(document).scope();
	    if(forceReload || $scope.$$phase) { 
	        window.location = url;
	    } else {
	        $location.path(url);
	        $scope.$apply();
	    }
	};
}]);


travelControllers.controller('ListController', ['$scope', '$http', '$routeParams',function($scope, $http,$routeParams) {
  
  var url =  'http://54.172.130.168/nearby/'+ $routeParams.strtLoc +'/'+ $routeParams.endLoc;
  $http.get(url).success(function(data) {
    $scope.buses = data;
    $scope.busOrder = 'root';

  });
}]);

travelControllers.controller('DetailsController', ['$scope', '$http','$routeParams', function($scope, $http, $routeParams) {
  $http.get('js/data.json').success(function(data) {
    $scope.buses = data;
	});
}]);