$(document).ready(function(){
    if(screen.width > 450){
        $(".slider").bxSlider({
            auto: true,
            stopAutoOnClick: true,
            slideWidth: 1000,
            controls: false
        })
    }
})