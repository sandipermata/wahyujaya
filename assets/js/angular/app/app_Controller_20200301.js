angular.module('starter.controllers', [])

.filter('exclude', function() {
	return function(input, exclude, prop) {
		if (!angular.isArray(input))
			return input;

		if (!angular.isArray(exclude))
			exclude = [];

		if (prop) {
			exclude = exclude.map(function byProp(item) {
				return item[prop];
			});
		}

		return input.filter(function byExclude(item) {
			return exclude.indexOf(prop ? item[prop] : item) === -1;
		});
	};
})

.filter('_uriseg', function($location, $rootScope) {
	return function(segment) {
		var BASE_URL = $rootScope.base_url;
	  // Get URI and remove the domain base url global var
	  var query = $location.absUrl().replace(BASE_URL,"");
	  // To obj
	  var data = query.split("/");    
	  // Return segment *segments are 1,2,3 keys are 0,1,2
	  if(data[segment-1]) {
	  	return data[segment-1];
	  }
	  return false;
	};
})

.controller('loginCtrl',function($rootScope, $scope, $http, NewTrans, LoginSrv, $interval, $window){

	$scope.testCache = "ini cache ubah lagi ya -----  asdasda";

	$scope.rsatu = 'single';
	
	$rootScope.loadLogin = false;
	$rootScope.infoError = "";
	$scope.login = function(usr, pass){
		$rootScope.loadLogin = true;
		if(!usr || !pass){
			$rootScope.infoError = "Username or Password is blank";
			$rootScope.loadLogin = false;
		}else{
			$rootScope.infoError = "";
			LoginSrv.login(usr, pass).then(function(response){
				var res = response.data;

				if(res.kind == "success"){
					if(res.data.length > 0){
						$scope.LoginInfo = [
						{
							LoginId     : res.data[0].adm_code,
							LoginName   : res.data[0].adm_name,
							LoginPass   : res.data[0].adm_pass,
							LoginLevel  : res.data[0].adm_level,
							LoginImage  : res.data[0].adm_image,
							LoginActive : "Y", //res.data[0].usr_active,
							LoginTitle  : res.data[0].adm_level,
							LoginStatus : true,
						}];

						localStorage.setItem('LoginInfo', JSON.stringify($scope.LoginInfo));
						$rootScope.loadLogin = false;

						NewTrans.setSession("loginId", res.data[0].adm_code).then(function(res){
							$window.location = $rootScope.site_url; //+ "dashboard";
						});

					}else{
						$rootScope.infoError = "Username or Password is incorrect";
						$rootScope.loadLogin = false;						
					}
				}else{
					$rootScope.infoError = res.kind + " | " + res.description;
					$rootScope.loadLogin = false;
				}
			});
		}
	};

	$scope.keyLogin = function($event, usr, pass){
		if($event.keyCode == '13'){
			$scope.login(usr, pass);
		}
	};


	$scope.ask_to_show = false;
	$scope.askToShow = function(){
		$scope.ask_to_show = true;
	};

	$scope.askToHide = function(){
		$scope.ask_to_show = false;
		console.log("fired " + $scope.ask_to_show);
	};


})

.controller('schCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}
	
	$scope.welcome = "Dashboard";
	$rootScope.centerLocLat = -6.2148819;
	$rootScope.centerLocLon = 106.7412135;
	$rootScope.centerZoom = 5 ;

	$scope.getDash = function(){
		$scope.dash = null;
		NewTrans.getDashSum().then(function(res){
			var result = res.data;
			if(result.data.length > 0){
				$scope.dash_ews = result.data[0];
			}else{
				$scope.dash_ews = [];				
			}
		});

		NewTrans.getDashSumTL().then(function(ress){
			var results = ress.data;
			if(results.data.length > 0){
				$scope.dash_tl = results.data[0];				
			}else{
				$scope.dash_tl = [];
			}

			console.log($scope.dash_tl);
		});

		NewTrans.getDashSumWL().then(function(ress){
			var results = ress.data;
			if(results.data.length > 0){
				$scope.dash_wl = results.data[0];				
			}else{
				$scope.dash_wl = [];
			}

			console.log($scope.dash_tl);
		});


	};
	$scope.getDash();

	$scope.inputEWS = function() {
		NewTrans.parsingEWS().then(
			function(res){
				var result = res.data;
				console.log("=== input ews success ===");
				console.log(JSON.stringify(result));
				$scope.getDash();
			},
			function(err){
				console.log("=== input ews error ===");
				console.log(JSON.stringify(err));
			}
		);
	};
	$scope.inputEWS();

	$interval(function(){
		$scope.inputEWS();
	},30000);

	$scope.inputTL = function() {
		NewTrans.parsingTL().then(
			function(res){
				var result = res.data;
				console.log("=== input TL success ===");
				console.log(JSON.stringify(result));
				$scope.getDash();
			},
			function(err){
				console.log("=== input TL error ===");
				console.log(err);
			}
		);
	};
	$scope.inputTL();

	$interval(function(){
		$scope.inputTL();
	},30000);	


	$scope.inputWL = function() {
		NewTrans.parsingWL().then(
			function(res){
				var result = res.data;
				console.log("=== input WL success ===");
				console.log(JSON.stringify(result));
				$scope.getDash();
			},
			function(err){
				console.log("=== input WL error ===");
				console.log(err);
			}
		);
	};
	$scope.inputWL();

	$interval(function(){
		$scope.inputWL();
	},30000);	


})

