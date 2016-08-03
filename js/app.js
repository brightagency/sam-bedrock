/*global document, window, $ */
/*jshint globalstrict: true */
'use strict';

/** Instantiate Foundation */
$(document).foundation();

/** On Document Load */
$(function () {

    // App code here...
    window.console.log("Now Running: Sam Bedrock Theme");

    // Configure matchHeight on the .matchHeight class
    $('.matchHeight').matchHeight();

});