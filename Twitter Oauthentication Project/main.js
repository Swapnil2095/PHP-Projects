/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';

function Slider() {

    //settings for slider
    var height = 150;
    var animationSpeed = 1000;
    var pause = 1000;
    var currentSlide = 1;

    //cache DOM elements
    var $slider = $('#Slider');
    var $slideContainer = $slider.find('.tweetSlides');
    var $slides = $slideContainer.find('.tweetSlide');
  
    console.log(document.getElementsByClassName("tweetSlide").length);
    var interval;
    
   

    function startSlider() {
        interval = setInterval(function () {
            $slideContainer.animate({'margin-top': '-=' + height}, animationSpeed, function () {
                if (++currentSlide === $slides.length) {
                                                           
                    currentSlide = 1;                    
                    $slideContainer.css("margin-top", 0);
                    $('#Slider.tweetSlides').css("margin-top", 0);
                    //$slideContainer.css("margin-bottom", 0);
                    //$slideContainer.css("top", 0);
                    //$slideContainer.css("bottom", 0);
                  
                }
            });
        }, pause);
    }

    function pauseSlider() {
        clearInterval(interval);
    }

    //$slideContainer.on('mouseenter', pauseSlider).on('mouseleave', startSlider);

    startSlider();


};