.controller('dashCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){

	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		if($scope.page_single_code == 'single'){
			//no login needed
		}else{
			$window.location = $rootScope.site_url + "login";			
		}
	}
	

	$scope.welcome = "Dashboard";
	$rootScope.centerLocLat = -6.2148819;
	$rootScope.centerLocLon = 106.7412135;
	$rootScope.centerZoom = 5 ;

	$scope.is_show = false;
	$scope.kabupaten = [];
	$scope.kecamatan = [];

	$scope.map_code = "";

	function CustomMarker(latlng, map, imageSrc, geoLat, geoLon, ipaddr, alamat, pole) {
		this.latlng_ = latlng;
		this.imageSrc = imageSrc;
		this.geoLats = geoLat;
		this.geoLons = geoLon;
		this.ipaddrId = ipaddr;
		this.alamat = alamat;
		this.pole = pole;

		// Once the LatLng and text are set, add the overlay to the map.  This will
		// trigger a call to panes_changed which should in turn call draw.
		this.setMap(map);
	}

	$scope.showMap = function(kode){
		if(kode == "wl"){
			$scope.is_show = false;
		}else{
			$scope.is_show = true;
		}
		$scope.map_code = kode;

		$scope.stopEwsTl();
		$scope.stopIntTl();
		$scope.stopIntPlay();

		$rootScope.posisi = [];

		$scope.getProvince();
		$scope.kabupaten = [];
		$scope.kecamatan = [];

		$rootScope.centerLocLat = -6.2148819;
		$rootScope.centerLocLon = 106.7412135;
		$rootScope.centerZoom = 5 ;

	};

	//$scope.showMap($scope.map_code);

	$scope.areaKec = "all";
	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();

	$("#s_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#s_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#s_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.areaKec = id;
		//select data header from database
		$scope.generateMaps(id);
		$scope.stopEwsTl();

	});

	$scope.getWLProject = function(){
		NewTrans.getWLProject().then(function(res){
			var result = res.data;
			$scope.projects = result.data;
		});
	};
	$scope.getWLProject();

	$scope.wlProj = "all";
	$("#s_proj").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.wlProj = id;
		//select data header from database
		$scope.generateMaps($scope.areaKec);
		$scope.stopEwsTl();

	});

	$scope.generateMaps = function(id){
		if($scope.map_code == "tl"){
			$scope.stopIntTl();
			var locations = [];
			NewTrans.getHeadPosisiTL(id).then(function(res){
				var result = res.data;

				if(result.data.length > 0){
					if(id == "all"){
						$rootScope.centerLocLat = -2.548926;
						$rootScope.centerLocLon = 118.0148634;
						$rootScope.centerZoom = 5;
					}else{
						$rootScope.centerLocLat = result.data[0].tfc_loc_lat;
						$rootScope.centerLocLon = result.data[0].tfc_loc_lon;
						$rootScope.centerZoom = 12;
					}

					$rootScope.posisi = result.data;

					var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

					angular.forEach(result.data, function(value, key){
						locations.push({
							lat: value.tfc_loc_lat,
							lng: value.tfc_loc_lon,
							ipaddr: value.tfc_sn
						});
					});

					var map = new google.maps.Map(document.getElementById("map0"), {
						//scrollwheel : false,
						//gestureHandling : 'greedy',
						zoom: $rootScope.centerZoom,
						center: new google.maps.LatLng($rootScope.centerLocLat, $rootScope.centerLocLon),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					var markers = locations.map(function(location, i) {
						return new google.maps.Marker({
							position: location,
							label: location.ipaddr,
							animation: google.maps.Animation.BOUNCE
							//label: labels[i % labels.length]
						});
					});

					// Add a marker clusterer to manage the markers.
					var markerCluster = new MarkerClusterer(
						map, 
						markers,
						{
							imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
						}
					);

					angular.forEach(markers, function(value, key){
						markers[key].addListener('click', function() {
							console.log("halloo => " + markers[key].getLabel());
							var pos = {
								ipaddr : markers[key].getLabel(),
								alamat : "desc.id",
								pole : "pole.id"
							};
							$scope.showContent(event, pos);
						});
					});

				}else{
					alertify.error("Belum ada data untuk lokasi ini");
				}

			});
		}else if($scope.map_code == "ews"){
			var locationsews = [];
			NewTrans.getHeadPosisiEws(id).then(function(res){
				var result = res.data;
				if(result.data.length > 0){

					if(id == "all"){
						$rootScope.centerLocLat = -2.548926;
						$rootScope.centerLocLon = 118.0148634;
						$rootScope.centerZoom = 5;
					}else{
						$rootScope.centerLocLat = result.data[0].ews_loc_lat;
						$rootScope.centerLocLon = result.data[0].ews_loc_lon;
						$rootScope.centerZoom = 12;
					}

					$rootScope.posisi = result.data;

					var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

					angular.forEach(result.data, function(value, key){
						locationsews.push({
							lat: value.ews_loc_lat,
							lng: value.ews_loc_lon,
							ipaddr: value.ews_ip.toString(),
							arah: value.ews_arah,
							lama: value.lama,
							jml: value.jml,
							rpt: value.rpt
						});
					});

					var map = new google.maps.Map(document.getElementById("map0"), {
						//scrollwheel : false,
						//gestureHandling : 'greedy',
						zoom: $rootScope.centerZoom,
						center: new google.maps.LatLng($rootScope.centerLocLat, $rootScope.centerLocLon),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					var markers = locationsews.map(function(location, i) {
						if(location.jml < 1){
							return new google.maps.Marker({
								position: location,
								label: location.ipaddr,
								icon: {
									//url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
									url: $rootScope.base_url + "image/marker_hitam_kecil.png" 
								}
							});
						}else{
							var rep = location.rpt[0];
							// "ews_battery_percent": 0,
							// "ews_arah": "LEFT",
							// "ews_status_sensor_L": "FAIL",
							// "ews_status_sensor_C": "OK",
							// "ews_status_sensor_R": "OK",
							// "ews_suhu_confan": "28.30\/27.80",
							// "ews_teg_out_sirine": 10.48,
							// "ews_arus_lam_stop": 0.01,
							// "ews_arus_lam_flash": "",
							// "ews_arus_lam_left": "",
							// "ews_arus_lam_right": 0,
							// "ews_arus_speaker": "",
							// "lampu_merah": "RUSAK",
							// "lampu_kuning": "OFF",
							// "arah_icon": "kiri",
							// "lampu_arah": "kiri_rusak",
							// "speaker": "RUSAK"
							if(rep.lampu_merah == "RUSAK" || rep.lampu_kuning == "RUSAK" || rep.lampu_arah == "rusak" || rep.speaker == "RUSAK" ){
								return new google.maps.Marker({
									position: location,
									label: location.ipaddr,
									icon: {
										//url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
										url: $rootScope.base_url + "image/marker_merah_kecil.png" 
									}
								});
							} else {
								if(rep.ews_arah != "NONE"){
									return new google.maps.Marker({
										position: location,
										label: location.ipaddr,
										animation: google.maps.Animation.BOUNCE,
										icon: {
											//url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
											url: $rootScope.base_url + "image/marker_orange_kecil.png" 
										}
									});
								}else{
									return new google.maps.Marker({
										position: location,
										label: location.ipaddr,
										icon: {
											///url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
											url: $rootScope.base_url + "image/marker_hijau_kecil.png" 
										}
									});									
								}

							}

						}

					});

					// Add a marker clusterer to manage the markers.
					var markerCluster = new MarkerClusterer(
						map, 
						markers,
						{
							imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
						}
					);

					angular.forEach(markers, function(value, key){
						markers[key].addListener('click', function() {
							var pos = {
								ipaddr : markers[key].getLabel(),
								alamat : "desc.id",
								pole : "pole.id"
							};
							$scope.showContent(event, pos);
						});
					});

				}else{
					alertify.error("Belum ada data untuk lokasi ini");
				}

			});
		}else if($scope.map_code == "wl"){
			var locationswl = [];
			var proj = "all";
			if($scope.wlProj != "all"){
				proj = $scope.wlProj;
			}
			NewTrans.getHeadPosisiWL(id, proj).then(function(res){
				var result = res.data;
				if(result.data.length > 0){

					if(id == "all"){
						$rootScope.centerLocLat = -2.548926;
						$rootScope.centerLocLon = 118.0148634;
						$rootScope.centerZoom = 5;
					}else{
						$rootScope.centerLocLat = result.data[0].wl_loc_lat;
						$rootScope.centerLocLon = result.data[0].wl_loc_lon;
						$rootScope.centerZoom = 12;
					}

					$rootScope.posisi = result.data;

					var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

					angular.forEach(result.data, function(value, key){
						locationswl.push({
							lat: value.wl_loc_lat,
							lng: value.wl_loc_lon,
							ipaddr: value.wl_sn.toString()
						});
					});

					var map = new google.maps.Map(document.getElementById("map0"), {
						//scrollwheel : false,
						//gestureHandling : 'greedy',
						zoom: $rootScope.centerZoom,
						center: new google.maps.LatLng($rootScope.centerLocLat, $rootScope.centerLocLon),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					var markers = locationswl.map(function(location, i) {
						return new google.maps.Marker({
							position: location,
							label: location.ipaddr,
							animation: google.maps.Animation.BOUNCE
							//label: labels[i % labels.length]
						});
					});

					// Add a marker clusterer to manage the markers.
					var markerCluster = new MarkerClusterer(
						map, 
						markers,
						{
							imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
						}
					);

					angular.forEach(markers, function(value, key){
						markers[key].addListener('click', function() {
							console.log("halloo => " + markers[key].getLabel());
							var pos = {
								ipaddr : markers[key].getLabel(),
								alamat : "desc.id",
								pole : "pole.id"
							};
							$scope.showContent(event, pos);
						});
					});


				}else{
					alertify.error("Belum ada data untuk lokasi ini");
				}

			});

		}
	};

	$scope.generateMaps_old = function(id){
		if($scope.map_code == "tl"){
			$scope.stopIntTl();
			NewTrans.getHeadPosisiTL(id).then(function(res){
				var result = res.data;

				if(result.data.length > 0){
					if(id == "all"){
						$rootScope.centerLocLat = -2.548926;
						$rootScope.centerLocLon = 118.0148634;
						$rootScope.centerZoom = 5;
					}else{
						$rootScope.centerLocLat = result.data[0].tfc_loc_lat;
						$rootScope.centerLocLon = result.data[0].tfc_loc_lon;
						$rootScope.centerZoom = 12;
					}

					$rootScope.posisi = result.data;

					//===========================================================
					var data = [];

					CustomMarker.prototype = new google.maps.OverlayView();
					CustomMarker.prototype.draw = function () {
						// Check if the div has been created.
						var div = this.div_;
						if (!div) {
							// Create a overlay text DIV
							div = this.div_ = document.createElement('div');
							// Create the DIV representing our CustomMarker

							div.className = 'customMarker';

							var marker = document.createElement("span");
							marker.id = this.markerId;

							var desc = document.createElement("span");
							desc.id = this.alamat;

							var newLatLng = this.getPosition();
							var latlngStr = (newLatLng).toString().replace("(","").replace(")","");
							var latlngSplit = latlngStr.split(",");

							var geolat = document.createElement("span");
							geolat.id = latlngSplit[0];

							var geolong = document.createElement("span");
							geolong.id = latlngSplit[1];

							var pole = document.createElement("span");
							pole.id = this.pole;

							var ipaddr = document.createElement("span");
							ipaddr.id = this.ipaddrId;

							ipaddr.style.content = ''; 
							ipaddr.style.position  = 'absolute'; 
							ipaddr.style.bottom = '-4px'; 
							ipaddr.style.left = '5px'; 
							ipaddr.style.borderWidth = '5px 5px 0'; 
							ipaddr.style.borderStyle = 'solid'; 
							ipaddr.style.display = 'block'; 
							ipaddr.style.width = '0';

							div.style.position = 'absolute';
							div.style.cursor = 'pointer';
							div.style.width = '20px';
							div.style.height = '20px';
							div.style.padding = '0px';
							div.style.borderRadius = '120px';

							div.style.background = '#800000';
							ipaddr.style.borderColor = '#800000 transparent'; 

							/*
							if(actstore.id == "OFF" && (dateupdate.id).substr(0,10) == $rootScope.fulldate){
								div.style.background = '#800000';
								ipaddr.style.borderColor = '#800000 transparent';
							}else if(!actstore.id || (dateupdate.id).substr(0,10) != $rootScope.fulldate){
								div.style.background = '#424242';
								longitude.style.borderColor = '#424242 transparent'; 
							}else{
								div.style.background = '#00BF9A';
								longitude.style.borderColor = '#00BF9A transparent'; 
							}
							*/

							div.appendChild(marker);
							div.appendChild(ipaddr);
							div.appendChild(geolat);
							div.appendChild(geolong);

							//var img = document.createElement("img");
							var img = document.createElement("span");
							//img.src = this.imageSrc;
							//img.className = "markerImg";
							img.onerror = function(){
								//img.src = $rootScope.base_url + "/image/icons/noimage.png";
								//return true;
							};

							div.appendChild(img);
							google.maps.event.addDomListener(div, "click", function (event) {
								//$scope.showContent(event, latitude.id, longitude.id, fullname.id, img.src, dateupdate.id, marker.id, act_desc.id, act_rmks.id, outName.id);

								if($rootScope.centerZoom == "5"){
									$rootScope.centerZoom = "18";
									map.setZoom(18);
									map.setCenter(new google.maps.LatLng(geolat.id, geolong.id));
								}else{
									var pos = {
										ipaddr : ipaddr.id,
										alamat : desc.id,
										pole : pole.id
									};
									$scope.showContent(event, pos);
								}

							});

							img.style.width = '15px';
							img.style.height = '15px';
							img.style.margin = '2px';
							img.style.borderRadius = '150px';

							// Then add the overlay to the DOM
							var panes = this.getPanes();
							panes.overlayImage.appendChild(div);
						}

						// Position the overlay 
						var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
						if (point) {
							div.style.left = (point.x - 10) + 'px';
							div.style.top = (point.y - 20) + 'px';
						}
					};

					CustomMarker.prototype.remove = function () {
						// Check if the overlay was on the map and needs to be removed.
						if (this.div_) {
							this.div_.parentNode.removeChild(this.div_);
							this.div_ = null;
						}
					};

					CustomMarker.prototype.getPosition = function () {
						return this.latlng_;
					};

					var map = new google.maps.Map(document.getElementById("map0"), {
						//scrollwheel : false,
						//gestureHandling : 'greedy',
						zoom: $rootScope.centerZoom,
						center: new google.maps.LatLng($rootScope.centerLocLat, $rootScope.centerLocLon),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					var profileimg = "";
					angular.forEach(result.data, function(value, key){

						data.push({
							profileImage : $rootScope.base_url + "/image/icons/" + value.icon_image ,
							pos : [value.tfc_loc_lat, value.tfc_loc_lon],
							geolat : value.tfc_loc_lat,
							geolong : value.tfc_loc_lon,
							ipaddr : value.tfc_sn,
							alamat : value.tfc_loc_desc,
							pole : value.tfc_pole,
						});
					});

					for(var i=0;i<data.length;i++){
						new CustomMarker(
							new google.maps.LatLng(data[i].pos[0],data[i].pos[1]), 
							map,  
							data[i].profileImage,
							data[i].geolat, 
							data[i].geolong, 
							data[i].ipaddr,
							data[i].alamat,
							data[i].pole
						);
					}

					//===========================================================

				}else{
					alertify.error("Belum ada data untuk lokasi ini");
				}

			});
		}else if($scope.map_code == "ews"){
			NewTrans.getHeadPosisiEws(id).then(function(res){
				var result = res.data;

				if(result.data.length > 0){

					if(id == "all"){
						$rootScope.centerLocLat = -2.548926;
						$rootScope.centerLocLon = 118.0148634;
						$rootScope.centerZoom = 5;
					}else{
						$rootScope.centerLocLat = result.data[0].ews_loc_lat;
						$rootScope.centerLocLon = result.data[0].ews_loc_lon;
						$rootScope.centerZoom = 12;
					}

					$rootScope.posisi = result.data;

					//===========================================================
					var data = [];

					CustomMarker.prototype = new google.maps.OverlayView();
					CustomMarker.prototype.draw = function () {
						// Check if the div has been created.
						var div = this.div_;
						if (!div) {
							// Create a overlay text DIV
							div = this.div_ = document.createElement('div');
							// Create the DIV representing our CustomMarker

							div.className = 'customMarker';

							var marker = document.createElement("span");
							marker.id = this.markerId;

							var desc = document.createElement("span");
							desc.id = this.alamat;

							var pole = document.createElement("span");
							pole.id = this.pole;

							var newLatLng = this.getPosition();
							var latlngStr = (newLatLng).toString().replace("(","").replace(")","");
							var latlngSplit = latlngStr.split(",");

							var geolat = document.createElement("span");
							geolat.id = latlngSplit[0];

							var geolong = document.createElement("span");
							geolong.id = latlngSplit[1];

							var ipaddr = document.createElement("span");
							ipaddr.id = this.ipaddrId;

							ipaddr.style.content = ''; 
							ipaddr.style.position  = 'absolute'; 
							ipaddr.style.bottom = '-4px'; 
							ipaddr.style.left = '5px'; 
							ipaddr.style.borderWidth = '5px 5px 0'; 
							ipaddr.style.borderStyle = 'solid'; 
							ipaddr.style.display = 'block'; 
							ipaddr.style.width = '0';

							div.style.position = 'absolute';
							div.style.cursor = 'pointer';
							div.style.width = '20px';
							div.style.height = '20px';
							div.style.padding = '0px';
							div.style.borderRadius = '120px';

							div.style.background = '#800000';
							ipaddr.style.borderColor = '#800000 transparent'; 

							/*
							if(actstore.id == "OFF" && (dateupdate.id).substr(0,10) == $rootScope.fulldate){
								div.style.background = '#800000';
								ipaddr.style.borderColor = '#800000 transparent';
							}else if(!actstore.id || (dateupdate.id).substr(0,10) != $rootScope.fulldate){
								div.style.background = '#424242';
								longitude.style.borderColor = '#424242 transparent'; 
							}else{
								div.style.background = '#00BF9A';
								longitude.style.borderColor = '#00BF9A transparent'; 
							}
							*/

							div.appendChild(marker);
							div.appendChild(ipaddr);
							div.appendChild(geolat);
							div.appendChild(geolong);

							var img = document.createElement("span");
							//var img = document.createElement("img");
							//img.src = this.imageSrc;
							img.className = "markerImg";
							img.onerror = function(){
								//img.src = $rootScope.img_url + "noimages.jpg";
								//return true;
							};

							div.appendChild(img);
							google.maps.event.addDomListener(div, "click", function (event) {
								//$scope.showContent(event, latitude.id, longitude.id, fullname.id, img.src, dateupdate.id, marker.id, act_desc.id, act_rmks.id, outName.id);
								if($rootScope.centerZoom == "5"){
									$rootScope.centerZoom = "18";
									map.setZoom(18);
									map.setCenter(new google.maps.LatLng(geolat.id, geolong.id));
								}else{
									var pos = {
										ipaddr : ipaddr.id,
										alamat : desc.id,
										pole : pole.id
									};
									$scope.showContent(event, pos);
								}
								//alertify.alert(ipaddr.id);
							});

							img.style.width = '15px';
							img.style.height = '15px';
							img.style.margin = '2px';
							img.style.borderRadius = '150px';

							// Then add the overlay to the DOM
							var panes = this.getPanes();
							panes.overlayImage.appendChild(div);
						}

						// Position the overlay 
						var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
						if (point) {
							div.style.left = (point.x - 10) + 'px';
							div.style.top = (point.y - 20) + 'px';
						}
					};

					CustomMarker.prototype.remove = function () {
						// Check if the overlay was on the map and needs to be removed.
						if (this.div_) {
							this.div_.parentNode.removeChild(this.div_);
							this.div_ = null;
						}
					};

					CustomMarker.prototype.getPosition = function () {
						return this.latlng_;
					};

					var map = new google.maps.Map(document.getElementById("map0"), {
						//scrollwheel : false,
						//gestureHandling : 'greedy',
						zoom: $rootScope.centerZoom,
						center: new google.maps.LatLng($rootScope.centerLocLat, $rootScope.centerLocLon),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					var profileimg = "";
					angular.forEach(result.data, function(value, key){

						data.push({
							profileImage : $rootScope.base_url + "/image/icons/" + value.icon_image ,
							pos : [value.ews_loc_lat, value.ews_loc_lon],
							geolat : value.ews_loc_lat,
							geolong : value.ews_loc_lon,
							ipaddr : value.ews_ip,
							alamat : value.ews_loc_desc,
							pole : value.ews_pole,
						});
					});

					for(var i=0;i<data.length;i++){
						new CustomMarker(
							new google.maps.LatLng(data[i].pos[0],data[i].pos[1]), 
							map,  
							data[i].profileImage,
							data[i].geolat, 
							data[i].geolong, 
							data[i].ipaddr,
							data[i].alamat,
							data[i].pole
						);
					}

					//===========================================================
					map.addListener('center_changed', function() {
						// 3 seconds after the center of the map has changed, pan back to the
						// marker.
						console.log("zoom changed " + map.getZoom());
					});

					//===========================================================

				}else{
					alertify.error("Belum ada data untuk lokasi ini");
				}

			});
		}
	};
	$timeout(function() {
		$scope.generateMaps("all");		
	}, 1000);

	$scope.showContent = function(event, pos){
		$("#modal_detail").modal("show");
		if($scope.map_code == "tl"){
			$scope.is_warning = false;
			NewTrans.getTrafficId(pos.ipaddr).then(function(res){
				var result = res.data;

				result.data[0].tfc_loc_desc = pos.alamat;
				result.data[0].pole = pos.pole;

				$scope.data_pos = result.data[0];
				$scope.tfcIP = pos.ipaddr;
				$scope.stopIntTl();
				$scope.start_counting(pos.ipaddr);
			});
		}else if($scope.map_code == "ews"){

			console.log(JSON.stringify(pos));

			NewTrans.getArahKereta(pos.ipaddr).then(function(res){
				var result = res.data;
				var arah = "" ;//result.data[0].ews_arah;
				$scope.data_pos = [];

				if(result.data.length > 0){
					arah = result.data[0].ews_arah;
					$scope.data_pos = result.data[0];
				}

				$scope.stopEwsTl(arah);
				$scope.playVideo(arah);
				$scope.ewsIP = pos.ipaddr ;
				$scope.ewsArah = arah || "NONE" ;
				//$scope.start_counting_ews(pos.ipaddr);

			});
		}else if($scope.map_code == "pju"){
			$scope.start_counting_pju();
		}else {
			// $scope.start_counting_wl();

			$scope.img_pole = "image/wl/warning_normal_half.gif";

			NewTrans.getWlDashId(pos.ipaddr).then(function(res){
				var result = res.data;
				// result.data[0].wl_loc_desc = pos.alamat;
				// result.data[0].pole = pos.pole;
				$scope.data_pos = result.data;
				$scope.wlIP = pos.ipaddr;
				// $scope.stopIntTl();
				// $scope.start_counting(pos.ipaddr);
			});
		}

		$scope.is_played = true;
	};

	var intWL;
	var intTimer;
	$scope.setMode = function(mode){
		if(mode == "1"){
			$scope.img_pole = "image/wl/warning_normal_half.gif";
		}else if(mode == "2"){
			$scope.img_pole = "image/wl/warning_double_normal.gif";
		}else{
			$scope.img_pole = "image/wl/warning_group_half.gif";
		}
		$scope.stopIntWl();
	};

	$scope.startIntWl = function(jml){
		$scope.show = true;
		$scope.stopIntWl();
		$scope.writeTimer();

		$scope.img_pole = "image/wl/warning_light_down.png";
		intWL = $interval(function(){
			if($scope.show){
				$scope.show = false;
				$scope.img_pole = "image/wl/warning_light_up.png";
			}else{
				$scope.show = true;
				$scope.img_pole = "image/wl/warning_light_down.png";
			}
		}, jml * 1000);
	};

	$scope.stopIntWl = function(){		
		$interval.cancel(intWL);
		$interval.cancel(intTimer);
	};

	$scope.writeTimer = function(){
		$interval.cancel(intTimer);
		$scope.timers = 0;
		intTimer = $interval(function(){
			$scope.timers++;
		},1000);
	};


	var ews_tl;
	$scope.start_counting_ews = function(ip){
		NewTrans.getPosisiEws(ip).then(function(res){
			var result = res.data;
			$rootScope.posisi2 = result.data;
			var posisi = result.data;

			$scope.data_pos = posisi[0];
			//console.log(posisi);

			var sum_data = 0;
			var list = [];
			angular.forEach(posisi, function(value, key){
				sum_data += value.ews_duration;
				list.push({
					"data" : sum_data
				});
			});

			var x = sum_data;
			var t = 0;

			$rootScope.total_time_ews = 47; //posisi[t].ews_duration;

			var isPlaying = document.getElementById("myAudio");
			$scope.is_played = false;
			ews_tl = $interval(function(){
				if($scope.is_played){
					//isPlaying.play();
				}

				if(x > 0 ){
					x--;


					if(x === 30 ){
						posisi[0].ews_status = "nol";
					}

					if(x == 22 ){
						posisi[0].ews_status = "satu";
					}

					if(x == 16 ){
						posisi[0].ews_status = "dua";
					}

					if(x == 7 ){
						posisi[0].ews_status = "tiga";
					}

					if(x === 0 ){
						posisi[0].ews_status = "nol";
						$scope.stopEwsTl();
						$rootScope.total_time_ews += 0;

						isPlaying.pause();
						isPlaying.currentTime = 0;

					}
					$rootScope.total_time_ews--;
				}
			},1000);

		});
	};

	$scope.start_counting_pju = function(){
		NewTrans.getPosisiPju().then(function(res){
			var result = res.data;
			$rootScope.posisi = result.data;
			var posisi = result.data;
		});
	};

	$scope.start_counting_wl = function(){
		NewTrans.getPosisiWl().then(function(res){
			var result = res.data;
			$rootScope.posisi = result.data;
			var posisi = result.data;
		});
	};

	$scope.panjang = false;
	$scope.pendek = false;
	$scope.is_warning = false;
	$scope.nilai = 0;

	$scope.changeTimer = function(code, pole){
		var flash = document.getElementById("flash");
		var hold = document.getElementById("hold");
		var skip = document.getElementById("skip");

		if(code == "warn"){
			if(flash.checked){
				$scope.panjang = false;
				$scope.pendek = false;
				$scope.is_warning = true;
				$scope.nilai = 0;

				$scope.stopIntTl();
				$rootScope.total_time = 0;
			}else{
				$scope.is_warning = false;
				$scope.start_counting($scope.tfcIP);
			}

			hold.checked = false;
			skip.checked = false;

		}else{
			alertify.prompt("Confirmation","Silahkan masukkan nilai untuk perpanjangan / perpendekan !", "0",
				function(e, value){
					//console.log(value);
					$scope.is_warning = false;

					//$scope.pole = pole;
					var ubah = [];
					if(code == "plus"){
						data = {
							tfc_sn_d : $scope.tfcIP,
							tfc_pole : $scope.pole,
							tfc_status : 'nyala',
							tfc_G1 : ($rootScope.total_time * 1) + (value * 1)
						};

						flash.checked = false;
						skip.checked = false;

					}else if(code == 'minus'){
						data = {
							tfc_sn_d : $scope.tfcIP,
							tfc_pole : $scope.pole,
							tfc_status : 'nyala',
							tfc_G1 : 3
						};
						flash.checked = false;
						hold.checked = false;
					}

					NewTrans.updateDataTL(data).then(function(res){
						var result = res.data;
						if(result.kind == "success"){
							$scope.stopIntTl();
							$scope.start_counting($scope.tfcIP);
						}
					});

				},
				function() {
					if(code == 'plus'){
						hold.checked = false;
					}else if(code == 'minus'){
						skip.checked = false;
					}
					//console.log("cancel");
				});
		}
	};

	var int_tl;
	$scope.all_time = 0;
	$scope.start_counting = function(ip){
		NewTrans.getPosisiTL(ip).then(function(res){
			var result = res.data;
			$rootScope.posisi = result.data;
			var posisi = result.data;

			var sum_data = 0;
			var list = [];
			angular.forEach(posisi, function(value, key){
				sum_data += value.tfc_duration;
				list.push({
					"data" : sum_data
				});
			});

			var pos = posisi.map(function(e) { return e.tfc_status; }).indexOf('nyala');
			//console.log("pos : " + pos);
			var awal = 0;
			//console.log(pos);
			if (pos === 0){
				awal = 0;
			}else{
				awal = list[pos-1].data;
			}
			var x = awal;
			var t = pos;
			$scope.pole = posisi[t].tfc_pole;
			$scope.gambar_nyala = posisi[t].tfc_pole + "_ijo";
			$scope.gambar_nya = posisi[t].tfc_g_image;
			$scope.gambar_flash = posisi[t].img_flash;

			$rootScope.total_time = posisi[t].tfc_duration;
			int_tl = $interval(function(){

				if(x < sum_data){
					x++;
					$scope.all_time = x;
					//console.log("data_" + x + " => " + list[t].data);
					if(x == (list[t].data * 1 ) - 4 ){
						if(t < list.length - 1){
							posisi[t].tfc_status = "kuning";
							posisi[t+1].tfc_status = "kuning";
						}else{
							posisi[t].tfc_status = "kuning";
							posisi[0].tfc_status = "kuning";							
						}
					}

					if(t < posisi.length){
						//console.log("x : " + x + " p : " + ((list[t].data * 1) - 4) );
						if(x == (list[t].data * 1 ) - 4){
							if(t < list.length - 1){
								posisi[t+1].tfc_status = "kuning";
								posisi[t].tfc_status = "kuning";

								$scope.gambar_nyala = posisi[t].tfc_pole + "_kuning";
								$scope.gambar_nya = posisi[t].tfc_r_image;
							}
						}

						if(x == list[t].data){
							//console.log("data_child_" + t);
							posisi[list.length - 1].tfc_status = "mati";
							if(t < list.length - 1){
								posisi[t+1].tfc_status = "nyala";
								posisi[t].tfc_status = "mati";

								$scope.pole = posisi[t+1].tfc_pole;
								//alertify.success(posisi[t+1].tfc_pole); //ini kunci nya
								$scope.gambar_nyala = posisi[t+1].tfc_pole + "_ijo";
								$rootScope.total_time = posisi[t+1].tfc_duration;
								$scope.gambar_nya = posisi[t+1].tfc_g_image;
								//$scope.gambar_nya = posisi[t].tfc_r_image;
							}
							t++;
						}
					}

					if(sum_data - x == 4){
						//solve here
						$scope.gambar_nya = posisi[t].tfc_r_image;
					}

					if(x == sum_data){
						var reset = {
							tfc_sn_d : $scope.tfcIP,
							tfc_pole : "A",
							tfc_status : 'nyala',
							tfc_G1 : '0'
						};

						var flash = document.getElementById("flash");
						var hold = document.getElementById("hold");
						var skip = document.getElementById("skip");

						flash.checked = false;
						hold.checked = false;
						skip.checked = false;

						NewTrans.updateDataTL(reset).then(function(res){
							var result = res.data;
							if(result.kind == "success"){
								$scope.stopIntTl();
								$scope.start_counting($scope.tfcIP);
								$rootScope.total_time = posisi[0].tfc_duration;
							}
						});
						//$scope.start_counting("114.199.113.123");
					}
					$rootScope.total_time--;
				}
			},1000);

		});
	};
	//$scope.start_counting();

	$scope.start_counting_ori = function(ip){
		NewTrans.getPosisiTL(ip).then(function(res){
			var result = res.data;
			$rootScope.posisi = result.data;
			var posisi = result.data;

			var sum_data = 0;
			var list = [];
			angular.forEach(posisi, function(value, key){
				sum_data += value.tfc_duration;
				list.push({
					"data" : sum_data
				});
			});

			var pos = posisi.map(function(e) { return e.tfc_status; }).indexOf('nyala');
			var x = 0;
			var t = pos;

			//console.log("pos : " + pos);
			$rootScope.total_time = posisi[t].tfc_duration;
			int_tl = $interval(function(){


				if(x < sum_data){
					//console.log("data_" + x);
					x++;
					//console.log(x + " => " + posisi[t].tfc_duration);

					//console.log("sum_data_" + sum_data);
					if(x == (posisi[t].tfc_duration * 1 ) - 4 ){
						posisi[t].tfc_status = "kuning";
						posisi[t + 1].tfc_status = "kuning";
					}

					if(t < posisi.length){
						//console.log("x : " + x + " p : " + ((list[t].data * 1) - 4) );
						if(x == (posisi[t].tfc_duration * 1 ) - 4){
							if(t < posisi.length - 1){
								posisi[t+1].tfc_status = "kuning";
								posisi[t].tfc_status = "kuning";
							}
						}

						if(x == list[t].data){
							//console.log("data_child_" + t);
							posisi[list.length - 1].tfc_status = "mati";
							if(t < list.length - 1){
								posisi[t+1].tfc_status = "nyala";
								posisi[t].tfc_status = "mati";

								$scope.pole = posisi[t+1].tfc_pole;
								alertify.success(posisi[t+1].tfc_pole);

								$rootScope.total_time = posisi[t+1].tfc_duration;
							}
							t++;
						}
					}

					if(x == sum_data){
						var reset = {
							tfc_sn : "114.199.113.123",
							tfc_pole : "A",
							tfc_status : 'nyala',
							tfc_G1 : '0'
						};

						NewTrans.updateDataTL(reset).then(function(res){
							var result = res.data;
							if(result.kind == "success"){
								//$scope.stopIntTl();
								$scope.start_counting("114.199.113.123");
								$rootScope.total_time = posisi[0].tfc_duration;
							}
						});
						//$scope.start_counting("114.199.113.123");
					}
					$rootScope.total_time--;
				}
			},1000);

		});
	};

	$scope.stopEwsTl = function(arah){		
		$interval.cancel(ews_tl);
	};

	$scope.stopIntTl = function(){		
		$interval.cancel(int_tl);
	};

	$scope.closeModal = function(arah){
		$("#modal_detail").modal("hide");
		if($scope.map_code == 'ews'){
			$scope.stopVideo(arah);
		}
	};

	$scope.is_played = false;
	$scope.is_paused = false;
	$scope.is_muted = false;

	$scope.video_isplay = false;
	$scope.playVideo = function(arah){
		if(arah == "RIGHT"){
			$scope.video_isplay_kanan = true;
		}else if(arah == "LEFT"){
			$scope.video_isplay_kiri = true;			
		}else{
			$scope.video_isplay = true;			
		}
	};

	$scope.pauseVideo = function(){
		var isPlaying = document.getElementById("video_ews");
		isPlaying.pause();
	};

	$scope.stopVideo = function(arah){
		if(arah == "NONE"){
			// var isPlayingNone = document.getElementById("video_ews");
			// isPlayingNone.pause();
			// isPlayingNone.currentTime = 0;
			$scope.video_isplay = false;
		}else if(arah == "LEFT"){
			var isPlayingLeft = document.getElementById("video_ews_kiri");
			isPlayingLeft.pause();
			isPlayingLeft.currentTime = 0;
			$scope.video_isplay_kiri = false;
		}else if(arah == "RIGHT"){
			var isPlayingRight = document.getElementById("video_ews_kanan");
			isPlayingRight.pause();
			isPlayingRight.currentTime = 0;
			$scope.video_isplay_kanan = false;
		}

	};

	$scope.muteVideo = function(){
		var isPlaying = document.getElementById("video_ews");
		if(isPlaying.muted){
			isPlaying.muted = false;
		}else{
			isPlaying.muted = true;
		}
	};

  	var viewer = new Kaleidoscope.Image({
    	source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
    	containerId: '#container360',
    	height: 400,
    	width: 870,
  	});

  	$scope.showFotoTL = function(u){
  		var segment = (window.location.href).split("/");
		var url_access = segment[segment.length - 1];

		var width0 = 0;
		var height0 = 0;
		if(url_access == "single_ews"){
			width0 = 470;
			height0 = 300;
		}else{
			width0 = 870;
			height0 = 400;
		}

		$scope.u = u;
		viewer = new Kaleidoscope.Image({
			//source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
			source: $rootScope.base_url + 'image/bg/' + u.tfc_loc_image,
			containerId: '#container360',
			width: width0,
			height: height0,
		});
		viewer.render();

		window.onresize = function() {
			// viewer.setSize({height: window.innerHeight, width: window.innerWidth});
		};
		$scope.uuu = u;

		$("#modal_photo_lokasi").modal("show");
	};

	$('#modal_photo_lokasi').on('hidden.bs.modal', function () {
	    viewer.destroy();
	});

	$scope.showDataUmumTl = function(u){
		NewTrans.getDataUmumTl(u.tfc_sn).then(function(res){
		console.log(JSON.stringify(res.data));
			var result = res.data;
			if(result.data.length > 0){
				$scope.dataumum = result.data[0];
				$scope.tfc_rambus = result.data[0].rambu_icon;
			}
			$timeout(function() {
				$("#modal_data_umum_tl").modal("show");
			}, 10);
			
		});
	};

	$scope.showDataUmumWl = function(wlIP){
		NewTrans.getDataUmumWl(wlIP).then(function(res){
			var result = res.data;
			if(result.data.length > 0){
				$scope.datumwl = result.data[0];
				$("#modal_data_umum_wl").modal("show");
			}

			console.log( JSON.stringify($scope.datumwl) );

			$timeout(function() {
			}, 100);
			
		});

	};


  	$scope.showFotoWL = function(u){
  		var segment = (window.location.href).split("/");
		var url_access = segment[segment.length - 1];

		var width0 = 0;
		var height0 = 0;
		if(url_access == "single_ews"){
			width0 = 470;
			height0 = 300;
		}else{
			width0 = 870;
			height0 = 400;
		}

		$scope.image_path = $rootScope.base_url + 'image/bg/' + u[0].wl_loc_image;

		$scope.u = u;
		viewer = new Kaleidoscope.Image({
			//source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
			source: $rootScope.base_url + 'image/bg/' + u[0].wl_loc_image,
			containerId: '#container360',
			width: width0,
			height: height0,
		});
		viewer.render();

		window.onresize = function() {
			// viewer.setSize({height: window.innerHeight, width: window.innerWidth});
		};
		$scope.uuu = u;

		$("#modal_photo_lokasi").modal("show");
	};

	$scope.showStatusAlat = function(u) {
		NewTrans.getStatusAlatWl(u[0].wl_sn).then(function(res){
			var result = res.data;
			$scope.rpt_alat = result.data;
			$("#modal_status_alat").modal("show");
		});
	}

	$scope.showDetailEws = function(u){		
		console.log(JSON.stringify(u));
		$scope.ip_address = u.ews_sn;
		NewTrans.getReportEwsBySN(u.ews_sn, "all", "all").then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;
			$scope.header = u;

			// console.log("dataBySN : ");
			// console.log(JSON.stringify(result.data));

			// var kota = ((u.ews_area).split(" - ")[0]).toLowerCase();
			// $scope.getWeather(kota);

			$("#modal_detail_ews").modal("show");
		});
	};


	
})

.controller('mUserCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.header_tittle = "add";

	$scope.getUser = function(){
		NewTrans.getUser().then(function(res){
			var result = res.data;
			$scope.users = result.data;
		});
	};
	$scope.getUser();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.user = null;
		$("#admLevel").val("").trigger("change");
	};

	$scope.on_edit = false;
	$scope.editUser = function(u){
		$scope.header_tittle = "edit";
		$scope.on_edit = true;

		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = true;

		NewTrans.getUserId(u.adm_code).then(function(res){
			var result = res.data;
			$scope.user = result.data[0];

			$("#admLevel").val(result.data[0].adm_level).trigger("change");

			$scope.getUserMenu(u.adm_code);
		});
	};

	$scope.addUser = function(){
		$scope.header_tittle = "add";
		$scope.on_edit = false;
		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;
		$scope.usermenudata = [];
		$scope.usermenu = [];
	};

	$scope.usermenudata = [];
	$scope.saveUser = function(data){
		var level = $("#admLevel").val();
		if(!data || !data.adm_name || !data.adm_code || !data.adm_pass || !level){
			alertify.error("Data belum lengkap !");
		}else{
			data.adm_level = level;
			data.created_date = $rootScope.fulldate;
			data.created_by = $rootScope.LoginId;

			if(level == 'admin'){
				data.adm_image = "logo_wahyujaya.png";
			}else{
				data.adm_image = "dishub.png";
			}

			NewTrans.saveUser(data).then(function(res){
				var result = res.data;
				if(result.kind == 'success'){
					alertify.success("Data added");
					$scope.getUser();

					$scope.s_details = true;

				}else{
					var msg = (result.description).substr(9,5);
					if(msg == '23000'){

						delete data.created_date;
						delete data.created_by;
						data.updated_date = $rootScope.fulldate;
						data.updated_by = $rootScope.LoginId;

						NewTrans.updateUser(data).then(function(res){
							var result = res.data;
							if(result.kind == 'success'){
								alertify.success("User updated");
								$scope.getUser();

								$scope.s_details = true;
							}else{
								alertify.error(JSON.stringify(result));
							}
						});
					}else{
						alertify.error(result.description);
					}
				}
			});
		}
	};
	
	$scope.delUser = function(u){
		alertify.confirm("Confirmation", "Are you sure to delete <b>'" + u.adm_code + "'</b> ?", 
			function(){
				NewTrans.deleteUser(u.adm_code).then(function(res){
					var result = res.data;
					if(result.kind == 'success'){
						alertify.success( u.adm_name + " deleted");
						$scope.getUser();
					}else{
						alertify.error(JSON.stringify(result));
					}
				});
			},
			function(){
			});
	};

	$scope.getUserMenu = function(userid){
		NewTrans.getUserMenu(userid).then(function(res){
			var result = res.data;
			$scope.usermenu = result;
		});

		NewTrans.getUserMenuData(userid).then(function(res){
			var result = res.data;
			$scope.usermenudata = result.data;
		});

	};

	$scope.menus = [];
	$scope.getMenu = function(){
		NewTrans.getMenu().then(function(res){
			var result = res.data;
			$scope.menus = result.data;
		});
	};


	$scope.addMenu = function(){
		$scope.getMenu();
		$("#modal_add").modal("show");
	};

	$scope.delMenu = function(menu){		
		NewTrans.deleteMenu(menu.acc_id).then(function(res){
			var result = res.data;
			if(result.kind == 'success'){
				alertify.success("Data deleted");
			}
			$scope.getUserMenu($scope.user.adm_code);
		});
	};

	$scope.saveMenu = function(code){
		var menucode = $("#pilMenu").val();
		var statMenu = $("#statMenu").val();

		if(!menucode){
			alertify.error("Please select menu");
			if(code == 'T'){
				$("#modal_add").modal("hide");
			}
		}else{
			var data = {
				"acc_adm_code" : $scope.user.adm_code,
				"acc_access"    : menucode,
				"acc_active"    : statMenu,
				"created_date"  : $rootScope.fulldate,
				"created_by"   : $rootScope.LoginId,
			};
			NewTrans.saveMenuUser(data).then(function(res){
				var result = res.data;
				if(result.kind == 'success'){
					alertify.success("Menu added");
					$scope.getUserMenu($scope.user.adm_code);

				}else{
					alertify.error(result.description);
				}
				$("#pilMenu").val("").trigger("change");				
				if(code == 'T'){
					$("#modal_add").modal("hide");
				}
			});			
		}
	};

	$scope.showhidepass = function(){
		var obj = document.getElementById('pass');
		if(obj.type == "text"){
			obj.type = "password";
			$("#pointer").addClass('fa-eye');
			$("#pointer").removeClass('fa-eye-slash');
		}else{
			obj.type = "text";
			$("#pointer").addClass('fa-eye-slash');
			$("#pointer").removeClass('fa-eye');
		}
	};


})

.controller('mParamCtrl',function($rootScope, $scope, $http, NewTrans, Upload, $interval, $window, $filter, $timeout){
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;


	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();

	$scope.getRambu = function(){
		NewTrans.getRambu().then(function(res){
			var result = res.data;
			$scope.rambuss = result.data;
		});
	};
	$scope.getRambu();
	
	$("#tfc_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.prov_code = id;
		$scope.prov_name = text;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#tfc_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kab_code = id;
		$scope.kab_name = text;

		$scope.kec_code = "";
		$scope.kec_name = "";
		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#tfc_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kec_code = id;
		$scope.kec_name = text;
		$("#tfc_area").val( $scope.prov_code + " " + $scope.kab_code + " " + id + " " + text + " - " + $scope.kab_name + " - " + $scope.prov_name);
	});

	$scope.copyTexts = function(inputId){
		var copyText = document.getElementById("tfc_area");
		copyText.select();
		copyText.setSelectionRange(0, 99999)
		document.execCommand("copy");
		alertify.success("text copied");
	}


	$scope.rambus = [];
	$("#tfc_rambu").on('select2:selecting', function(e){
		var data = e.params.args.data;
		if(!$scope.rambus.includes(data.id)){
			$scope.rambus.push(data.id);
		}
		console.log($scope.rambus);
	});

	$("#tfc_rambu").on('select2:unselect', function(e){
		console.log(e);
		var data = e.params.data;
		var pos = searchStringInArray(data.id, $scope.rambus);
		if(pos > -1){
			$scope.rambus.splice(pos, 1);
		}
	});

	function searchStringInArray (str, strArray) {
		for (var j=0; j<strArray.length; j++) {
			if (strArray[j].match(str)) {
				return j;
			}
		}
		return -1;
	}

})

.controller('mTLCtrl',function($rootScope, $scope, $http, NewTrans, Upload, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.header_tittle = "add";

	$scope.getTraffic = function(){
		NewTrans.getTraffic().then(function(res){
			var result = res.data;
			$scope.traffics = result.data;
		});
	};
	$scope.getTraffic();

	$scope.getProject = function(){
		NewTrans.getProject().then(function(res){
			$scope.projects = res.data.data;
		});
	};
	$scope.getProject();

	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();

	$scope.getRambu = function(){
		NewTrans.getRambu().then(function(res){
			var result = res.data;
			$scope.rambuss = result.data;
		});
	};
	$scope.getRambu();
	
	$("#tfc_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.prov_code = id;
		$scope.prov_name = text;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#tfc_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kab_code = id;
		$scope.kab_name = text;

		$scope.kec_code = "";
		$scope.kec_name = "";
		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#tfc_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kec_code = id;
		$scope.kec_name = text;
		$("#tfc_area").val(text + " - " + $scope.kab_name + " - " + $scope.prov_name);
	});


	$scope.rambus = [];
	$("#tfc_rambu").on('select2:selecting', function(e){
		var data = e.params.args.data;
		if(!$scope.rambus.includes(data.id)){
			$scope.rambus.push(data.id);
		}
		console.log($scope.rambus);
	});

	$("#tfc_rambu").on('select2:unselect', function(e){
		console.log(e);
		var data = e.params.data;
		var pos = searchStringInArray(data.id, $scope.rambus);
		if(pos > -1){
			$scope.rambus.splice(pos, 1);
		}
	});

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.tl = null;
		$scope.docfile = null;
	};

	$scope.on_edit = false;
	$scope.editData = function(u){
		$scope.header_tittle = "edit";
		$scope.on_edit = true;

		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;

		NewTrans.getTrafficId(u.tfc_sn).then(function(res){
			var result = res.data;
			$scope.tl = result.data[0];

			$("#tfc_prov").val($scope.tl.tfc_prov).trigger("change");
			NewTrans.getKabupaten($scope.tl.tfc_prov).then(function(res){
				var kabs = res.data;
				$scope.kabupaten = kabs.data;
				$timeout(function() {
					var eprov = $('#tfc_prov').select2('data');
					$scope.prov_name = eprov[0].text;

					$("#tfc_kab").val($scope.tl.tfc_kab).trigger("change");
					NewTrans.getKecamatan($scope.tl.tfc_kab).then(function(res){
						var kecs = res.data;
						$scope.kecamatan = kecs.data;
						$timeout(function() {
							var ekab = $('#tfc_kab').select2('data');
							$scope.kab_name = ekab[0].text;
							$scope.kab_code = ekab[0].id;

							$("#tfc_kec").val($scope.tl.tfc_kec).trigger("change");
						}, 10);
					});

				}, 10);
			});
			$("#tfc_area").val($scope.tl.tfc_area);

			var rambus = [];
			$scope.rambus = [];
			if(u.tfc_rambu){
				var split = u.tfc_rambu.replace("[","").replace("]","").split(",");
				angular.forEach(split, function(value, key) {
					rambus.push(split[key].replace("\"","").replace("\"","") );
				});
				$("#tfc_rambu").val(rambus).trigger("change");
				$scope.rambus = rambus;
			}

			console.log($scope.tl.tfc_project);
			$timeout(function() {
				$("#tfc_project").val($scope.tl.tfc_project).trigger("change");
			}, 10);


			$("#tfc_road_class").val($scope.tl.tfc_road_class).trigger("change");
			$("#tfc_road_type").val($scope.tl.tfc_road_type).trigger("change");
			$("#tfc_marka").val($scope.tl.tfc_marka).trigger("change");

			$scope.img_old_1 = u.tfc_loc_image;
			$scope.img_old_2 = u.tfc_flash_image;

			$(".tfc_install_year").val($scope.tl.tfc_install_date);
			$(".tfc_maintenance_year").val($scope.tl.tfc_maintenance_date);

		});
	};

	$scope.on_edit_d = false;
	$scope.editDataD = function(ud){
		$scope.on_edit_d = true;
		$scope.tld = ud;
		$("#tfc_device_sts").val(ud.tfc_device_sts).trigger("change");

		var bSaveD = document.getElementById("bSaveD");
		bSaveD.innerHTML = "<i class='fa fa-refresh'></i> Update";

		$("#modal_add_detail").modal("show");
	};

	$scope.addData = function(){
		$scope.header_tittle = "add";
		$scope.on_edit = false;
		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;
		$scope.usermenudata = [];
		$scope.usermenu = [];

		$("#tfc_prov").val("").trigger("change");
		$("#tfc_kab").val("").trigger("change");
		$("#tfc_kec").val("").trigger("change");
		$("#tfc_area").val("");

	};

	$scope.nextdata = function(){
		$scope.tld = {
			tfc_sn_d : $("#tfc_sn").val()
		};
		$scope.s_input = false;
		$scope.s_details = true;

		$scope.getStatusType("traffic");
		$scope.getTrafficD($("#tfc_sn").val());
	};

	$scope.addPole = function(){
		$("#modal_add_detail").modal("show");
	}

	$scope.uploadData = function(){
		$("#modalUpload").modal("show");
	};

	$scope.saveData = function(data, flashFile, locFile){
		var ekec = $('#tfc_kec').select2('data');
		$scope.kec_code = ekec[0].id;

		var tfc_ip = $("#tfc_ip").val();
		var kab_code = $scope.kab_code;
		var kec_code = $scope.kec_code;
		var area_name = $("#tfc_area").val();

		var kelas_jalan = $("#tfc_road_class").val();
		var tipe_jalan = $("#tfc_road_type").val();
		var marka = $("#tfc_marka").val();
		var project = $("#tfc_project").val();

		var install_date = $(".tfc_install_year").val();
		var maintain_date = $(".tfc_maintenance_year").val();

		var ext = "";
		var ext1 = "";
		var filename = "";
		var filename1 = "";
		var thisdate = Date.now();

		if(flashFile){
			var str = (flashFile.name).split('.');
			ext = str[(str.length)-1];
			filename = tfc_sn + "_flash_" + thisdate + "." + ext;
		}else{
			ext = "";
			filename = "traffic_bg.png";
		}

		if(locFile){
			var lcFile = (locFile.name).split('.');
			ext1 = lcFile[(lcFile.length)-1];
			filename1 = tfc_sn + "_loc_" + thisdate + "." + ext1;
		}else{
			ext1 = "";
			filename1 = "traffic_bg.png";
		}

		if(!data || !tfc_ip || !kec_code){
			alertify.error("Data belum lengkap !");
		}else{
			data.tfc_ip = tfc_ip;
			data.tfc_prov = $scope.prov_code;
			data.tfc_kab = $scope.kab_code;
			data.tfc_kec = $scope.kec_code;
			data.tfc_road_class = kelas_jalan;
			data.tfc_road_type = tipe_jalan;
			data.tfc_marka = marka;
			data.tfc_rambu = JSON.stringify($scope.rambus);
			data.tfc_project = project;
			data.tfc_install_date = install_date;
			data.tfc_maintenance_date = maintain_date;
			data.tfc_area = area_name;
			data.tfc_flash_image = filename;
			data.tfc_loc_image = filename1;
			data.tfc_created_date = $rootScope.fulldate;
			data.tfc_created_by = $rootScope.LoginId;

			console.log(JSON.stringify(data));

			NewTrans.saveDataTL(data).then(function(res){
				var result = res.data;
				if(result.kind == 'success'){

					if (flashFile) {
						flashFile.upload = Upload.upload({
							url: $rootScope.api_url + '/uploadFile',
							data: {file: flashFile, directory: "image/bg/", fileName: filename}
						});
						
						flashFile.upload.then(function (response) {
							$timeout(function () {
								flashFile.result = response.data;
								console.log(response.status + ': ' + response.data);
																
								alertify.success("Data added");
								$scope.getTraffic();

								//show details
								$scope.nextdata();

								//$scope.cancelMe();
								
							});
						}, function (response) {
							if (response.status > 0){
								console.log(response.status + ': ' + response.data);
							}
						});
					}

					if (locFile) {
						locFile.upload = Upload.upload({
							url: $rootScope.api_url + '/uploadFile',
							data: {file: locFile, directory: "image/bg/", fileName: filename1}
						});
						
						locFile.upload.then(function (response) {
							$timeout(function () {
								locFile.result = response.data;
								console.log(response.status + ': ' + response.data);
							});
						}, function (response) {
							if (response.status > 0){
								console.log(response.status + ': ' + response.data);
							}
						});
					}

				}else{

					var msg = (result.description).substr(9,5);
					if(msg == '23000'){

						delete data.tfc_created_date;
						delete data.tfc_created_by;
						if(!flashFile){
							delete data.tfc_flash_image;
						}
						if(!locFile){
							delete data.tfc_loc_image;
						}
						data.tfc_updated_date = $rootScope.fulldate;
						data.tfc_updated_by = $rootScope.LoginId;

						NewTrans.updateDataTLMaster(data).then(function(res){
							var result = res.data;
							//console.log("data : " + JSON.stringify(data) );

							if(result.kind == 'success'){

								if (flashFile) {
									flashFile.upload = Upload.upload({
										url: $rootScope.api_url + '/uploadFile',
										data: {file: flashFile, directory: "image/bg/", fileName: filename}
									});
									
									flashFile.upload.then(function (response) {
										$timeout(function () {
											flashFile.result = response.data;
											console.log(response.status + ': ' + JSON.stringify(response.data));

											alertify.success("Data updated");
											$scope.getTraffic();

											$scope.nextdata();
											
										});
									}, function (response) {
										if (response.status > 0)
											console.log(response.status + ': ' + response.data);
									});
								}else{
									alertify.success("Data updated");
									$scope.getTraffic();

									$scope.nextdata();
								}

								if (locFile) {
									locFile.upload = Upload.upload({
										url: $rootScope.api_url + '/uploadFile',
										data: {file: locFile, directory: "image/bg/", fileName: filename1}
									});
									
									locFile.upload.then(function (response) {
										$timeout(function () {
											locFile.result = response.data;
											console.log(response.status + ': ' + response.data);
										});
									}, function (response) {
										if (response.status > 0){
											console.log(response.status + ': ' + response.data);
										}
									});
								}

							}else{
								alertify.error(JSON.stringify(result));
							}
						});
					}else{
						alertify.error(result.description);
					}
				}
			});
		}
	};

	$scope.getStatusType = function(id){
		NewTrans.getIconsType(id).then(function(res){
			var result = res.data;
			$scope.statstype = result.data;
		});
	};

	$scope.getTrafficD = function(id){
		NewTrans.getTrafficD(id).then(function(res){
			var result = res.data;
			$scope.details = result.data;
		});
	};

	$scope.saveDataD = function(tld, gfile, rfile){
		var tfc_dvc_sts = $("#tfc_device_sts").val();
		if(!tld || !tld.tfc_pole || !tld.tfc_loc_desc || !tld.tfc_G){
			alertify.error("Please fill the blank !");
		}else{
			tld.tfc_device_sts = tfc_dvc_sts;
			tld.tfc_created_date = $rootScope.fulldate;
			tld.tfc_created_by = $rootScope.LoginId;

			if(tld.tfc_pole == "A"){
				tld.tfc_status = "nyala";
			}else{
				tld.tfc_status = "mati";
			}

			var postData = {
				tfc_id 					: tld.tfc_id || 0,
				tfc_sn_d				: tld.tfc_sn_d,
				tfc_pole				: tld.tfc_pole,
				tfc_loc_lat	 		: tld.tfc_loc_lat,
				tfc_loc_lon			: tld.tfc_loc_lon,
				tfc_loc_desc		: tld.tfc_loc_desc,
				tfc_G 					: tld.tfc_G,
				tfc_R 					: tld.tfc_R,
				tfc_device_sts 	: tld.tfc_device_sts,
				tfc_created_date: tld.tfc_created_date,
				tfc_created_by	: tld.tfc_created_by,
				tfc_status			: tld.tfc_status
			};

			if($scope.on_edit_d){
				postData.tfc_updated_date = $rootScope.fulldate;
				postData.tfc_updated_by 	= $rootScope.LoginId;
			}

			var timestamp = "";
			var filename = "";
			var ext = "jpg";
			var str = "";

			if(gfile){
				timestamp = new Date().getTime();
				str = (gfile.name).split('.');
				ext = str[(str.length)-1];

				filename = "gfile_" + tld.tfc_pole + "_" + timestamp + "." + ext;
				tld.tfc_g_image = filename;
				postData.tfc_g_image = filename;

				gfile.upload = Upload.upload({
					url: $rootScope.api_url + '/uploadFile',
					data: {file: gfile, directory: "image/tfc/", fileName: filename}
				});
				gfile.upload.then(function (response) {
					$timeout(function () {$scope.gfile = null;});
				}, function (response) {
					if (response.status > 0){
						$scope.errorMsgG = response.status + ': ' + response.data;
					}
				});
			}

			if(rfile){
				timestamp = new Date().getTime();
				str = (rfile.name).split('.');
				ext = str[(str.length)-1];

				filename = "rfile_" + tld.tfc_pole + "_" + timestamp + "." + ext;
				tld.tfc_r_image = filename;
				postData.tfc_r_image = filename;

				rfile.upload = Upload.upload({
					url: $rootScope.api_url + '/uploadFile',
					data: {file: rfile, directory: "image/tfc/", fileName: filename}
				});
				rfile.upload.then(function (response) {
					$timeout(function () {$scope.rfile = null;});
				}, function (response) {
					if (response.status > 0){
						$scope.errorMsgR = response.status + ': ' + response.data;
					}
				});
			}

			NewTrans.saveDataTLD(postData).then(function(res){
				var result = res.data;
				var msg = (result.description).substr(9,5);
				if(result.kind == 'success'){
					alertify.success("Pole added !");
					$scope.getTrafficD(tld.tfc_sn_d);

					$("#tfc_device_sts").val(null).trigger("change");
					$scope.tld = {
						tfc_sn_d : tld.tfc_sn_d
					};
					$scope.on_edit_d = false;
					bSaveD.innerHTML = "<i class='fa fa-plus'></i> Add";
				}else if(msg == '23000'){
					NewTrans.updateDataTLD(postData).then(function(ress){
						var results = ress.data;
						if(results.kind == 'success'){
							alertify.success("Pole Updated !");
							$scope.getTrafficD(tld.tfc_sn_d);
							$("#tfc_device_sts").val(null).trigger("change");
							$scope.tld = {
								tfc_sn_d : tld.tfc_sn_d
							};
							$scope.on_edit_d = false;
							bSaveD.innerHTML = "<i class='fa fa-plus'></i> Add";
						}else{
							alertify.error(JSON.stringify(results));
						}
					});

					$("#modal_add_detail").modal("hide");
				}else{
					alertify.error(JSON.stringify(result));
				}
			});
		}

	};

	$scope.delData = function(u){
		alertify.confirm("Confirmation", "Are you sure to delete <b>'" + u.tfc_pole + "'</b> on <b>'"+ u.tfc_loc_desc +"'</b> ?", 
			function(){
				NewTrans.deleteDataTL(u.tfc_id).then(function(res){
					var result = res.data;
					if(result.kind == 'success'){
						alertify.success( u.tfc_pole + " deleted");
						$scope.getTraffic();
						$scope.getTrafficD(u.tfc_sn_d);
					}else{
						alertify.error(JSON.stringify(result));
					}
				});
			},
			function(){
			});
	};

	$scope.finishMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
	};


	$scope.selectArea = function(){
		$("#modalArea").modal("show");
	};

	$scope.setArea = function(){
		$("#tfc_area").val($scope.kec_name + " - " + $scope.kab_name + " - " + $scope.prov_name);
		$("#modalArea").modal("hide");
	};

	$scope.showHistoryTfc = function(ip){
		$scope.mnt = {
			mnt_sn_code: ip
		};

		NewTrans.getHistoryTL(ip).then(function(res){
			$scope.histories = res.data.data;
			$("#modal_history_tfc").modal("show");
		});
	};

	$scope.onHisEdit = false;
	$scope.saveHistoryTfc = function(mnt){
		var mnt_year = $(".mnt_year").val();
		var mnt_type = $(".mnt_type").val();

		if(!mnt_year || !mnt_type || !mnt.mnt_user){
			alertify.error("Data belum lengkap");
		}else{

			mnt.mnt_year = mnt_year;
			mnt.mnt_type = mnt_type;
			mnt.mnt_category = "tfc";

			if($scope.onHisEdit){
				NewTrans.updateHistoryTL(mnt, mnt.mnt_id).then(function(res){
					NewTrans.getHistoryTL(mnt.mnt_sn_code).then(function(res){
						$scope.histories = res.data.data;
						$scope.batalHistory(mnt.mnt_sn_code);
					});
				});
			}else{
				NewTrans.saveHistoryTL(mnt).then(function(res){
					NewTrans.getHistoryTL(mnt.mnt_sn_code).then(function(res){
						$scope.histories = res.data.data;
						$scope.batalHistory(mnt.mnt_sn_code);
					});
				});
			}

		}
	};

	$scope.closeHistory = function(sn){
		$scope.batalHistory(sn);
		$("#modal_history_tfc").modal("hide");
	};

	$scope.batalHistory = function(sn){
		$scope.onHisEdit = false;
		$scope.mnt = {
			mnt_sn_code: sn,
			mnt_user: null,
			mnt_remarks: null
		};

		$('.mnt_year').val($rootScope.fulldate).datepicker("update");
		$(".mnt_type").val("").trigger("change");
	};

	$scope.delHistory = function(his){
		NewTrans.deleteHistoryTL(his.mnt_id).then(function(res){
			NewTrans.getHistoryTL(his.mnt_sn_code).then(function(res){
				$scope.histories = res.data.data;
				$scope.batalHistory(his.mnt_sn_code);
			});
		});
	}

	$scope.editHistory = function(his){
		$scope.onHisEdit = true;
		$scope.mnt = his;

		$('.mnt_year').val(his.mnt_year).datepicker("update");
		$(".mnt_type").val(his.mnt_type).trigger("change");
	}


	$scope.SelectFile = function (file) {
		$scope.SelectedFile = file;
		if(file){
			$scope.Upload();			
		}
	};

	$scope.Upload = function () {
		var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
		if (regex.test($scope.SelectedFile.name.toLowerCase())) {
			if (typeof (FileReader) != "undefined") {
				var reader = new FileReader();
				//For Browsers other than IE.
				if (reader.readAsBinaryString) {
					reader.onload = function (e) {
						$scope.ProcessExcel(e.target.result);
					};
					reader.readAsBinaryString($scope.SelectedFile);
				} else {
					//For IE Browser.
					reader.onload = function (e) {
						var data = "";
						var bytes = new Uint8Array(e.target.result);
						for (var i = 0; i < bytes.byteLength; i++) {
							data += String.fromCharCode(bytes[i]);
						}
						$scope.ProcessExcel(data);
					};
					reader.readAsArrayBuffer($scope.SelectedFile);
				}
			} else {
				$window.alert("This browser does not support HTML5.");
			}
		} else {
			$window.alert("Please upload a valid Excel file.");
		}
	};

	$scope.ProcessExcel = function (data) {
		//Read the Excel File data.
		var workbook = XLSX.read(data, {
			type: 'binary'
		});

		//Fetch the name of First Sheet.
		var firstSheet = workbook.SheetNames[0];
		//Read all rows from First Sheet into an JSON array.
		var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
		//Display the data from Excel file in Table.
		$scope.$apply(function () {
			$scope.excelRows = excelRows;
			$scope.IsVisible = true;
		});
	};

	$scope.Download = function(){
		var link = document.createElement("a");
		link.download = name;
		link.href = $rootScope.base_url + 'assets/files/testReadExcel.xlsx';
		link.click();
	};

	$scope.saveExcelIntoDb = function(){
		var objectH = [];
		var objectD = [];
		var obj = $scope.excelRows;

		var objects = [];
		angular.forEach(obj, function(value, key) {
			var data = {
				tfc_sn 				: value.sn,
				tfc_ip 				: value.ip,
				tfc_prov 			: value.prov,
				tfc_kab 			: value.kab,
				tfc_kec 			: value.kec,
				tfc_area 			: value.area,
				tfc_desa 			: value.desa,
				tfc_jalan 			: value.nama_jalan,
				tfc_loc_lat 		: value.latitude,
				tfc_loc_lon 		: value.longitude,
				tfc_cross_type 		: value.persimpangan,
				tfc_road_class 		: value.kelas_jalan,
				tfc_road_type 		: value.tipe_jalan,
				tfc_rambu 			: value.rambu,
				tfc_marka 			: value.marka,
				tfc_install_date 	: value.tgl_pasang,
				tfc_cctv 			: value.cctv,
				tfc_street_view 	: value.street_view,
				tfc_project 		: value.project,
				tfc_description 	: value.catatan,
				tfc_created_date 	: $rootScope.fulldate,
				tfc_created_by 		: $rootScope.LoginId
			}
			objectH.push(data);

			var dataD = {
				tfc_sn_d 			: value.sn,
				tfc_pole 			: value.tiang,
				tfc_loc_lat			: value.latitude_tiang,
				tfc_loc_lon 		: value.longitude_tiang,
				tfc_loc_desc 		: value.lokasi_tiang,
				tfc_G 				: value.timer_hijau,
				tfc_R 				: value.timer_merah,
				tfc_status 			: value.tiang == 'A' ? 'nyala' : 'mati',
				tfc_created_date 	: $rootScope.fulldate,
				tfc_created_by 		: $rootScope.LoginId
			}
			objectD.push(dataD);
		});

		var objects = [];
		objects.push({header : objectH, detail : objectD});
		NewTrans.saveFromUploadTL(objects).then(function(res){
			var result = res.data;
			var restH = result.data.data_header;
			var restD = result.data.data_detail;

			$scope.laporan_h = "data header terinput : " + restH.inserted + "; pesan : " + restH.data[0].msg;
			$scope.laporan_d = "data detail terinput : " + restD.inserted + "; pesan : " + restD.data[0].msg;

			$scope.excelRows = null;
		});

	}


	function searchStringInArray (str, strArray) {
		for (var j=0; j<strArray.length; j++) {
			if (strArray[j].match(str)) {
				return j;
			}
		}
		return -1;
	}


})


