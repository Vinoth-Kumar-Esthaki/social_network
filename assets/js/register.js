"use strict";
$(document).ready(function(){

	// on click on sign up hide sign in and show registration form
	$("#signup").click(function(){
		$("#first").slideUp("slow",function(){
			$("#second").slideDown("slow");
		});

	});

	// on click on sign in hide registration form and show sign in form
	$("#signin").click(function(){
		$("#second").slideUp("slow",function(){
			$("#first").slideDown("slow");
		});
	});
});