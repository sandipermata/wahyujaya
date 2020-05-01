angular.module('starter', ['starter.controllers','starter.services','ngIdle', 'ngMap', 'angularUtils.directives.dirPagination','ngCsv','ngFileUpload','ngSanitize'])

.config(function (KeepaliveProvider, IdleProvider) {
	IdleProvider.idle(1800); //dalam detik => 5 = 5 detik
	IdleProvider.timeout(1800);
	KeepaliveProvider.interval(10);
})

.run(function($rootScope, $http, $interval, $timeout, $window, Idle, Keepalive, $templateCache) {
	
	//remove cache for all templates
	$rootScope.$on('$viewContentLoaded', function(){
		$templateCache.removeAll();
	});
	
	//iddle timeout
  $rootScope.started = false;
	function closeModals() {
		$rootScope.warning = null;
		$rootScope.timedout = null;
	}
	 	 
	$rootScope.$on('IdleStart', function() {
		//$("#idleModal").modal('show');
	});
	 
	$rootScope.$on('IdleEnd', function() {
	localStorage.setItem('LoginInfo', '[]');
		$("#idleModal").modal('hide');
	});
	 
	$rootScope.$on('IdleTimeout', function() {
	localStorage.setItem('LoginInfo', '[]');
		$("#idleModal").modal('hide');
	});
	 
	$rootScope.start = function() {
		Idle.watch();
		$rootScope.started = true;
	};

	$rootScope.stop = function() {
		Idle.unwatch();
		$rootScope.started = false;
	};	
	
	Idle.watch();

//======================================================================================//
  var protocol = location.protocol;
  var host = location.host;
  var pathname = location.pathname;

  var base_url = protocol + '//' + host + pathname.split("index.php")[0];
	var site_url = base_url + 'index.php/';
	var url 	 = base_url + 'api/index.php';
	var img_url	 = base_url + 'api/img/';
		
	$rootScope.host 	= host;
	$rootScope.base_url = base_url;
	$rootScope.site_url = site_url;
	$rootScope.api_url  = site_url + "api";
	$rootScope.hashKey  = "00043eb6617434cc5f357bbf692e53be";

	$rootScope.testValue = "hahaha";

	$rootScope.online = navigator.onLine;
	
	//login information
	$rootScope.parseJson = [];
	$rootScope.AllInfo = localStorage.getItem('LoginInfo');
	if(!$rootScope.AllInfo || $rootScope.AllInfo == '[]'){
		$rootScope.parseJson = [];
	}else{
		$rootScope.parseJson = JSON.parse($rootScope.AllInfo)[0];
		
		$rootScope.LoginId     = $rootScope.parseJson.LoginId;
		$rootScope.LoginName   = $rootScope.parseJson.LoginName;
		$rootScope.LoginPass   = $rootScope.parseJson.LoginPass;
		$rootScope.LoginLevel  = $rootScope.parseJson.LoginLevel;
		$rootScope.LoginImage  = $rootScope.parseJson.LoginImage;
		$rootScope.LoginActive = $rootScope.parseJson.LoginActive;
		$rootScope.LoginTitle  = $rootScope.parseJson.LoginTitle;
		$rootScope.LoginStatus = $rootScope.parseJson.LoginStatus;
	
	}

	$rootScope.logout = function(){
		localStorage.clear();
		$window.location = $rootScope.site_url + "login";
	};
	
//======================================================================================//
	$rootScope.times = "00:00:00";
	
	$rootScope.getDateTime = function(){
		var currentTime = new Date();
		
		// returns the month (from 0 to 11)
		var month = currentTime.getMonth() + 1;
		if(month < 10){month = "0"+month;}else{month = month;}
		
		// returns the day of the month (from 1 to 31)
		var day = currentTime.getDate();
		if(day < 10){day = "0"+day;}else{day = day;}
		
		// returns the year (four digits)
		var year = currentTime.getFullYear();
		$rootScope.fulldate  = year + "-" + month +"-"+ day ;
		$rootScope.dateInput = day.toString() + month.toString() + year.toString().substr(2,2);
		
		var jam = currentTime.getHours();
		if(jam < 10 ){ jam = "0"+jam;}else{jam = jam;}
		
		var minu = currentTime.getMinutes();
		if(minu < 10 ){ minu = "0"+minu; }else{ minu = minu; }
		
		var sec = currentTime.getSeconds();
		if(sec < 10 ){ sec = "0"+sec; }else{ sec = sec; }
		
		$rootScope.times = jam+":"+minu+":"+sec;
	};
	$interval(function(){
		$rootScope.getDateTime();
	},1000);


	$rootScope.getMenu = function(user){
		$http.get($rootScope.api_url+'/menus', { "headers": { "x-token": $rootScope.hashKey }})
		.then(function(res){
			$rootScope.menus = res.data;
		});
	};
	$rootScope.getMenu("");


})