.controller('mWlCtrl',function($rootScope, $scope, $http, NewTrans, Upload, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.header_tittle = "add";

	$scope.getWL = function(){
		NewTrans.getWL().then(function(res){
			var result = res.data;
			$scope.warnings = result.data;
		});
	};
	$scope.getWL();

	var intWL;
	$scope.startIntWl = function(jml){
		$scope.show = true;
		$scope.stopIntWl();
		$scope.writeTimer();
		intWL = $interval(function(){
			if($scope.show){
				$scope.show = false;
			}else{
				$scope.show = true;
			}
		}, jml * 1000);
	};

	var intTimer;
	$scope.stopIntWl = function(){		
		$interval.cancel(intWL);
		$interval.cancel(intTimer);
	};

	$scope.writeTimer = function(){
		$interval.cancel(intTimer);
		$scope.timers = 0;
		intTimer = $interval(function(){
			$scope.timers++;
		},1000);
	};

	$scope.getWLProject = function() {
		NewTrans.getWLProject().then(function(res){
			var result = res.data;
			$scope.projects = result.data;
		});
	};
	$scope.getWLProject();

	$scope.getRambu = function(){
		NewTrans.getRambu().then(function(res){
			var result = res.data;
			$scope.rambuss = result.data;
		});
	};
	$scope.getRambu();

	$scope.rambus = [];
	$("#wl_rambu").on('select2:selecting', function(e){
		var data = e.params.args.data;
		if(!$scope.rambus.includes(data.id)){
			$scope.rambus.push(data.id);
		}
	});

	$("#wl_rambu").on('select2:unselect', function(e){
		console.log(e);
		var data = e.params.data;
		var pos = searchStringInArray(data.id, $scope.rambus);
		if(pos > -1){
			$scope.rambus.splice(pos, 1);
		}
	});

	$scope.selectArea = function(){
		$("#modalArea").modal("show");
	};

	$scope.setArea = function(){
		$("#wl_area").val($scope.kec_name + " - " + $scope.kab_name + " - " + $scope.prov_name);
		$("#modalArea").modal("hide");
	};

	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();
	
	$("#wl_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.prov_code = id;
		$scope.prov_name = text;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#wl_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kab_code = id;
		$scope.kab_name = text;

		$scope.kec_code = "";
		$scope.kec_name = "";
		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#wl_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kec_code = id;
		$scope.kec_name = text;
		// $("#wl_area").val(text + " - " + $scope.kab_name + " - " + $scope.prov_name);
	});


	$scope.addData = function(){
		$scope.header_tittle = "add";
		$scope.on_edit = false;
		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;
		$scope.usermenudata = [];
		$scope.usermenu = [];

		$("#wl_prov").val("").trigger("change");
		$("#wl_kab").val("").trigger("change");
		$("#wl_kec").val("").trigger("change");
		$("#wl_area").val("");

	};

	$scope.nextdata = function(){
		$scope.wld = {
			wl_sn_d : $("#wl_sn").val()
		};
		$scope.s_input = false;
		$scope.s_details = true;

		// $scope.getStatusType("traffic");
		$scope.getWlDId($("#wl_sn").val());
	};

	$scope.addPole = function(){
		$("#modal_add_detail").modal("show");
	}


	$scope.saveDataD = function(wld, gfile){
		if(!wld || !wld.wl_pole || !wld.wl_loc_desc){
			alertify.error("Please fill the blank !");
		}else{
			wld.wl_device_sts = "";
			wld.wl_created_date = $rootScope.fulldate;
			wld.wl_created_by = $rootScope.LoginId;

			var postData = {
				wl_id 			: wld.wl_id || 0,
				wl_sn_d			: wld.wl_sn_d,
				wl_pole			: wld.wl_pole,
				wl_loc_lat	 	: wld.wl_loc_lat,
				wl_loc_lon		: wld.wl_loc_lon,
				wl_loc_desc		: wld.wl_loc_desc,
				wl_image 		: wld.wl_image,
				wl_device_sts 	: wld.wl_device_sts,
				wl_created_date	: wld.wl_created_date,
				wl_created_by	: wld.wl_created_by,
			};

			if($scope.on_edit_d){
				postData.wl_updated_date= $rootScope.fulldate;
				postData.wl_updated_by 	= $rootScope.LoginId;
			}

			var timestamp = "";
			var filename = "";
			var ext = "jpg";
			var str = "";

			if(gfile){
				timestamp = new Date().getTime();
				str = (gfile.name).split('.');
				ext = str[(str.length)-1];

				filename = "file_" + tld.tfc_pole + "_" + timestamp + "." + ext;
				tld.tfc_g_image = filename;
				postData.tfc_g_image = filename;

				gfile.upload = Upload.upload({
					url: $rootScope.api_url + '/uploadFile',
					data: {file: gfile, directory: "image/wl/", fileName: filename}
				});
				gfile.upload.then(function (response) {
					$timeout(function () {$scope.gfile = null;});
				}, function (response) {
					if (response.status > 0){
						$scope.errorMsgG = response.status + ': ' + response.data;
					}
				});
			}

			NewTrans.saveDataWLD(postData).then(function(res){
				var result = res.data;
				var msg = (result.description).substr(9,5);
				console.log(msg);
				if(result.kind == 'success'){
					alertify.success("Pole added !");
					$scope.getWlDId(wld.wl_sn_d);

					$scope.wld = {
						wl_sn_d : wld.wl_sn_d
					};
					$scope.on_edit_d = false;
					bSaveD.innerHTML = "<i class='fa fa-plus'></i> Add";

					$("#modal_add_detail").modal("hide");

				}else if(msg == '23000'){
					NewTrans.updateDataWLD(postData).then(function(ress){
						var results = ress.data;
						if(results.kind == 'success'){
							alertify.success("Pole Updated !");
							$scope.getWlDId(wld.wl_sn_d);
							$scope.wld = {
								wl_sn_d : wld.wl_sn_d
							};
							$scope.on_edit_d = false;
							bSaveD.innerHTML = "<i class='fa fa-plus'></i> Add";
						}else{
							alertify.error(JSON.stringify(results));
					console.log(JSON.stringify(result));
						}
					});

					$("#modal_add_detail").modal("hide");
				}else{
					alertify.error(JSON.stringify(result));
					console.log(JSON.stringify(result));
				}
			});
		}

	};

	$scope.getWlDId = function(id){
		NewTrans.getWlDId(id).then(function(res){
			var result = res.data;
			$scope.details = result.data;
		});
	};

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.wl = null;
	};

	$scope.saveDataWL = function(data, locFile){
		var ekec = $('#wl_kec').select2('data');
		$scope.kec_code = ekec[0].id;

		var wl_sn = $("#wl_sn").val();
		var kab_code = $scope.kab_code;
		var kec_code = $scope.kec_code;
		var area_name = $("#wl_area").val();

		var kelas_jalan = $("#wl_road_class").val();
		var tipe_jalan = $("#wl_road_type").val();
		var marka = $("#wl_marka").val();
		var project = $("#wl_project").val();

		var install_date = $(".wl_install_year").val();
		var maintain_date = $(".wl_maintenance_year").val();

		var ext = "";
		var ext1 = "";
		var filename = "";
		var filename1 = "";
		var thisdate = Date.now();

		if(locFile){
			var lcFile = (locFile.name).split('.');
			ext1 = lcFile[(lcFile.length)-1];
			filename1 = wl_sn + "_loc_" + thisdate + "." + ext1;
		}else{
			ext1 = "";
			filename1 = "traffic_bg.png";
		}

		if(!data || !wl_sn || !kec_code){
			alertify.error("Data belum lengkap !");
		}else{
			data.wl_sn = wl_sn;
			data.wl_prov = $scope.prov_code;
			data.wl_kab = $scope.kab_code;
			data.wl_kec = $scope.kec_code;
			data.wl_road_class = kelas_jalan;
			data.wl_road_type = tipe_jalan;
			data.wl_marka = marka;
			data.wl_rambu = JSON.stringify($scope.rambus);
			data.wl_project = project;
			data.wl_install_date = install_date;
			data.wl_maintenance_date = maintain_date;
			data.wl_area = area_name;
			data.wl_loc_image = filename1;
			data.wl_created_date = $rootScope.fulldate;
			data.wl_created_by = $rootScope.LoginId;

			console.log(JSON.stringify(data));

			NewTrans.saveDataWL(data).then(function(res){
				var result = res.data;
				if(result.kind == 'success'){

					if (locFile) {
						locFile.upload = Upload.upload({
							url: $rootScope.api_url + '/uploadFile',
							data: {file: locFile, directory: "image/bg/", fileName: filename1}
						});
						
						locFile.upload.then(function (response) {
							$timeout(function () {
								locFile.result = response.data;
								console.log(response.status + ': ' + response.data);
							});
						}, function (response) {
							if (response.status > 0){
								console.log(response.status + ': ' + response.data);
							}
						});
					}

					alertify.success("Data added");
					$scope.getWL();
					$scope.nextdata();


				}else{

					var msg = (result.description).substr(9,5);
					if(msg == '23000'){

						delete data.wl_created_date;
						delete data.wl_created_by;
						if(!locFile){
							delete data.wl_loc_image;
						}
						data.wl_updated_date = $rootScope.fulldate;
						data.wl_updated_by = $rootScope.LoginId;

						NewTrans.updateDataWL(data).then(function(res){
							var result = res.data;
							//console.log("data : " + JSON.stringify(data) );

							if(result.kind == 'success'){
								if (locFile) {
									locFile.upload = Upload.upload({
										url: $rootScope.api_url + '/uploadFile',
										data: {file: locFile, directory: "image/bg/", fileName: filename1}
									});
									
									locFile.upload.then(function (response) {
										$timeout(function () {
											locFile.result = response.data;
											console.log(response.status + ': ' + response.data);

										});
									}, function (response) {
										if (response.status > 0){
											console.log(response.status + ': ' + response.data);
										}
									});
								}

								alertify.success("Data added");
								$scope.getWL();
								$scope.nextdata();

							}else{
								alertify.error(JSON.stringify(result));
							}
						});
					}else{
						alertify.error(result.description);
					}
				}
			});
		}
	};

	$scope.on_edit = false;
	$scope.editData = function(u){
		$scope.header_tittle = "edit";
		$scope.on_edit = true;

		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;

		NewTrans.getWLId(u.wl_sn).then(function(res){
			var result = res.data;
			$scope.wl = result.data[0];

			console.log(JSON.stringify($scope.wl));

			$("#wl_prov").val($scope.wl.wl_prov).trigger("change");
			NewTrans.getKabupaten($scope.wl.wl_prov).then(function(res){
				var kabs = res.data;
				$scope.kabupaten = kabs.data;
				$timeout(function() {
					var eprov = $('#wl_prov').select2('data');
					$scope.prov_name = eprov[0].text;

					$("#wl_kab").val($scope.wl.wl_kab).trigger("change");
					NewTrans.getKecamatan($scope.wl.wl_kab).then(function(res){
						var kecs = res.data;
						$scope.kecamatan = kecs.data;
						$timeout(function() {
							var ekab = $('#wl_kab').select2('data');
							$scope.kab_name = ekab[0].text;
							$scope.kab_code = ekab[0].id;

							$("#wl_kec").val($scope.wl.wl_kec).trigger("change");
						}, 10);
					});

				}, 10);
			});
			$("#wl_area").val($scope.wl.wl_area);

			var rambus = [];
			$scope.rambus = [];
			if(u.wl_rambu){
				var split = u.wl_rambu.replace("[","").replace("]","").split(",");
				angular.forEach(split, function(value, key) {
					rambus.push(split[key].replace("\"","").replace("\"","") );
				});
				$("#wl_rambu").val(rambus).trigger("change");
				$scope.rambus = rambus;
			}

			console.log($scope.wl.wl_project);
			$timeout(function() {
				$("#wl_project").val($scope.wl.wl_project).trigger("change");
			}, 10);


			$("#wl_road_class").val($scope.wl.wl_road_class).trigger("change");
			$("#wl_road_type").val($scope.wl.wl_road_type).trigger("change");
			$("#wl_marka").val($scope.wl.wl_marka).trigger("change");

			$scope.img_old_1 = u.wl_loc_image;

			$(".wl_install_year").val($scope.wl.wl_install_date);
			$(".wl_maintenance_year").val($scope.wl.wl_maintenance_date);

		});
	};


	$scope.on_edit_d = false;
	$scope.editDataD = function(ud){
		$scope.on_edit_d = true;
		$scope.wld = ud;

		var bSaveD = document.getElementById("bSaveD");
		bSaveD.innerHTML = "<i class='fa fa-refresh'></i> Update";

		$("#modal_add_detail").modal("show");
	};


	$scope.delData = function(u){
		alertify.confirm("Confirmation", "Are you sure to delete <b>'" + u.wl_pole + "'</b> on <b>'"+ u.wl_loc_desc +"'</b> ?", 
			function(){
				NewTrans.deleteDataWLD(u.wl_id).then(function(res){
					var result = res.data;
					if(result.kind == 'success'){
						alertify.success( u.wl_pole + " deleted");
						$scope.getWL();
						$scope.getWlDId(u.wl_sn_d);
					}else{
						alertify.error(JSON.stringify(result));
					}
				});
			},
			function(){
			});
	};

	$scope.finishMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
	};


	function searchStringInArray (str, strArray) {
		for (var j=0; j<strArray.length; j++) {
			if (strArray[j].match(str)) {
				return j;
			}
		}
		return -1;
	}


})


