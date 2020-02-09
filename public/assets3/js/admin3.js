function resize(){
    if($(window).width() <= 1200){
        $('body').removeClass('g-sidenav-pinned').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
    }
}
$(document).ready(function(){
    resize();
});
$(window).resize(function(){
    resize();
});

var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
var arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
function convertPersianNumbers(str){
    if(typeof str === 'string'){
        for(var i=0; i<10; i++){
            str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
    }
    return str;
};

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
$('.img_upload button').addClass('btn-default');

$('body').on('keydown keyup', '.float_number', function (e) {
    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 9 || e.keyCode == 8 || e.keyCode == 110 || e.keyCode == 190 || e.keyCode == 39 || e.keyCode == 37){
    }else{e.stopPropagation(); return false;}
});

$('body').on('keyup', '.price_number', function (evt) {
    var element = $(this);
    var number = $(this).val();
    number = number.replace(",","");
    if(number !=""){
         if(evt.which != 110 && evt.which != 190){
             var n = parseFloat($(this).val().replace(/\,/g,''),10);
             $(this).val(n.toLocaleString());
         }
        //$(this).val(numeral(number).format('0,0'));
    }
});

function load_screen(is_on, time_out = 0) {
    if (time_out == 0) {
        if (is_on) {
            $('.load_screen').fadeIn(100).css('display','flex');
        } else { $('.load_screen').fadeOut(100); }
    } else {
        setTimeout(function () {
            if (is_on) { $('.load_screen').fadeIn(100).css('display','flex').focus(); } else { $('.load_screen').fadeOut(100); }
        }, time_out);
    }
}
$('body').on('keyup','.load_screen',function(e){
    if(e.keyCode == 27){load_screen(false);}
});

var notify_setting = {
    placement: { from:"top",align:"left" },
    delay: 2000,
    animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutUp'
    },
    allow_dismiss: true,
    type: 'success',
    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close left-3" data-notify="dismiss">×</button>' +
                '<div class="d-flex align-items-center"> ' +
                    '<span class="ml-3" data-notify="icon"></span> ' +
                    '<div class="d-flex flex-column"> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                    '</div> ' +
                '</div> ' +
                '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>' 
}

$('body').on('click','.password_visiable_btn',function(){
    var input = $(this).prev();
    if(input.attr('type') == 'password'){
        input.prop('type','text');
    }else{input.prop('type','password');}
});