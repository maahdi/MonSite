/* Event sur class admin-btn */
var click = false;
var min = false;
var id = null;

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
           $('.onglet').addClass('ongletFocus');
           $('.content').addClass('focus');
           $('.AdminPanel').slideToggle(500).css({'display' : 'block', 'z-index' : '90', 'left' : '0'});
           btn.css({'top' : '0.6em'});
           click = true;
           min = true;
        });
    }
});
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
/* Event sur click onglet */
/*
 * Pas oublier de faire pareil pour les toolbars
 */
/* Fix quand clic sur le bouton fermer de l'onglet */
var close = false;
$(document).on('click', '.onglet', function(){
    if (close){
        close = false;
    }else{
        if ($(this).hasClass('ongletFocus') == false)
        {
            $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
            $('.ongletFocus').removeClass('ongletFocus');
            $(this).addClass('ongletFocus');
            var attr = '.'+$(this).attr('id');
            id = $(this).children('input[type="hidden"]').first().val();
            $(attr).addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
        }
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
    var focus = $(this).parent().hasClass('ongletFocus');
    var attr = $(this).parent().attr('id');
    var save = new Array;
    if (countOnglet() == 1){
        focus = false;
    }
    if (focus){
        var next = $(this).parent().next()
        if ($(this).parent().next().length == 0){
            var next = $(this).parent().prev();
        }
        $(this).parent().remove();
        $('.'+attr).remove();
        id = next.children('input[type="hidden"]').first().attr('id');
        next.addClass('ongletFocus');
        attr = '.'+ next.attr('id');
        $(attr).addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
    }else{
        save['onglet'] = $('.ongletFocus').first();
        save['content'] = $('.focus').first();
        $(this).parent().remove();
        $('.'+attr).remove();
        save['onglet'].addClass('ongletFocus');
        save['content'].addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
    }
    close = true;
});


/* Event sur les boutons de navBar */
$(document).on('click','.navBar-btn', function(){
    var _id = $(this).attr('id');
    if (testExistsInDom(_id, 'input[type="hidden"]', '.onglet') === false){
        sendJson('ajax/getInterfaceHtml', { 'id' : _id }, function(data){
            var newOnglet = data.onglet;
            var newContent = data.content;
            var newToolbar = data.toolBar;
            appendDisplay(newOnglet, newContent, newToolbar);
            id = _id;
        });
    }else
    {
        $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
        $('.ongletFocus').removeClass('ongletFocus');
        $('.onglet').each(function(){
            var attr = null;
            if ($(this).children('input[type="hidden"]').first().val() != 'accueil' 
                && $(this).children('input[type="hidden"]').first().val() == _id){
                    $(this).addClass('ongletFocus');
                    attr = '.'+ $(this).attr('id');
                    $(attr).addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
                    id = _id;
            }
        });
    }
});