.controller('mEwsCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout, Upload){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.header_tittle = "add";

	$scope.getEws = function(){
		NewTrans.getEws().then(function(res){
			var result = res.data;
			$scope.ewss = result.data;
		});
	};
	$scope.getEws();

	$scope.getRambu = function(){
		NewTrans.getRambu().then(function(res){
			var result = res.data;
			$scope.rambuss = result.data;
		});
	};
	$scope.getRambu();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.tl = null;
	};

	$scope.selectArea = function(){
		$("#modalArea").modal("show");
	};

	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();
	
	$("#ews_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.prov_code = id;
		$scope.prov_name = text;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#ews_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kab_code = id;
		$scope.kab_name = text;

		$scope.kec_code = "";
		$scope.kec_name = "";
		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#ews_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.kec_code = id;
		$scope.kec_name = text;
	});

	$scope.setArea = function(){
		$("#ews_area").val($scope.kec_name + " - " + $scope.kab_name + " - " + $scope.prov_name);
		$("#modalArea").modal("hide");
	};

	$scope.rambus = [];
	$("#ews_rambu").on('select2:selecting', function(e){
		var data = e.params.args.data;
		if(!$scope.rambus.includes(data.id)){
			$scope.rambus.push(data.id);
		}
	});

	$("#ews_rambu").on('select2:unselect', function(e){
		console.log(e);
		var data = e.params.data;
		var pos = searchStringInArray(data.id, $scope.rambus);
		if(pos > -1){
			$scope.rambus.splice(pos, 1);
		}
	});


	$scope.on_edit = false;
	$scope.editDataEws = function(u){
		$scope.header_tittle = "edit";
		$scope.on_edit = true;

		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = true;

		NewTrans.getEwsId(u.ews_id).then(function(res){
			var result = res.data;
			$scope.ews = result.data[0];

			$scope.img_old = u.ews_location_image;
			
			var rambus = [];
			$scope.rambus = [];
			$timeout(function() {
				if(u.ews_rambu){
					var split = u.ews_rambu.replace("[","").replace("]","").split(",");
					angular.forEach(split, function(value, key) {
						rambus.push(split[key].replace("\"","").replace("\"","") );
					});
					$("#ews_rambu").val(rambus).trigger("change");
					$scope.rambus = rambus;
				}

				$("#ews_project").val($scope.ews.ews_project).trigger("change");
				$("#ews_road_class").val($scope.ews.ews_road_class).trigger("change");
				$("#ews_road_type").val($scope.ews.ews_road_type).trigger("change");
				$("#ews_marka").val($scope.ews.ews_marka).trigger("change");
				$("#ews_speed_bump").val($scope.ews.ews_speed_bump).trigger("change");

				$(".ews_install_year").val($scope.ews.ews_install_year);
				$(".ews_maintenance_year").val($scope.ews.ews_maintenance_year);

				if($scope.ews.ews_pju > 0){
					$("#ews_pju").val("ada").trigger("change");
					$scope.pju_show = true;
				}else{
					$("#ews_pju").val("tidak").trigger("change");					
					$scope.pju_show = false;
				}

			}, 100);

			$("#ews_prov").val(result.data[0].ews_prov).trigger("change");
			NewTrans.getKabupaten(result.data[0].ews_prov).then(function(res){
				var kabs = res.data;
				$scope.kabupaten = kabs.data;
				$timeout(function() {
					var eprov = $('#ews_prov').select2('data');
					$scope.prov_name = eprov[0].text;

					$("#ews_kab").val(result.data[0].ews_kab).trigger("change");
					NewTrans.getKecamatan(result.data[0].ews_kab).then(function(res){
						var kecs = res.data;
						$scope.kecamatan = kecs.data;
						$timeout(function() {
							var ekab = $('#ews_kab').select2('data');
							$scope.kab_name = ekab[0].text;
							$scope.kab_code = ekab[0].id;

							$("#ews_kec").val(result.data[0].ews_kec).trigger("change");
						}, 10);
					});

				}, 10);
			});
			$("#ews_area").val(result.data[0].ews_area);
			$("#ews_status").val(result.data[0].ews_status).trigger("change");

		});
	};

	$scope.pju_show = false;
	$("#ews_pju").on('select2:selecting', function(e){
		var data = e.params.args.data;
		if(data.id == "ada"){
			$scope.pju_show = true;
		}else{
			$scope.pju_show = false;
			$scope.ews.ews_pju = 0;
		}
	});

	$scope.addData = function(){
		$scope.header_tittle = "add";
		$scope.on_edit = false;
		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;
		$scope.usermenudata = [];
		$scope.usermenu = [];

		$scope.ews = null;

		$("#ews_prov").val("").trigger("change");
		$("#ews_kab").val("").trigger("change");
		$("#ews_kec").val("").trigger("change");
		$("#ews_area").val("");
		$("#ews_status").val("").trigger("change");
		$("#ews_rambu").val(null).trigger("change");

		$("#ews_project").val("").trigger("change");
		$("#ews_road_class").val("").trigger("change");
		$("#ews_road_type").val("").trigger("change");
		$("#ews_marka").val("").trigger("change");
		$("#ews_speed_bump").val("").trigger("change");
		$("#ews_pju").val("").trigger("change");					
		$scope.pju_show = false;

	};

	$scope.uploadData = function(){
		$("#modalUpload").modal("show");
	};

	$scope.isLoadSave = false;
	$scope.saveDataEws = function(data, files){
		var ekec = $('#ews_kec').select2('data');
		$scope.kec_code = ekec[0].id;

		// var ews_ip = data.ews_ip;
		var kab_code = $scope.kab_code;
		var kec_code = $scope.kec_code;
		var area_name = $("#ews_area").val();

		var kelas_jalan = $("#ews_road_class").val();
		var type_jalan = $("#ews_road_type").val();
		var marka = $("#ews_marka").val();
		var speedbump = $("#ews_speed_bump").val();
		var project = $("#ews_project").val();

		var install_date = $(".ews_install_year").val();
		var maintain_date = $(".ews_maintenance_year").val();

		if(!data || !data.ews_ip || !data.ews_loc_lat || !data.ews_loc_lon || !data.ews_loc_desc || !kec_code){
			alertify.error("Data belum lengkap !");
		}else{

			$scope.isLoadSave = true;

			var timestamp = new Date().getTime();
			var filename = data.ews_ip + "_" + timestamp;
			var ext = "jpg";			

			if(files){
				var str = (files.name).split('.');
				ext = str[(str.length)-1];

				data.ews_location_image = filename + "." + ext;

			}

			// data.ews_ip = ews_ip;
			data.ews_prov = $scope.prov_code;
			data.ews_kab = $scope.kab_code;
			data.ews_kec = $scope.kec_code;
			data.ews_area = area_name;
			data.ews_pole = "A";
			data.ews_duration = 47;
			data.ews_road_class = kelas_jalan;
			data.ews_road_type = type_jalan;
			data.ews_marka = marka;
			data.ews_speed_bump = speedbump;
			data.ews_project = project;
			data.ews_rambu = JSON.stringify($scope.rambus);
			data.ews_created_date = $rootScope.fulldate;
			data.ews_created_by = $rootScope.LoginId;
			data.ews_install_year = install_date;
			data.ews_maintenance_year = maintain_date;

			NewTrans.saveDataEws(data).then(function(res){
				var result = res.data;
				if(result.kind == 'success'){

					if(files){
						files.upload = Upload.upload({
							url: $rootScope.api_url + '/uploadFile',
							data: {file: files, directory: "image/ews/", fileName: filename + "." + ext}
						});

						files.upload.then(function (response) {
							$timeout(function () {
								files.result = response.data;
								$scope.errorMsg = response.status + ': ' + JSON.stringify(response.data);

								alertify.success("Data added");
								$scope.getEws();
								$scope.cancelMe();

								$scope.file = null;
								$scope.isLoadSave = false;

							});
						}, function (response) {
							if (response.status > 0){
								$scope.errorMsg = response.status + ': ' + response.data;
								$scope.isLoadSave = false;
							}
						});						
					}else{
						alertify.success("Data added");
						$scope.getEws();
						$scope.cancelMe();
						$scope.isLoadSave = false;

					}

				}else{
					var msg = (result.description).substr(9,5);
					if(msg == '23000'){

						delete data.ews_created_date;
						delete data.ews_created_by;
						data.ews_updated_date = $rootScope.fulldate;
						data.ews_updated_by = $rootScope.LoginId;

						NewTrans.updateDataEws(data).then(function(res){
							var result = res.data;
							if(result.kind == 'success'){

								if(files){
									files.upload = Upload.upload({
										url: $rootScope.api_url + '/uploadFile',
										data: {file: files, directory: "image/ews/", fileName: filename + "." + ext}
									});

									files.upload.then(function (response) {
										$timeout(function () {
											files.result = response.data;
											$scope.errorMsg = response.status + ': ' + JSON.stringify(response.data);

											alertify.success("Data updated");
											$scope.getEws();
											$scope.cancelMe();

											$scope.file = null;
											$scope.isLoadSave = false;

										});
									}, function (response) {
										if (response.status > 0){
											$scope.errorMsg = response.status + ': ' + response.data;
											$scope.isLoadSave = false;
										}
									});						
								}else{
									alertify.success("Data updated");
									$scope.getEws();
									$scope.cancelMe();
									$scope.isLoadSave = false;
								}

							}else{
								alertify.error(JSON.stringify(result));
							}
						});
					}else{
						alertify.error(result.description);
					}
				}
			});
		}
	};

	$scope.delDataEws = function(u){
		alertify.confirm("Confirmation", "Are you sure to delete <b>'" + u.ews_ip + "'</b> on <b>'"+ u.ews_loc_desc +"'</b> ?", 
			function(){
				NewTrans.deleteDataEws(u.ews_id).then(function(res){
					var result = res.data;
					if(result.kind == 'success'){
						alertify.success( u.ews_pole + " deleted");
						$scope.getEws();
					}else{
						alertify.error(JSON.stringify(result));
					}
				});
			},
			function(){
			});
	};

	$scope.getProject = function(){
		NewTrans.getProject().then(function(res){
			$scope.projects = res.data.data;
		});
	};
	$scope.getProject();


	function searchStringInArray (str, strArray) {
		for (var j=0; j<strArray.length; j++) {
			if (strArray[j].match(str)) {
				return j;
			}
		}
		return -1;
	}


	$scope.showHistory = function(ip){
		$scope.mnt = {
			mnt_sn_code: ip
		};

		NewTrans.getHistoryEws(ip).then(function(res){
			$scope.histories = res.data.data;
			$("#modal_history").modal("show");
		});
	};

	$scope.onHisEdit = false;
	$scope.saveHistoryEws = function(mnt){
		var mnt_year = $(".mnt_year").val();
		var mnt_type = $(".mnt_type").val();

		if(!mnt_year || !mnt_type || !mnt.mnt_user){
			alertify.error("Data belum lengkap");
		}else{

			mnt.mnt_year = mnt_year;
			mnt.mnt_type = mnt_type;

			if($scope.onHisEdit){
				NewTrans.updateHistoryEws(mnt, mnt.mnt_id).then(function(res){
					NewTrans.getHistoryEws(mnt.mnt_sn_code).then(function(res){
						$scope.histories = res.data.data;
						$scope.batalHistory(mnt.mnt_sn_code);
					});
				});
			}else{
				NewTrans.saveHistoryEws(mnt).then(function(res){
					NewTrans.getHistoryEws(mnt.mnt_sn_code).then(function(res){
						$scope.histories = res.data.data;
						$scope.batalHistory(mnt.mnt_sn_code);
					});
				});
			}
		}
	};

	$scope.closeHistory = function(sn){
		$scope.batalHistory(sn);
		$("#modal_history").modal("hide");
	};

	$scope.batalHistory = function(sn){
		$scope.mnt = {
			mnt_sn_code: sn,
			mnt_user: null,
			mnt_remarks: null
		};

		$('.mnt_year').val($rootScope.fulldate).datepicker("update");
		$(".mnt_type").val("").trigger("change");
	};


	$scope.delHistory = function(his){
		NewTrans.deleteHistoryEws(his.mnt_id).then(function(res){
			NewTrans.getHistoryEws(his.mnt_sn_code).then(function(res){
				$scope.histories = res.data.data;
				$scope.batalHistory(his.mnt_sn_code);
			});
		});
	}

	$scope.editHistory = function(his){
		$scope.onHisEdit = true;
		$scope.mnt = his;

		$('.mnt_year').val(his.mnt_year).datepicker("update");
		$(".mnt_type").val(his.mnt_type).trigger("change");
	}


	$scope.SelectFile = function (file) {
		$scope.SelectedFile = file;
		if(file){
			$scope.Upload();
		}
	};

	$scope.Upload = function () {
		var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
		if (regex.test($scope.SelectedFile.name.toLowerCase())) {
			if (typeof (FileReader) != "undefined") {
				var reader = new FileReader();
				//For Browsers other than IE.
				if (reader.readAsBinaryString) {
					reader.onload = function (e) {
						$scope.ProcessExcel(e.target.result);
					};
					reader.readAsBinaryString($scope.SelectedFile);
				} else {
					//For IE Browser.
					reader.onload = function (e) {
						var data = "";
						var bytes = new Uint8Array(e.target.result);
						for (var i = 0; i < bytes.byteLength; i++) {
							data += String.fromCharCode(bytes[i]);
						}
						$scope.ProcessExcel(data);
					};
					reader.readAsArrayBuffer($scope.SelectedFile);
				}
			} else {
				$window.alert("This browser does not support HTML5.");
			}
		} else {
			$window.alert("Please upload a valid Excel file.");
		}
	};

	$scope.ProcessExcel = function (data) {
		//Read the Excel File data.
		var workbook = XLSX.read(data, {
			type: 'binary'
		});

		//Fetch the name of First Sheet.
		var firstSheet = workbook.SheetNames[0];
		//Read all rows from First Sheet into an JSON array.
		var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
		//Display the data from Excel file in Table.
		$scope.$apply(function () {
			$scope.excelRows = excelRows;
			$scope.IsVisible = true;
		});
	};

	$scope.Download = function(){
		var link = document.createElement("a");
		link.download = name;
		link.href = $rootScope.base_url + 'assets/files/format_ews.xlsx';
		link.click();
	};


	$scope.saveExcelIntoDb = function(){
		var objectH = [];
		var objectD = [];
		var obj = $scope.excelRows;

		var objects = [];
		angular.forEach(obj, function(value, key) {
			var data = {
				ews_ip 			: value.ip,
				ews_sn_alias 	: value.sn,
				ews_gsm_no 		: value.gsm_no,
				ews_prov 		: value.prov,
				ews_kab 		: value.kab,
				ews_kec 		: value.kec,
				ews_area 		: value.area,
				ews_pole 		: "A",
				ews_loc_lat 	: value.latitude,
				ews_loc_lon 	: value.longitude,
				ews_loc_desc 	: value.lokasi,
				ews_loc_sensor_L: value.loc_sensor_l,
				ews_loc_sensor_C: value.loc_sensor_c,
				ews_loc_sensor_R: value.loc_sensor_r,
				ews_duration 	: value.durasi,
				ews_km 			: value.km,
				ews_daop 		: value.daop,
				ews_road_width 	: value.lebar_jalan,
				ews_road_class 	: value.kelas_jalan,
				ews_road_type 	: value.tipe_jalan,
				ews_pju 		: value.pju,
				ews_rambu 		: value.rambu,
				ews_marka 		: value.marka,
				ews_speed_bump 	: value.speed_bump,
				ews_install_year: value.tanggal_pasang,
				ews_cctv 		: value.cctv,
				ews_street_view : value.street_view,
				ews_description : value.catatan,
				ews_project 	: value.project,
				ews_dir_left 	: value.arah_kiri,
				ews_dir_right 	: value.arah_kanan,
				ews_created_date: $rootScope.fulldate,
				ews_created_by 	: $rootScope.LoginId
			}
			objectH.push(data);

		});

		NewTrans.saveFromUploadEWS(objectH).then(function(res){
			var result = res.data;
			var restH = result.data;

			console.log(JSON.stringify(result));

			$scope.laporan_h = "data terinput : " + restH.inserted + "; pesan : " + restH.data[0].msg;

			$scope.excelRows = null;
		});

	}


})

