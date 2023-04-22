$(document).ready(function(){
    $("#io2").slideUp(1);
    $(".io#i2").slideUp(1);
    $("#io3").slideUp(1);
    $(".io#i3").slideUp(1);
    $(".button").slideUp(1);
    $("#circle").fadeOut(1);
    var i = 1;

    $("#next").click(function(){
        switch(i){
            case 1:
                $("#io2").slideDown();
                $(".io#i2").slideDown(700);
            break;
            case 2: 
                $("#io3").slideDown();
                $(".io#i3").slideDown(700);
            break;
            case 3:
                $(".button").slideDown();
                $("#circle").fadeIn();
                $("#next").fadeOut();
            break;
        }
        i ++;
    })
})