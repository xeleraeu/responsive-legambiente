/**
 * handle eu cookie control
 *
 * all cookie code (c) Copyright Catapult Themes, distributed under GPL-2.0+
 */
jQuery(document).ready(function($){
  if(!catapultReadCookie("eucookieAccepted")){ // If the cookie has not been set then show the bar
    $(".eu-cookie-control").addClass("active");
    $(".eu-cookie-control .dismiss").on('click', function() {catapultAcceptCookies();});
  }
});

//All the cookie setting stuff
function catapultSetCookie(cookieName, cookieValue, nDays) {
	var today = new Date();
	var expire = new Date();
	if (nDays==null || nDays==0) nDays=1;
	expire.setTime(today.getTime() + 3600000*24*nDays);
	document.cookie = cookieName+"="+escape(cookieValue)+ ";expires="+expire.toGMTString()+"; path=/";
}
function catapultReadCookie(cookieName) {
	var theCookie=" "+document.cookie;
	var ind=theCookie.indexOf(" "+cookieName+"=");
	if (ind==-1) ind=theCookie.indexOf(";"+cookieName+"=");
	if (ind==-1 || cookieName=="") return "";
	var ind1=theCookie.indexOf(";",ind+1);
	if (ind1==-1) ind1=theCookie.length;
	// Returns true if the versions match
	return xelera_eu_cookie_control_vars.version == unescape(theCookie.substring(ind+cookieName.length+2,ind1));
}
function catapultDeleteCookie(cookieName) {
	document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
}
function catapultAcceptCookies() {
	catapultSetCookie('eucookieAccepted', xelera_eu_cookie_control_vars.version, xelera_eu_cookie_control_vars.expiry);
	jQuery(".eu-cookie-control").removeClass('active');
}
