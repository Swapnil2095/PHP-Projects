/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';

function Slider() {

    //settings for slider
    var width = 1000;
    var animationSpeed = 1000;
    var pause = 4000;
    var currentSlide = 1;
    var originalSetup = 0;
    var lastSlide = 5;

    //cache DOM elements
    var $slider = $('#Slider');
    var $slideContainer = $slider.find('.tweetSlides');
    var $slides = $slideContainer.find('.Slide');
  
    //console.log(document.getElementsByClassName("tweetSlide").length);
    var interval;
    var lastSlide  = $slides.length; /*5*/
    originalSetup = lastSlide * width;
 
    function startSlider() {
        interval = setInterval(function () {
            
            $slideContainer.animate({'margin-left': '-=' + width +'px'}, animationSpeed, function () {
                if (++currentSlide === lastSlide ) {
                    console.log(currentSlide);                                       
                    currentSlide = 1; 
                    $('#Slider .tweetSlides').css('margin-left',  0 + 'px'); 
                    
                }
            });
            
        }, pause);
    }

    function pauseSlider() {
        clearInterval(interval);
    }

    //$('#Slider .tweetSlides').on('mouseenter', pauseSlider).on('mouseleave', startSlider);

    startSlider();


};