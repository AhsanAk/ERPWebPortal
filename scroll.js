/**
 * Created by AHSAN AK on 10/17/2016.
 */

function scroll(){


    var subHeaderHeightFromTop, subHeaderHeight;
    subHeaderHeight = $('#sub-header').height() + 20;
    subHeaderHeightFromTop = $('#sub-header').offset().top;


    $("body").animate({
        scrollTop:  subHeaderHeightFromTop - subHeaderHeight
    }, 400);
}


scroll();