.controller('mPjuCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.header_tittle = "add";

	$scope.getPju = function(){
		NewTrans.getPju().then(function(res){
			var result = res.data;
			$scope.pjus = result.data;
		});
	};
	$scope.getPju();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.tl = null;
	};

	$scope.on_edit = false;
	$scope.editData = function(u){
		$scope.header_tittle = "edit";
		$scope.on_edit = true;

		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = true;

		NewTrans.getPjuId(u.pju_id).then(function(res){
			var result = res.data;
			$scope.pju = result.data[0];
		});
	};

	$scope.addData = function(){
		$scope.header_tittle = "add";
		$scope.on_edit = false;
		$scope.s_main = false;
		$scope.s_input = true;
		$scope.s_details = false;
		$scope.usermenudata = [];
		$scope.usermenu = [];
	};

	$scope.uploadData = function(){
		$("#modalUpload").modal("show");
	};

	$scope.saveData = function(data){

		if(!data || !data.pju_ip || !data.pju_area || !data.pju_pole || !data.pju_loc_lat || !data.pju_loc_lon || !data.pju_loc_desc || !data.pju_duration){
			alertify.error("Data belum lengkap !");
		}else{
			data.pju_created_date = $rootScope.fulldate;
			data.pju_created_by = $rootScope.LoginId;

			NewTrans.saveDataPju(data).then(function(res){
				var result = res.data;
				if(result.kind == 'success'){
					alertify.success("Data added");
					$scope.getPju();

					$scope.cancelMe();

				}else{
					var msg = (result.description).substr(9,5);
					if(msg == '23000'){

						delete data.pju_created_date;
						delete data.pju_created_by;
						data.pju_updated_date = $rootScope.fulldate;
						data.pju_updated_by = $rootScope.LoginId;

						NewTrans.updateDataPju(data).then(function(res){
							var result = res.data;
							if(result.kind == 'success'){
								alertify.success("Data updated");
								$scope.getPju();
								$scope.cancelMe();
							}else{
								alertify.error(JSON.stringify(result));
							}
						});
					}else{
						alertify.error(result.description);
					}
				}
			});
		}
	};

	$scope.delData = function(u){
		alertify.confirm("Confirmation", "Are you sure to delete <b>'" + u.pju_pole + "'</b> on <b>'"+ u.pju_loc_desc +"'</b> ?", 
			function(){
				NewTrans.deleteDataPju(u.pju_id).then(function(res){
					var result = res.data;
					if(result.kind == 'success'){
						alertify.success( u.pju_pole + " deleted");
						$scope.getPju();
					}else{
						alertify.error(JSON.stringify(result));
					}
				});
			},
			function(){
			});
	};

})

