let isShowed = false;

$("#responsive-button").click(function(){
    if(isShowed == false){
        $("#navbar-content").css({'display': 'flex', 'height': '75vh'});
        $("nav").css({"height" : "100vh", "position" : "fixed", "width":"100%"})
        $("#search-bar").hide()
        isShowed = true
    }else{
        $("#navbar-content").hide()
        $("#navbar-content").css('height', 'auto');
        $("nav").css({'height': 'auto', "position" : "static", "width":"100%"})
        isShowed = false
    }
})