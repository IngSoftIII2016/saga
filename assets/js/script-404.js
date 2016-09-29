/*** Document Ready Functions ***/
jQuery(document).ready(function(){

	"use strict";
$(".button").click(function(){
	$(".side-panel").toggleClass("show");
});		

$(".pat1").click( function(){
	$("body").addClass('pattern1');
	$("body").removeClass('pattern2');
	$("body").removeClass('pattern3');
	$("body").removeClass('pattern4');
	$("body").removeClass('pattern5');
	$("body").removeClass('pattern6');
	$("body").removeClass('pattern7');
});

$(".pat2").click( function(){
	$("body").removeClass('pattern1');
	$("body").addClass('pattern2');
	$("body").removeClass('pattern3');
	$("body").removeClass('pattern4');
	$("body").removeClass('pattern5');
	$("body").removeClass('pattern6');
	$("body").removeClass('pattern7');
});

$(".pat3").click( function(){
	$("body").removeClass('pattern1');
	$("body").removeClass('pattern2');
	$("body").addClass('pattern3');
	$("body").removeClass('pattern4');
	$("body").removeClass('pattern5');
	$("body").removeClass('pattern6');
	$("body").removeClass('pattern7');
});

$(".pat4").click( function(){
	$("body").removeClass('pattern1');
	$("body").removeClass('pattern2');
	$("body").removeClass('pattern3');
	$("body").addClass('pattern4');
	$("body").removeClass('pattern5');
	$("body").removeClass('pattern6');
	$("body").removeClass('pattern7');
});

$(".pat5").click( function(){
	$("body").removeClass('pattern1');
	$("body").removeClass('pattern2');
	$("body").removeClass('pattern3');
	$("body").removeClass('pattern4');
	$("body").addClass('pattern5');
	$("body").removeClass('pattern6');
	$("body").removeClass('pattern7');
});

$(".pat6").click( function(){
	$("body").removeClass('pattern1');
	$("body").removeClass('pattern2');
	$("body").removeClass('pattern3');
	$("body").removeClass('pattern4');
	$("body").removeClass('pattern5');
	$("body").addClass('pattern6');
	$("body").removeClass('pattern7');
});

});