.controller('mIconCtrl',function($rootScope, $scope, $http, NewTrans, Upload, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.on_edit = false;

	$scope.icon_category = "";
	$scope.icon_type = "";

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.user = null;
	};

	$scope.getIcons = function(){
		NewTrans.getIcons().then(function(res){
			var result = res.data;
			$scope.icons = result.data;
		});
	};
	$scope.getIcons();

	$scope.addData = function(){
		$scope.header_tittle = 'add';
		$scope.s_main = false;
		$scope.s_input = true;

		$("#icon_category").val("").trigger("change");
		$("#icon_type").val("").trigger("change");
		$("#icon_name").val("");
		$scope.docfile = null;
		$scope.errorMsg= null;
	};

	$scope.saveData = function(files){
		var categ = $("#icon_category").val();
		var type = $("#icon_type").val();

		var filename = $("#icon_name").val();
		var str = (files.name).split('.');
		var ext = str[(str.length)-1];

		if(!files || !categ || !type){
			alertify.error("Data Belum Lengkap");
		}else{
			var icons = {
				icon_category : categ,
				icon_type : type,
				icon_name : filename,
				icon_image : categ+"/"+filename+"."+ext,
				icon_created_date : $rootScope.fulldate,
				icon_created_by : $rootScope.LoginId
			};

			NewTrans.saveDataIcons(icons).then(function(res){
				var result = res.data;
				if(result.kind == "success"){

					files.upload = Upload.upload({
						url: $rootScope.api_url + '/uploadFile',
						data: {file: files, directory: "image/icons/" + categ + "/", fileName: filename + "." + ext}
					});

					files.upload.then(function (response) {
						$timeout(function () {
							files.result = response.data;
							$scope.errorMsg = response.status + ': ' + JSON.stringify(response.data);

							$scope.getIcons();
							$scope.cancelMe();

						});
					}, function (response) {
						if (response.status > 0)
							$scope.errorMsg = response.status + ': ' + response.data;
					});

				}else{
					alertify.alert(JSON.stringify(res));
				}
			});
		}

	};

	$("#icon_category").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.icon_category = id;
		$("#icon_name").val($scope.icon_type);

	});


	$("#icon_type").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.icon_type = text;
		$("#icon_name").val($scope.icon_type);
	});

	$scope.avoidSpace = function(event){
    if(event.keyCode == 32){
    	event.preventDefault();
    }
	};


})


