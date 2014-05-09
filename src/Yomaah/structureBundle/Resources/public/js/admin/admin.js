var click = false;
var min = false;
$(document).on('click', '.admin-btn', function (){

    $(document).scrollTop(0);
    if ($('.AdminPanel').length)
    {
       $('.AdminPanel').slideToggle(500);

    }else
    {
        var btn = $(this);
        sendAjax('ajax/getInterface', function(data){
           $('body').prepend(data); 
           $('.onglet').addClass('focus ongletFocus');
           $('.content').addClass('focus');
           $('.AdminPanel').slideToggle(500).css({'display' : 'block', 'z-index' : '90', 'left' : '0'});
           btn.css({'top' : '0.6em'});
           click = true;
           min = true;
        });
    }
});
/* Event sur class .close */
$(document).on('mouseover', '.close', function(){
    $(this).css({ 'width' : '1.2em', 'height' : '1.2em'});
});
$(document).on('mouseleave', '.close', function(){
    $(this).css({ 'width' : '1em', 'height' : '1em'});
});
$(document).on('click', '.close', function(){
    var id = $(this).parent().attr('id');
    $(this).parent().parent().parent().children('.'+id).first().remove();
    $(this).parent().remove();

});
/* Event sur class admin-btn */
$('.admin-btn').hover(function(){
    if (click)
    {
        if (min)
        {
            $(this).css({ 'top' : '3em'});
            min = false;
        }
    }
}, function(){
    if (click){
        if (min === false){
            $(this).css({ 'top' : '0.6em'});
            min = true;
        }
    }
});