.directive('numberFormat', ['$filter', '$parse', function ($filter, $parse) {
  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ngModelController) {

      var decimals = $parse(attrs.decimals)(scope);

      ngModelController.$parsers.push(function (data) {
        var parsed = parseFloat(data);
        return !isNaN(parsed) ? parsed : 0;
      });
      
      ngModelController.$formatters.push(function (data) {
        //convert data from model format to view format
        return $filter('number')(data, decimals); //converted
      });

      element.bind('focus', function () {
        element.val(ngModelController.$modelValue);
      });

      element.bind('blur', function () {
        // Apply formatting on the stored model value for display
        var formatted = $filter('number')(ngModelController.$modelValue, decimals);
        element.val(formatted);
      });
    }
  };
}])

.directive('chosen', function(){
	var linker = function(scope, element, attr){
		scope.$watch('list', function(){
			element.trigger('chosen:updated');
		});
		element.chosen();
	};
	
	return{
		restrict:'A',
		link : linker
	};
})

.directive('capitalize', function() {
	return {
		require: 'ngModel',
		link: function(scope, element, attrs, modelCtrl) {
			var capitalize = function(inputValue) {
				if (!inputValue) inputValue = '';
				var capitalized = inputValue.toUpperCase();
				if (capitalized !== inputValue) {
					modelCtrl.$setViewValue(capitalized);
					modelCtrl.$render();
				}
				return capitalized;
			};
			modelCtrl.$parsers.push(capitalize);
			capitalize(scope[attrs.ngModel]); // capitalize initial value
		}
	};
})

.directive('capitalizeFirst', function() {
	return {
		require: 'ngModel',
		link: function(scope, element, attrs, modelCtrl) {
			var capitalize = function(inputValue) {
				if (!inputValue) inputValue = '';
				//capitalize first sentences
				var capitalized = inputValue.charAt(0).toUpperCase() + inputValue.substr(1).toLowerCase();
				if (capitalized !== inputValue) {
					modelCtrl.$setViewValue(capitalized);
					modelCtrl.$render();
				}
				return capitalized;
			};
			modelCtrl.$parsers.push(capitalize);
			capitalize(scope[attrs.ngModel]); // capitalize initial value
		}
	};
})


.directive('selectall', ['$window', function ($window) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.on('click', function () {
                if (!$window.getSelection().toString()) {
                    // Required for mobile Safari
                    this.setSelectionRange(0, this.value.length);
                }
            });
        }
    };
}])

.filter('split', function() {
	return function(input, splitChar, splitIndex) {
		// do some bounds checking here to ensure it has that index
		return input.split(splitChar)[splitIndex];
	};
})

.directive('disallowSpaces', function() {
  return {
    restrict: 'A',

    link: function($scope, $element) {
      $element.bind('input', function() {
        $(this).val($(this).val().replace(/ /g, ''));
      });
    }
  };
})

;