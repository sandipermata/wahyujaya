angular.module('starter.services', [])

.factory('LoginSrv', function($http,$filter, $rootScope){
  return{
    login: function(usr, pass){
      return $http.get($rootScope.api_url+'/login/'+usr+'/'+pass, { "headers": { "x-token": $rootScope.hashKey }});
    },
	};
})

.factory('NewTrans', function($http,$filter, $rootScope){
	return{
		setSession: function(key, value){
			return $http.get($rootScope.site_url+'dashboard/set_session/' + key + '/' + value, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getUser: function(){
			return $http.get($rootScope.api_url+'/user', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getUserId: function(id){
			return $http.get($rootScope.api_url+'/user_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveUser: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/user', data);
		},
		updateUser: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/user', data);
		},
		deleteUser: function(id){
			return $http.delete($rootScope.api_url+'/user/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getUserMenu: function(id){
			return $http.get($rootScope.api_url+'/user_menu/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getUserMenuData: function(id){
			return $http.get($rootScope.api_url+'/user_menu_data/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveMenuUser: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/user_menu_data', data);
		},
		deleteMenu: function(id){
			return $http.delete($rootScope.api_url+'/user_menu/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getMenus: function(){
			return $http.get($rootScope.api_url+'/menus_data', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getMenu: function(){
			return $http.get($rootScope.api_url+'/menu_data', { "headers": { "x-token": $rootScope.hashKey }});
		},


		getPropinsi: function(){
			return $http.get($rootScope.api_url+'/province', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getKabupaten: function(provcode){
			return $http.get($rootScope.api_url+'/city/' + provcode, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getKecamatan: function(kabcode){
			return $http.get($rootScope.api_url+'/district/' + kabcode, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getHeadPosisiTL: function(kecamatan){
			return $http.get($rootScope.api_url+'/header_traffic/' + kecamatan, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getPosisiTL: function(ip){
			return $http.get($rootScope.api_url+'/traffic/' + ip, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getHeadPosisiEws: function(kecamatan){
			return $http.get($rootScope.api_url+'/header_ews/' + kecamatan, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getPosisiEws: function(ip){
			return $http.get($rootScope.api_url+'/ews/' + ip, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getHeadPosisiWL: function(kecamatan, project){
			return $http.get($rootScope.api_url+'/header_warning/' + kecamatan + "/" + project , { "headers": { "x-token": $rootScope.hashKey }});
		},
		getPosisiWl: function(){
			return $http.get($rootScope.api_url+'/warning', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getPosisiPju: function(){
			return $http.get($rootScope.api_url+'/pju', { "headers": { "x-token": $rootScope.hashKey }});
		},

		//MASTER
		//TRAFFIC
		getTraffic: function(){
			return $http.get($rootScope.api_url+'/m_traffic', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getTrafficId: function(id){
			return $http.get($rootScope.api_url+'/m_traffic_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveDataTL: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_traffic', data);
		},
		updateDataTL: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_traffic', data);
		},
		updateDataTLMaster: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/master_traffic', data);
		},
		deleteDataTL: function(id){
			return $http.delete($rootScope.api_url+'/m_traffic/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getTrafficD: function(id){
			return $http.get($rootScope.api_url+'/m_traffic_d/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveDataTLD: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_traffic_d', data);
		},
		updateDataTLD: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_traffic_d', data);
		},

		saveFromUploadTL: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/save_from_upload_tl', data);
		},

		getHistoryTL: function(ip){
			return $http.get($rootScope.api_url+'/history_tfc/' + ip, { "headers": { "x-token": $rootScope.hashKey }});
		},

		saveHistoryTL: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/save_history_tfc', data);
		},

		updateHistoryTL: function(data, code){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/update_history_tfc/' + code, data);
		},

		deleteHistoryTL: function(id){
			return $http.delete($rootScope.api_url+'/delete_history_tfc/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getDataUmumTl: function(id){
			return $http.get($rootScope.api_url + '/data_umum_tl/' + id, {"headers" : { "x-token": $rootScope.hashKey} });
		},

		//EWS
		getEws: function(){
			return $http.get($rootScope.api_url+'/m_ews', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getEwsId: function(id){
			return $http.get($rootScope.api_url+'/m_ews_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveDataEws: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_ews', data);
		},
		updateDataEws: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_ews', data);
		},
		deleteDataEws: function(id){
			return $http.delete($rootScope.api_url+'/m_ews/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		getHistoryEws: function(ip){
			return $http.get($rootScope.api_url+'/history_ews/' + ip, { "headers": { "x-token": $rootScope.hashKey }});
		},

		saveHistoryEws: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/save_history_ews', data);
		},

		updateHistoryEws: function(data, code){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/update_history_ews/' + code, data);
		},

		deleteHistoryEws: function(id){
			return $http.delete($rootScope.api_url+'/delete_history_ews/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveFromUploadEWS: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/save_from_upload_ews', data);
		},

		//WARNING LIGHT
		getWL: function(){
			return $http.get($rootScope.api_url+'/m_warning', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getWLId: function(id){
			return $http.get($rootScope.api_url+'/m_warning_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveDataWL: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_warning', data);
		},
		updateDataWL: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_warning', data);
		},
		getWLProject: function(){
			return $http.get($rootScope.api_url+'/m_warning_project', { "headers": { "x-token": $rootScope.hashKey }});
		},

		//WARNING LIGHT DETAIL
		getWlDId: function(id){
			return $http.get($rootScope.api_url+'/m_warning_d_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getWlDashId: function(id){
			return $http.get($rootScope.api_url+'/m_warning_by_sn/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		
		//saveDataWLD
		saveDataWLD: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_warning_d', data);
		},
		//updateDataWLD
		updateDataWLD: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_warning_d', data);
		},
		deleteDataWLD: function(id){
			return $http.delete($rootScope.api_url+'/m_warning_d/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		//report
		getDataUmumWl: function(id){
			return $http.get($rootScope.api_url + '/data_umum_wl/' + id, {"headers" : { "x-token": $rootScope.hashKey} });
		},
		getStatusAlatWl: function(sn){
			return $http.get($rootScope.api_url + '/status_alat/' + sn, {"headers" : { "x-token": $rootScope.hashKey} });
		},


		//PJU
		getPju: function(){
			return $http.get($rootScope.api_url+'/m_pju', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getPjuId: function(id){
			return $http.get($rootScope.api_url+'/m_pju_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveDataPju: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_pju', data);
		},
		updateDataPju: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_pju', data);
		},
		deleteDataPju: function(id){
			return $http.delete($rootScope.api_url+'/m_pju/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},

		//ICONS
		getIcons: function(){
			return $http.get($rootScope.api_url+'/m_icons', { "headers": { "x-token": $rootScope.hashKey }});
		},
		getIconsId: function(id){
			return $http.get($rootScope.api_url+'/m_icons_id/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getIconsType: function(type){
			return $http.get($rootScope.api_url+'/m_icons_type/' + type, { "headers": { "x-token": $rootScope.hashKey }});
		},
		saveDataIcons: function(data){
			$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.post["Content-Type"] = "application/json";
			$http.defaults.headers.post["x-token"] = $rootScope.hashKey;
			return $http.post($rootScope.api_url+'/m_icons', data);
		},
		updateDataIcons: function(data){
			$http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";
			$http.defaults.headers.put["Content-Type"] = "application/json";
			$http.defaults.headers.put["x-token"] = $rootScope.hashKey;
			return $http.put($rootScope.api_url+'/m_icons', data);
		},
		deleteDataIcons: function(id){
			return $http.delete($rootScope.api_url+'/m_icons/' + id, { "headers": { "x-token": $rootScope.hashKey }});
		},


		//REPORT
		getReportTL: function(prov, city, dist){
			return $http.get($rootScope.api_url+'/rpt_tfc_by/' + prov + '/' + city + '/' + dist, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getReportTLBySn: function(sn, from, to){
			return $http.get($rootScope.api_url+'/rpt_tfc_sn/' + sn + '/' + from + '/' + to, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getReportTLByIP: function(ip, date){
			return $http.get($rootScope.api_url+'/rpt_tl_ip/' + ip + '/' + date , { "headers": { "x-token": $rootScope.hashKey }});
		},


		getReportEws: function(prov, city, dist){
			return $http.get($rootScope.api_url+'/rpt_ews_by/' + prov + '/' + city + '/' + dist , { "headers": { "x-token": $rootScope.hashKey }});
		},
		getReportEwsByCity: function(city){
			return $http.get($rootScope.api_url+'/rpt_ews_city/' + city, { "headers": { "x-token": $rootScope.hashKey }});
		},
		getReportEwsBySN: function(sn, from, to){
			return $http.get($rootScope.api_url+'/rpt_ews_sn/' + sn + '/' + from + '/' + to , { "headers": { "x-token": $rootScope.hashKey }});
		},

		parsingEWS: function(){
			return $http.get($rootScope.api_url+'/input_ews' , { "headers": { "x-token": $rootScope.hashKey }});
		},

		getDashSum: function(){
			return $http.get($rootScope.api_url+'/dash_sum' , { "headers": { "x-token": $rootScope.hashKey }});
		},
		getDashSumTL: function(){
			return $http.get($rootScope.api_url+'/dash_sum_tl' , { "headers": { "x-token": $rootScope.hashKey }});
		},
		getDashSumWL: function(){
			return $http.get($rootScope.api_url+'/dash_sum_wl' , { "headers": { "x-token": $rootScope.hashKey }});
		},

		getProject: function(){
			return $http.get($rootScope.api_url + '/projects', {"headers" : { "x-token": $rootScope.hashKey} });
		},
		getRambu: function(){
			return $http.get($rootScope.api_url + '/rambus', {"headers" : { "x-token": $rootScope.hashKey} });
		},

		getDataUmum: function(id){
			return $http.get($rootScope.api_url + '/data_umum/' + id, {"headers" : { "x-token": $rootScope.hashKey} });
		},

		getMaintenance: function(id){
			return $http.get($rootScope.api_url + '/maintenance/' + id, {"headers" : { "x-token": $rootScope.hashKey} });
		},

		getGraphycDay: function(sn){
			return $http.get($rootScope.api_url + '/graphic_batt_day/' + sn, {"headers" : { "x-token": $rootScope.hashKey} });
		},
		getGraphycWeek: function(sn){
			return $http.get($rootScope.api_url + '/graphic_batt_week/' + sn, {"headers" : { "x-token": $rootScope.hashKey} });
		},

		getGraphycDayPv: function(sn){
			return $http.get($rootScope.api_url + '/graphic_pv_day/' + sn, {"headers" : { "x-token": $rootScope.hashKey} });
		},
		getGraphycWeekPv: function(sn){
			return $http.get($rootScope.api_url + '/graphic_pv_week/' + sn, {"headers" : { "x-token": $rootScope.hashKey} });
		},



		parsingTL: function(){
			return $http.get($rootScope.api_url+'/input_tl' , { "headers": { "x-token": $rootScope.hashKey }});
		},


		getWeather: function(kota){
			return $http.get("http://api.weatherstack.com/current?access_key=61cc78ba51873afa238930c821b5abf9&query=" + kota );
		},

		getArahKereta: function(sn){
			return $http.get($rootScope.api_url + '/arah_kereta/' + sn, {"headers" : { "x-token": $rootScope.hashKey} });
		},



		parsingWL: function(){
			return $http.get($rootScope.api_url+'/input_wl' , { "headers": { "x-token": $rootScope.hashKey }});
		},

		getReportWL: function(prov, city, dist){
			return $http.get($rootScope.api_url+'/rpt_wl_by/' + prov + '/' + city + '/' + dist, { "headers": { "x-token": $rootScope.hashKey }});
		},
		
	};
});
