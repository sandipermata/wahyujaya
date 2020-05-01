/*
	custom-menu-handler.js
	version 1.0 stable

	edited by yayan agustyan
	5th, November 2016
	original source : http://stackoverflow.com/questions/11533542/twitter-bootstrap-add-active-class-to-li
*/

/*menu handler*/
$(function(){
  function stripTrailingSlash(str) {
    if(str.substr(-1) == '/') {
      return str.substr(0, str.length - 1);
    }
    return str;
  }

  var url = window.location.protocol + "//" + window.location.host + window.location.pathname;  
  var activePage = stripTrailingSlash(url);
  
  $('.sidebar-menu li a').each(function(){  
    var currentPage = stripTrailingSlash($(this).attr('href'));

		//set active class for single menu
    if (activePage == currentPage) {
      $(this).parent().addClass('active'); 
    } 
	
	//looping to find child treeview menu
	$('.treeview li a').each(function(){
			var currentChilPage = stripTrailingSlash($(this).attr('href'));			
			//set active class for treeview child menu
			if (activePage == currentChilPage) {
				$(this).parent().addClass('active'); 
				$(this).parent().parent().parent().addClass('active'); 
			}
		});

  });

});