.controller('menuCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.header_tittle = "add";
	$scope.getMenu = function(){
		NewTrans.getMenu().then(function(res){
			var result = res.data;
			$scope.menus = result.data;
		});
	};
	$scope.getMenu();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.user = null;
		$("#admLevel").val("").trigger("change");
	};


})

.controller('rTfcCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		// $window.location = $rootScope.site_url + "login";
		if($scope.page_single_code == 'single'){
			//no login needed
		}else{
			$window.location = $rootScope.site_url + "login";			
		}

	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();

	$scope.srch = {
		prov : 'all',
		city : 'all',
		dist : 'all'
	};

	$("#s_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.prov = id;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#s_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.city = id;

		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#s_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.dist = id;

	});


	$scope.header_tittle = "add";
	$scope.getReport = function(){
		NewTrans.getReportTL($scope.srch.prov, $scope.srch.city, $scope.srch.dist).then(function(res){
			var result = res.data;
			$scope.reports = result.data;
		});
	};
	$scope.getReport();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.user = null;
		$("#admLevel").val("").trigger("change");
	};

	$scope.viewDetail = function(u){
		$scope.ip_address = u.tfc_sn;
		NewTrans.getReportTLBySn(u.tfc_sn, "all", "all").then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;

			$scope.header = u;
			$("#modal_detail_tl").modal("show");
			
		});

	};

	$scope.getTlByIP = function(ip){
		var date = $("#dateRpt").val();

		NewTrans.getReportTLByIP(ip, date).then(function(res){
			var result = res.data;
			$scope.history = result.data;

			if(result.data.length < 1){
				$scope.isNoData = true;
			}else{
				$scope.isNoData = false;
			}

		});

	};


	$scope.dateFrom = null;
	$scope.dateTo = null;
	$scope.filterReport = function(tfc_sn){
		var dateFrom = $(".dateFrom").val();
		var dateTo = $(".dateTo").val();

		if(!dateFrom || !dateTo){
			dateFrom = "all";
			dateTo = "all";
		}

		NewTrans.getReportTLBySn(tfc_sn, dateFrom, dateTo).then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;

			console.log("IP => " + tfc_sn + " From => " + dateFrom + " To => " + dateTo);

		});

	};

	$scope.getHeaderFilter = function(){
		return [
		"No", "IP", "SN", "Lokasi", "Waktu", "Pola Traffic", "Simpang 1", "Simpang 2", "Simpang 3", "Simpang 4", "Indikator Kerusakan", "Perpanjangan",
		"Perpendekan", "Flasing", "Arus AC", "Suhu", "Sinyal Modem", "Siklus"
		];
	};

	$scope.getDetailsFilter = function(){
		$scope.filenames = "details_" + $scope.ip_address + ".csv";
		var hasil = [];
		angular.forEach($scope.datafilters, function(value, key){
			hasil.push({
				"num"			: key + 1,
				"ip"		  	: value.tfc_ip,
				"sn"		  	: value.tfc_sn,
				"lokasi"  		: value.tfc_area,
				"waktu" 		: value.jam_rpt,
				"pola"			: value.tl_kode_pola,
				"simpang1"		: (value.tl_1_RYG).split(';')[2],
				"simpang2"		: (value.tl_2_RYG).split(';')[2],
				"simpang3"		: (value.tl_3_RYG).split(';')[2],
				"simpang4"		: (value.tl_4_RYG).split(';')[2],
				"indikator"		: value.tl_arus_ac == '0' ? "Tidak ada arus" : "Ada arus",
				"perpanjangan"	: value.tl_timer_panjang,
				"perpendekan"	: value.tl_timer_pendek,
				"flashing"		: value.tl_timer_flash,
				"arus"			: value.tl_arus_ac,
				"suhu"			: value.tl_suhu_panel,
				"sinyal"		: value.tl_sinyal_wifi,
				"siklus"		: value.tl_life_cycle
			});
		});

		return hasil;
	};

  	var viewer = new Kaleidoscope.Image({
    	source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
    	containerId: '#container360',
    	height: 400,
    	width: 870,
  	});

  	$scope.showFotoTL = function(u){
  		var segment = (window.location.href).split("/");
		var url_access = segment[segment.length - 1];

		var width0 = 0;
		var height0 = 0;
		if(url_access == "single_ews"){
			width0 = 470;
			height0 = 300;
		}else{
			width0 = 870;
			height0 = 400;
		}

		$scope.u = u;
		viewer = new Kaleidoscope.Image({
			//source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
			source: $rootScope.base_url + 'image/bg/' + u.tfc_loc_image,
			containerId: '#container360',
			width: width0,
			height: height0,
		});
		viewer.render();

		window.onresize = function() {
			// viewer.setSize({height: window.innerHeight, width: window.innerWidth});
		};
		$scope.uuu = u;

		$("#modal_photo_lokasi").modal("show");
	};

	$('#modal_photo_lokasi').on('hidden.bs.modal', function () {
	    viewer.destroy();
	});


	$scope.showDataUmumTl = function(u){
		NewTrans.getDataUmumTl(u.tfc_sn).then(function(res){
			var result = res.data;
			if(result.data.length > 0){
				$scope.dataumum = result.data[0];
				$scope.tfc_rambus = result.data[0].rambu_icon;
			}

			$timeout(function() {
				$("#modal_data_umum_tl").modal("show");
			}, 10);
			
		});

	};

	$scope.showHistoryTfc = function(ip){
		$scope.mnt = {
			mnt_sn_code: ip
		};

		NewTrans.getHistoryTL(ip).then(function(res){
			$scope.histories = res.data.data;
			$("#modal_history_tfc").modal("show");
		});
	};


})

