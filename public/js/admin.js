function checkEmail(e){ var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/; return regex.test(e); }
function resize() {
    $('.content-wrapper').css('min-height', $(window).height());
    $('.dialog').css('max-height', $(window).height() - 60);
    // if($(window).width() >= 800){
    //     $('.dialog').css('left', $(window).width() / 8 + 45);
    // }else{ $('.dialog').css('left', $(window).width() / 8 + 45); }
    $('.select_dialog').css('left', $(window).width() / 2 - 300);
    $('.side-menu').height($(window).height() - 130);
}
resize();
$(window).resize(function () {
    resize();
});

function imgAddress(input,path){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){ path.attr('src',e.target.result); }
        reader.readAsDataURL(input.files[0]);
    }
}
$('body').on('change','.file_upload',function(){
    imgAddress(this,$(this).closest('div').children('img'));
});

$('body').on('keydown keyup', '.float_number', function (e) {
    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 9 || e.keyCode == 8 || e.keyCode == 110 || e.keyCode == 190 || e.keyCode == 39 || e.keyCode == 37){
    }else{e.stopPropagation(); return false;}
});

function load_screen(is_on, time_out = 0) {
    if (time_out == 0) {
        if (is_on) {
            $('.load_screen').fadeIn(100);
        } else { $('.load_screen').fadeOut(100); }
    } else {
        setTimeout(function () {
            if (is_on) { $('.load_screen').fadeIn(100); } else { $('.load_screen').fadeOut(100); }
        }, time_out);
    }
}

//Dialogs------------------------------
$('.black_screen').click(function () {
    // $(this).fadeOut(300); $('.dialogs').fadeOut(400).css('display','none');
    // $('.dialog').slideUp(300);
});
$('.ibox-head > b').click(function () {
    $(this).closest('.dialog').slideUp(300); $('.dialogs').fadeOut(400);
});
$('.btn-cancel,.btn_back').click(function () {
    $('.black_screen').click();
});
$('body').mousemove(function(e){
    $('.mouse_alert').css('top',e.clientY+8).css('left',e.clientX+8);
});
function load_screen(is_on, time_out = 0){
    if(time_out == 0){
        if(is_on){$('.load_screen').fadeIn(100).css('display','flex');}else{$('.load_screen').fadeOut(100).css('display','none');}
    }else{
        setTimeout(function(){ if(is_on){ $('.load_screen').fadeIn(100).css('display','flex'); } else { $('.load_screen').fadeOut(100).css('display','none'); } },time_out);
    }
}

$('.sidebar-toggler').click(function(){
    if(!$('body').hasClass('drawer-sidebar')){
        $('.content-wrapper').toggleClass('content-wrapper-right');
    }else{$('.content-wrapper').removeClass('content-wrapper-right');}
});