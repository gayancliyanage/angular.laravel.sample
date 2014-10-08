var travelControllers = angular.module('travelControllers',['google-maps']);

travelControllers.factory('Service', function() {
 
 var Service = {
   // data_source :'https://54.172.130.168/',
    data_source:'http://127.0.0.1:8000/',
    from:0,
    to:0
  };
 

 return Service;
});

travelControllers.controller('SuggestionsFromController', ['$scope', '$http','$routeParams','Service', function($scope, $http, $routeParams, Service) {
  var url = Service.data_source+'bus_stops';
  $http.get(url).success(function(data) {
       
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
        var url = Service.data_source+'routing_optoins/'+ Service.from;
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


travelControllers.controller('ListController', ['$scope', '$http', '$routeParams','Service', function($scope, $http,$routeParams,Service) {
  
  var url =  Service.data_source+'nearby/'+ $routeParams.strtLoc +'/'+ $routeParams.endLoc;
  $http.get(url).success(function(data) {
    $scope.buses = data;
    $scope.busOrder = 'root';

  });
}]);

travelControllers.controller('DetailsController', ['$scope', '$http','$routeParams','Service', function($scope, $http, $routeParams, Service) {
  var url = Service.data_source +'bus_details/'+$routeParams.itemId;
  $http.get(url).success(function(data) {

    $scope.bus = data;
      console.log($scope.bus);
	});
}]);

travelControllers.controller('RoutesController', ['$scope', '$http','$routeParams','Service', function($scope, $http, $routeParams,Service) {
  var url = Service.data_source +'routes';
  $http.get(url).success(function(data) {
    $scope.roots = data;
    });
}]);


travelControllers.controller('RoutesDetailsController', ['$scope', '$http','$routeParams','Service', function($scope, $http, $routeParams,Service) {
    var url = Service.data_source+'/route_detials/'+ $routeParams.itemId;
  $http.get(url).success(function(data) {
    $scope.buses = data;
    });
}]);

travelControllers.controller('MapController', ['$scope', '$http','$routeParams','Service', function($scope, $http, $routeParams,Service) {
   var url = Service.data_source +'routes';
  $http.get(url).success(function(data) {
    $scope.roots = data;
    });
    $scope.map = {center: {latitude: 1.298321, longitude: 103.788070 }, zoom: 18 }
    $scope.options = {scrollwheel: false};
    $scope.marker = {
            id:0,
            coords: {
                latitude: 1.298321,
                longitude: 103.788070
            },
            options: { draggable: true },
            events: {
                dragend: function (marker, eventName, args) {
                    console.log('marker dragend');
                    console.log(marker.getPosition().lat());
                    console.log(marker.getPosition().lng());
                }
            }
        }
            
}]);

travelControllers.controller('SettingsController', ['$scope', '$http','$routeParams', function($scope, $http, $routeParams) {
  
}]);