.controller('rEwsCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		if($scope.page_single_code == 'single'){
			//no login needed
		}else{
			$window.location = $rootScope.site_url + "login";			
		}
	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;


	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();

	$scope.srch = {
		prov : 'all',
		city : 'all',
		dist : 'all'
	};

	$("#s_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.prov = id;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#s_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.city = id;

		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#s_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.dist = id;

	});


	$scope.header_tittle = "add";
	$scope.getReport = function(){
		//console.log( JSON.stringify($scope.srch));

		NewTrans.getReportEws($scope.srch.prov, $scope.srch.city, $scope.srch.dist).then(function(res){
			var result = res.data;
			$scope.reports = result.data;
		});
	};
	$scope.getReport();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.user = null;
		$("#admLevel").val("").trigger("change");
	};


	$scope.showDetail = function(u){		
		$scope.ip_address = u.ews_ip;
		NewTrans.getReportEwsBySN(u.ews_ip, "all", "all").then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;
			$scope.header = u;

			var kota = ((u.ews_area).split(" - ")[0]).toLowerCase();
			$scope.getWeather(kota);

			$("#modal_detail_ews").modal("show");
		});
	};

	$scope.getHeaderFilter = function(){
		return [
		"No", "Waktu", "Baterai", "Solar Cell", "Lampu Merah", "Indikator Arah", "Lampu Kuning", "Volume Sirine", 
		"Sensor Kanan", "Sensor Reset", "Sensor Kiri", "Suhu", "Sinyal Modem", "Speaker"
		];
	};

	$scope.getDetailsFilter = function(){
		$scope.filenames = "details_" + $scope.ip_address + ".csv";
		var hasil = [];
		angular.forEach($scope.datafilters, function(value, key){
			hasil.push({
				"num"			  : key + 1,
				"waktu"		  : value.date_rpt + " " + value.jam_rpt,
				"batterai"  : value.ews_battery_percent + " %",
				"solarCell" : value.chg_ind_status,
				"redLamp"		: value.ews_arah != "NONE" && value.ews_arah !== "" ? "ON" : "OFF",
				"indArah"		: value.ews_arah,
				"yelLamp"		: value.ews_arah == 'NONE' || value.ews_arah === "" ? "ON" : "OFF",
				"volSirine"	: value.ews_sirine_level,
				"senKanan"	: value.ews_jml_pulse_sensor_R,
				"senReset"	: value.ews_jml_pulse_sensor_C,
				"senKiri"		: value.ews_jml_pulse_sensor_L,
				"suhu"			: value.ews_suhu_confan,
				"singModem"	: value.ews_modem_signal,
				"speaker"		: value.ews_status_toa
			});
		});


		var header = $scope.header;
		console.log(header.ews_jpl);
		hasil.push(
			{"line_0" : ""},
			{"line_1" : ""},
			{
				"koordinat_name" 	: "Koordinat",
				"koordinat_value" : " : " + header.ews_loc_lat + "," + header.ews_loc_lon,
			},
			{
				"nojpl_name"	: "No JPL",
				"nojpl_value"	: " : '" + header.ews_jpl,
			},
			{
				"km_name"		: "Km",
				"km_value"	: " : " + header.ews_kms,
			},
			{
				"desa_name"		: "Desa",
				"desa_value"	: " : " + header.ews_loc_desc,
			},
			{
				"kecamatan_name"	: "Kecamatan",
				"kecamatan_value" : " : " + (header.ews_area).split(" - ")[0],
			},
			{
				"kabupaten_name" 	: "Kabupaten",
				"kabupaten_value" : " : " + (header.ews_area).split(" - ")[1],
			},
			{
				"provinsi_name"		: "Provinsi",
				"provinsi_value"	: " : " + (header.ews_area).split(" - ")[2],
			}
		);

		return hasil;
	};


  	var viewer = new Kaleidoscope.Image({
    	source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
    	containerId: '#container360',
    	height: 400,
    	width: 870,
  	});

  	$scope.showFoto = function(u){
  		var segment = (window.location.href).split("/");
		var url_access = segment[segment.length - 1];

		var width0 = 0;
		var height0 = 0;
		if(url_access == "single_ews"){
			width0 = 470;
			height0 = 300;
		}else{
			width0 = 870;
			height0 = 400;
		}

		$scope.u = u;
		viewer = new Kaleidoscope.Image({
			//source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
			source: $rootScope.base_url + 'image/ews/' + u.ews_location_image,
			containerId: '#container360',
			width: width0,
			height: height0,
		});
		viewer.render();

		window.onresize = function() {
			// viewer.setSize({height: window.innerHeight, width: window.innerWidth});
		};
		$scope.uuu = u;

		$("#modal_photo_lokasi").modal("show");
	};

	$('#modal_photo_lokasi').on('hidden.bs.modal', function () {
	    viewer.destroy();
	});


	$scope.dateFrom = null;
	$scope.dateTo = null;
	$scope.filterReport = function(ews_ip){
		var dateFrom = $(".dateFrom").val();
		var dateTo = $(".dateTo").val();

		if(!dateFrom || !dateTo){
			dateFrom = "all";
			dateTo = "all";
			//alertify.error("Silahkan pilih periode");
		// }else{
		// 	var filtered = [];
		// 	var source = $scope.snlists;
		// 	angular.forEach(source, function(value, key){
		// 		if(value.date_rpt >= dateFrom && value.date_rpt <= dateTo ){
		// 			filtered.push(value);
		// 		}			
		// 	});
		// 	$scope.datafilters = filtered;			
		}

		NewTrans.getReportEwsBySN(ews_ip, dateFrom, dateTo).then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;
		});

	};


	$scope.getEwsBySN = function(){
		var sn = $("#s_sn").val();
		var date = $("#dateRpt").val();

		NewTrans.getReportEwsBySN(sn, date).then(function(res){
			var result = res.data;
			$scope.history = result.data;

			if(result.data.length < 1){
				$scope.isNoData = true;
			}else{
				$scope.isNoData = false;
			}
		});

	};

	$scope.showDataUmum = function(u){
		NewTrans.getDataUmum(u.ews_ip).then(function(res){
			var result = res.data;
			if(result.data.length > 0){
				$scope.dataumum = result.data[0];
				$scope.ews_rambus = result.data[0].rambu_icon;
			}

			$scope.getMaintenance(u.ews_ip);

			$timeout(function() {
				$("#modal_data_umum").modal("show");
			}, 10);
			
		});

	};

	$scope.onDetails = false;
	$scope.getMaintenance = function(sn){
		NewTrans.getMaintenance(sn).then(function(res){
			var result = res.data;
			$scope.histories = result.data;

			if(result.data.length > 0){
				$scope.data_awal = result.data[0].mnt_user;
				$scope.data_akhir = result.data[result.data.length - 1].mnt_user + " - " + result.data[result.data.length - 1].mnt_type ;
			}else{
				$scope.data_awal = "";
				$scope.data_akhir = "";
			}
		});
	};

	$scope.showAndHide = function(){
		if($scope.onDetails){
			$scope.onDetails = false;
		}else{
			$scope.onDetails = true;			
		}

	};


	$scope.getWeather = function(kota){
		//https://api.apixu.com/v1/current.json?key=6733513206fb451287083310191606&q=wlingi

		// NewTrans.getWeather(kota).then(function(res){
		// 	var result = res.data;
		// 	$scope.weathers = result;
		// });

	};

	function data(offset) {
	  var ret = [];
	  for (var x = 0; x <= 360; x += 10) {
	    var v = (offset + x) % 360;
	    ret.push({
	      x: x,
	      y: Math.sin(Math.PI * v / 180).toFixed(4),
	      z: Math.cos(Math.PI * v / 180).toFixed(4)
	    });
	  }
	  return ret;
	}

	$scope.isLoadWeek = false;
	$scope.isLoadDay = false;

	$scope.isDataDay = false;
	$scope.isDataWeek = false;

	var barDay = Morris.Line({
		element: 'line-chart-day',
    data: [],
    xkey: 'x',
    ykeys: ['a'],
    labels: ["Value"],
    postUnits: '%',
    hideHover: false,
    parseTime: false,
    ymin: -1.0,
    ymax: 100.0,
    xLabelAngle: 45
	});
	var barWeek = Morris.Line({
    element: 'line-chart-week',
    yAxisLabel:"Mingguan",
    data: [],
    xkey: 'x',
    ykeys: ['a'],
    labels: ["Value"],
    postUnits: '%',
    hideHover: false,
    parseTime: false,
    ymin: -1.0,
    ymax: 100.0,
    xLabelAngle: 45		
	});

	var dataDay = [];
	$scope.showGrafikDay = function(sn){
		dataDay = [];
		$scope.isLoadDay = true;
		NewTrans.getGraphycDay(sn).then(function(res){
			var result = res.data;
			//console.log(JSON.stringify(result.data));

			if(result.data.length > 0){

				angular.forEach(result.data, function(value, key){
					dataDay.push({
						"x" : value.jam,
						"a" : (value.ews_battery_percent).toFixed(2)
					});
				});

		    $timeout(function() {
		    	barDay = Morris.Line({
		        element: 'line-chart-day',
		        data: dataDay,
		        xkey: 'x',
		        ykeys: ['a'],
		        labels: ["Value"],
		        postUnits: '%',
		        hideHover: false,
		        parseTime: false,
		        ymin: -1.0,
		        ymax: 100.0,
		        xLabelAngle: 45
		      });

		      $scope.isLoadDay = false;
		      $scope.isDataDay = true;
		    }, 1000);

		  }else{
		  	$scope.isLoadDay = false;
		  	$scope.isDataDay = false;
			}

		});
	    
	};


	var dataWeek = [];
	$scope.showGrafikWeek = function(sn){
		dataWeek = [];
		$scope.isLoadWeek = true;
		NewTrans.getGraphycWeek(sn).then(function(res){
			var result = res.data;
			// console.log(JSON.stringify(result.data));

			if(result.data.length > 0){
				angular.forEach(result.data, function(value, key){
					dataWeek.push({
						"x" : value.hari,
						"a" : (value.rata).toFixed(2)
					});
				});

		    $timeout(function() {
					if(dataWeek.length > 0){
			    	barWeek = Morris.Line({
			        element: 'line-chart-week',
			        yAxisLabel:"Mingguan",
			        data: dataWeek,
			        xkey: 'x',
			        ykeys: ['a'],
			        labels: ["Value"],
			        postUnits: '%',
			        hideHover: false,
			        parseTime: false,
			        ymin: -1.0,
			        ymax: 100.0,
			        xLabelAngle: 45
			      });
			      $scope.isLoadWeek = false;
			      $scope.isDataWeek = true;
			    
					}

		    }, 1000);
		  }else{
		  	$scope.isLoadWeek = false;
		  	$scope.isDataWeek = false;
			}

		});

	};

	$('#modal_grafik').on('shown.bs.modal', function () { //listen for user to open modal
		$(function () {
			$( "#line-chart-day" ).empty(); //clear chart so it doesn't create multiple if multiple clicks
			$( "#line-chart-week" ).empty(); //clear chart so it doesn't create multiple if multiple clicks
			$scope.showGrafikDay($scope.sn_ews);
			$scope.showGrafikWeek($scope.sn_ews);

			if(dataDay.length > 0){
				barDay.redraw();
			}

			if(dataWeek.length > 0){
				barWeek.redraw();
			}
			$(window).trigger('resize');

		});
	});

	$scope.showBatteryGraph = function(sn){
		$scope.sn_ews = sn;
  	$("#modal_grafik").modal("show");
	};


	$scope.showPvGraph = function(sn){
		$scope.sn_ews = sn;
  	$("#modal_grafik_pv").modal("show");
	};

	var dataDayPv = [];
	$scope.showGrafikDayPv = function(sn){
		dataDayPv = [];
		$scope.isLoadDay = true;
		NewTrans.getGraphycDayPv(sn).then(function(res){
			var result = res.data;
			// console.log(JSON.stringify(result.data));

			if(result.data.length > 0){

				angular.forEach(result.data, function(value, key){
					dataDayPv.push({
						"x" : value.jam,
						"a" : (value.ews_tag_pv).toFixed(2)
					});
				});

		    $timeout(function() {
		    	barDay = Morris.Line({
		        element: 'line-chart-day_pv',
		        data: dataDayPv,
		        xkey: 'x',
		        ykeys: ['a'],
		        labels: ["Value"],
		        postUnits: '%',
		        hideHover: false,
		        parseTime: false,
		        ymin: -1.0,
		        ymax: 100.0,
		        xLabelAngle: 45
		      });

		      $scope.isLoadDay = false;
		      $scope.isDataDay = true;
		    }, 1000);

		  }else{
		  	$scope.isLoadDay = false;
		  	$scope.isDataDay = false;
			}

		});
	    
	};


	var dataWeekPv = [];
	$scope.showGrafikWeekPv = function(sn){
		dataWeekPv = [];
		$scope.isLoadWeek = true;
		NewTrans.getGraphycWeekPv(sn).then(function(res){
			var result = res.data;
			// console.log(JSON.stringify(result.data));

			if(result.data.length > 0){
				angular.forEach(result.data, function(value, key){
					dataWeekPv.push({
						"x" : value.hari,
						"a" : (value.rata).toFixed(2)
					});
				});

		    $timeout(function() {
					if(dataWeekPv.length > 0){
			    	barWeek = Morris.Line({
			        element: 'line-chart-week_pv',
			        yAxisLabel:"Mingguan",
			        data: dataWeekPv,
			        xkey: 'x',
			        ykeys: ['a'],
			        labels: ["Value"],
			        postUnits: '%',
			        hideHover: false,
			        parseTime: false,
			        ymin: -1.0,
			        ymax: 100.0,
			        xLabelAngle: 45
			      });
			      $scope.isLoadWeek = false;
			      $scope.isDataWeek = true;
			    
					}

		    }, 1000);
		  }else{
		  	$scope.isLoadWeek = false;
		  	$scope.isDataWeek = false;
			}

		});

	};


	$('#modal_grafik_pv').on('shown.bs.modal', function () { //listen for user to open modal
		$(function () {
			$( "#line-chart-day_pv" ).empty(); //clear chart so it doesn't create multiple if multiple clicks
			$( "#line-chart-week_pv" ).empty(); //clear chart so it doesn't create multiple if multiple clicks
			$scope.showGrafikDayPv($scope.sn_ews);
			$scope.showGrafikWeekPv($scope.sn_ews);



			if(dataDayPv.length > 0){
				barDay.redraw();
			}

			if(dataWeekPv.length > 0){
				barWeek.redraw();
			}
			$(window).trigger('resize');

		});
	});

	$scope.video_isplay_kiri = false;
	$scope.video_isplay_kanan = false;
	$scope.showVideoKiriKanan = function(){
		$scope.video_isplay_kiri = true;
		$("#modal_kiri_kanan").modal("show");
	};

	$scope.showVideoKananKiri = function(){
		$scope.video_isplay_kanan = true;
		$("#modal_kanan_kiri").modal("show");
	};

	$scope.closeModal = function(code){
		if(code == "kiri"){
			$("#modal_kiri_kanan").modal("hide");
			var isPlaying = document.getElementById("video_ews_kiri");
			isPlaying.pause();
			isPlaying.currentTime = 0;
			$scope.video_isplay_kiri = false;
		}else{
			$("#modal_kanan_kiri").modal("hide");
			var isPlaying2 = document.getElementById("video_ews_kanan");
			isPlaying2.pause();
			isPlaying2.currentTime = 0;
			$scope.video_isplay_kanan = false;			
		}
	};

	function generateMapSensor(u){
		// ini di isi dari lokasi sensor L, C, R
		// (-6.23233,107.323423),()
		var latLngL = u.ews_loc_sensor_L;
		var latLngC = u.ews_loc_sensor_C;
		var latLngR = u.ews_loc_sensor_R;

		var locations = [];
		var lat_C = u.ews_loc_lat;
		var lng_C = u.ews_loc_lon;

		if(latLngL && latLngC && latLngR){
			var lat_L = latLngL.split(",")[0];
			var lng_L = latLngL.split(",")[1];

			lat_C = latLngC.split(",")[0];
			lng_C = latLngC.split(",")[1];

			var lat_R = latLngR.split(",")[0];
			var lng_R = latLngR.split(",")[1];

			locations = [
				{ lat: parseFloat(lat_L), lng: parseFloat(lng_L)},
				{ lat: parseFloat(lat_C), lng: parseFloat(lng_C)},
				{ lat: parseFloat(lat_R), lng: parseFloat(lng_R)}
			];
		}else{
			locations = [{
				lat: lat_C, lng: lng_C
			}];
		}

		var map = new google.maps.Map(document.getElementById("mapSensor"), {
			//scrollwheel : false,
			//gestureHandling : 'greedy',
			zoom: 20,
			center: new google.maps.LatLng(parseFloat(lat_C), parseFloat(lng_C)),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		var markers = locations.map(function(location, i) {
			return new google.maps.Marker({
				position: location,
				//label: " " + location.lat,
				//label: labels[i % labels.length]
			});
		});

		var markerCluster = new MarkerClusterer(
			map, 
			markers,
			{
				imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
			}
		);


	}


	$scope.showSensor = function(u){
		$("#modal_sensor").modal("show");

		generateMapSensor(u);

	};

	function generateMapLokasi(u){
		
		var locations = [];
		var lat_C = u.ews_loc_lat;
		var lng_C = u.ews_loc_lon;

		
		locations = [{
			lat: lat_C, lng: lng_C
		}];
		

		var map = new google.maps.Map(document.getElementById("mapLokasi"), {
			//scrollwheel : false,
			//gestureHandling : 'greedy',
			zoom: 20,
			center: new google.maps.LatLng(parseFloat(lat_C), parseFloat(lng_C)),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		var markers = locations.map(function(location, i) {
			return new google.maps.Marker({
				position: location,
				//label: " " + location.lat,
				//label: labels[i % labels.length]
			});
		});

		var markerCluster = new MarkerClusterer(
			map, 
			markers,
			{
				imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
			}
		);


	}
	

	$scope.showMapLokasi = function(u){
		$("#modal_map").modal("show");

		generateMapLokasi(u);

	};

	$scope.showHistory = function(u){

		NewTrans.getHistoryEws(u.ews_ip).then(function(res){
			$scope.histories = res.data.data;
			$("#modal_history").modal("show");
		});

	};

})


.controller('rWlCtrl',function($rootScope, $scope, $http, NewTrans, $interval, $window, $filter, $timeout){
	
	if(!$rootScope.AllInfo || $rootScope.AllInfo == "[]"){
		$window.location = $rootScope.site_url + "login";
		if($scope.page_single_code == 'single'){
			//no login needed
		}else{
			$window.location = $rootScope.site_url + "login";			
		}

	}

	$scope.s_main = true;
	$scope.s_input = false;
	$scope.s_details = false;

	$scope.getProvince = function(){
		NewTrans.getPropinsi().then(function(res){
			var result = res.data;
			$scope.provinces = result.data;
		});
	};
	$scope.getProvince();

	$scope.srch = {
		prov : 'all',
		city : 'all',
		dist : 'all'
	};

	$("#s_prov").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.prov = id;

		NewTrans.getKabupaten(id).then(function(res){
			var result = res.data;
			$scope.kabupaten = result.data;
		});
	});

	$("#s_kab").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.city = id;

		NewTrans.getKecamatan(id).then(function(res){
			var result = res.data;
			$scope.kecamatan = result.data;
		});
	});

	$("#s_kec").on('select2:selecting', function(e){
		var id = e.params.args.data.id;
		var text = e.params.args.data.text;

		$scope.srch.dist = id;

	});


	$scope.header_tittle = "add";
	$scope.getReport = function(){
		NewTrans.getReportWL($scope.srch.prov, $scope.srch.city, $scope.srch.dist).then(function(res){
			var result = res.data;
			$scope.reports = result.data;
		});
	};
	$scope.getReport();

	$scope.cancelMe = function(){
		$scope.s_main = true;
		$scope.s_input = false;
		$scope.s_details = false;
		$scope.user = null;
		$("#admLevel").val("").trigger("change");
	};

	$scope.viewDetail = function(u){
		$scope.ip_address = u.tfc_sn;
		NewTrans.getStatusAlatWl(u.wl_sn).then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;

			// $scope.header = u;
			// $("#modal_detail_tl").modal("show");

			$scope.rpt_alat = result.data;
			$("#modal_status_alat").modal("show");
			
		});
	};

	$scope.getTlByIP = function(ip){
		var date = $("#dateRpt").val();

		NewTrans.getReportTLByIP(ip, date).then(function(res){
			var result = res.data;
			$scope.history = result.data;

			if(result.data.length < 1){
				$scope.isNoData = true;
			}else{
				$scope.isNoData = false;
			}

		});

	};


	$scope.dateFrom = null;
	$scope.dateTo = null;
	$scope.filterReport = function(tfc_sn){
		var dateFrom = $(".dateFrom").val();
		var dateTo = $(".dateTo").val();

		if(!dateFrom || !dateTo){
			dateFrom = "all";
			dateTo = "all";
		}

		NewTrans.getReportTLBySn(tfc_sn, dateFrom, dateTo).then(function(res) {
			var result = res.data;
			$scope.snlists = result.data;
			$scope.datafilters = result.data;

			console.log("IP => " + tfc_sn + " From => " + dateFrom + " To => " + dateTo);

		});

	};

	$scope.getHeaderFilter = function(){
		return [
		"No", "IP", "SN", "Lokasi", "Waktu", "Pola Traffic", "Simpang 1", "Simpang 2", "Simpang 3", "Simpang 4", "Indikator Kerusakan", "Perpanjangan",
		"Perpendekan", "Flasing", "Arus AC", "Suhu", "Sinyal Modem", "Siklus"
		];
	};

	$scope.getDetailsFilter = function(){
		$scope.filenames = "details_" + $scope.ip_address + ".csv";
		var hasil = [];
		angular.forEach($scope.datafilters, function(value, key){
			hasil.push({
				"num"			: key + 1,
				"ip"		  	: value.tfc_ip,
				"sn"		  	: value.tfc_sn,
				"lokasi"  		: value.tfc_area,
				"waktu" 		: value.jam_rpt,
				"pola"			: value.tl_kode_pola,
				"simpang1"		: (value.tl_1_RYG).split(';')[2],
				"simpang2"		: (value.tl_2_RYG).split(';')[2],
				"simpang3"		: (value.tl_3_RYG).split(';')[2],
				"simpang4"		: (value.tl_4_RYG).split(';')[2],
				"indikator"		: value.tl_arus_ac == '0' ? "Tidak ada arus" : "Ada arus",
				"perpanjangan"	: value.tl_timer_panjang,
				"perpendekan"	: value.tl_timer_pendek,
				"flashing"		: value.tl_timer_flash,
				"arus"			: value.tl_arus_ac,
				"suhu"			: value.tl_suhu_panel,
				"sinyal"		: value.tl_sinyal_wifi,
				"siklus"		: value.tl_life_cycle
			});
		});

		return hasil;
	};

  	var viewer = new Kaleidoscope.Image({
    	source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
    	containerId: '#container360',
    	height: 400,
    	width: 870,
  	});

  	$scope.showFotoTL = function(u){
  		var segment = (window.location.href).split("/");
		var url_access = segment[segment.length - 1];

		var width0 = 0;
		var height0 = 0;
		if(url_access == "single_ews"){
			width0 = 470;
			height0 = 300;
		}else{
			width0 = 870;
			height0 = 400;
		}

		$scope.u = u;
		viewer = new Kaleidoscope.Image({
			//source: 'http://thiago.me/image-360/Polie_Academy_53.JPG',
			source: $rootScope.base_url + 'image/bg/' + u.wl_loc_image,
			containerId: '#container360',
			width: width0,
			height: height0,
		});
		viewer.render();

		window.onresize = function() {
			// viewer.setSize({height: window.innerHeight, width: window.innerWidth});
		};
		$scope.uuu = u;

		$("#modal_photo_lokasi").modal("show");
	};

	$('#modal_photo_lokasi').on('hidden.bs.modal', function () {
	    viewer.destroy();
	});


	$scope.showDataUmumTl = function(u){
		console.log(u.wl_sn);
		NewTrans.getDataUmumWl(u.wl_sn).then(function(res){
			var result = res.data;
			if(result.data.length > 0){
				$scope.dataumum = result.data[0];
			}

			$timeout(function() {
				$("#modal_data_umum_tl").modal("show");
			}, 10);
			
		});

	};

	$scope.showHistoryTfc = function(ip){
		$scope.mnt = {
			mnt_sn_code: ip
		};

		NewTrans.getHistoryTL(ip).then(function(res){
			$scope.histories = res.data.data;
			$("#modal_history_tfc").modal("show");
		});
	};


})

;
