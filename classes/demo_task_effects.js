$(document).ready(function(){
    setInterval(callMe,2000);
    $("#t3").slideUp(1);
    $("#t4").slideUp(1);
    $("#task0").slideUp(1);
    $(".button").slideUp(1);
    $("#next_task").slideUp(1);
    $("#circle").fadeOut(1);
    var i = 0;

    $("#next").click(function(){
        switch(i){
            case 0:
                $("#t1").slideUp(100);
                $("#t2").slideUp(100);    
                $("#t3").delay(100).slideDown(500);
                $("#t4").delay(100).slideDown(500);
                $("#white_rectangle").slideUp(500);
                $("#next").animate({width: '55vw', right: '0'},500);
                $("#table").delay(500).animate({scrollTop: $("#table").height()}, 10000);
            break;
            case 1: 
                $("#three_arrows").animate({opacity: '0'});
                $("#t3").slideUp(100);
                $("#t4").slideUp(100);
                $("#task0").delay(100).slideDown(500);
                $(".button").slideDown();
                $("#circle").fadeIn();
                $("#next").fadeOut();
                $("#next_task").delay(100).slideDown(500);
            break;
        }
        i ++;
    })
});
function callMe(){
    $("#three_arrows").animate({top:'18vh'}).fadeIn().animate({top:'60vh'}).fadeOut();
}