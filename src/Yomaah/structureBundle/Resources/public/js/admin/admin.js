/* Event sur class admin-btn */
var click = false;
var min = false;
var currentNavBarId = null;
var onglets = {};
var maj = {};

$(document).on('click', '.admin-btn', function (){

    $(document).scrollTop(0);
    $('#slider').nivoSlider("stop");
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
            currentNavBarId = $(this).children('input[type="hidden"]').first().val();
            hide = true;
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
    var tmp = onglets;
    onglets = unsetArray(tmp, attr);
    if (focus){
        var next = $(this).parent().next()
        if ($(this).parent().next().length == 0){
            var next = $(this).parent().prev();
        }
        $(this).parent().remove();
        $('.'+attr).remove();
        currentNavBarId = next.children('input[type="hidden"]').first().attr('id');
        next.addClass('ongletFocus');
        attr = '.'+next.attr('id');
        $(attr).addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
    }else{
        save['onglet'] = $('.ongletFocus').first();
        save['content'] = $('.focus').first();
        $(this).parent().remove();
        $('.'+attr).remove();
        save['onglet'].addClass('ongletFocus');
        save['content'].addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
    }
    /* Utilisé pour l'évenement click sur .onglet */
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
            currentNavBarId = _id;
            onglets[_id] = new Onglet(_id);
            onglets[_id].setId($(newOnglet).attr('id'));
            hide = true;
            addDisplayContent(onglets[_id]);
        });
    }else
    {
        $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
        $('.ongletFocus').removeClass('ongletFocus');
        $('#' + onglets[_id].id).addClass('ongletFocus');
        $('.' + onglets[_id].id).addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
        currentNavBarId = _id;
    }
});

/* Event sur les miniatures*/
var hide = true;
var modifPanel = null;
var toMajBackground = '#909090';
var normalBackground = '#a5aabf';
var clickBackground = '#606fdb';

$(document).on('click', '.miniature', function(){
   var _id = $(this).children('input[type="hidden"]').val();
   var modifPanelContainer = $('.' + onglets[currentNavBarId].id).children('.modifPanelContainer');
   var modifPanels = $('.' + onglets[currentNavBarId].id+' .modifPanelContainer').children('.modifPanel');
   var miniatureContainer = $('.'+onglets[currentNavBarId].id).children('.miniaturesContainer');
   var miniature = $('.'+onglets[currentNavBarId].id+ ' .miniaturesContainer').children(' .miniature');
   var test = (onglets[currentNavBarId].testSavedElementExists(_id));
   miniature.each(function(){
       //if (onglets[currentNavBarId].testSavedElementExists($(this).children('input[type="hidden"]').val())){
       //}else{
       //}
       $(this).css({'background-color' : normalBackground});
   });
   if (hide){
       modifPanelContainer.show();
       modifPanels.hide();
       //if (test){
           ////$(this).css({'background-color' : toMajBackground});
       //}else{
       //}
       $(this).css({'background-color' : clickBackground});
       modifPanels.each(function(){
           if (_id == $(this).children('input[type="hidden"]').val()){
               miniatureContainer.animate({'height' : '55%'});
               $(this).show();
               $(this).animate({'display' : 'block', 'position': 'relative'});
               modifPanel = $(this);
               hide = false;
               miniature.animate({'width' : '10%', 'maxHeight' : '8em', 'font-size' :'0.8em'});
               if (miniature.children('.description-text').length > 0){
                    miniature.children('.description-text').children('div').children('p').animate({ 'font-size': '0.8em', 'margin-left': '0.1em'});
                    miniature.children('.description-text').children('div').children('.desc-title').animate({ 'font-size': '0.9em'});
               }
               modifPanelContainer.resizable('enable');
           }
       });
   }else{
       var notSame = true;
       miniature.each(function(){
           //if (onglets[currentNavBarId].testSavedElementExists($(this).children('input[type="hidden"]').val())){
           //}else{
           //}
           $(this).css({'background-color' : normalBackground});
       });
       if (_id == modifPanel.children('input[type="hidden"]').val()){
            miniatureContainer.animate({'height':'100%'});
            $(modifPanel).animate({'display' : 'none', 'position': 'absolute'});
            modifPanelContainer.hide();
            miniature.animate({'width' : '15%', 'maxHeight' : '10em','height' : '10em', 'font-size' :'1.0em' });
            modifPanelContainer.resizable("disable");
            modifPanel = null;
            if (miniature.children('.description-text').length > 0){
                 miniature.children('.description-text').children('div').children('p').animate({ 'font-size': '1em', 'margin-left': '1em'});
                 miniature.children('.description-text').children('div').children('.desc-title').animate({ 'font-size': '1em'});
            }
            hide = true;
            notSame = false;
       }
       if (notSame){
           //if (test == false){
           //}else{
           //}
           $(this).css({'background-color' : clickBackground});
           modifPanels.hide();
           modifPanels.each(function(){
               if (_id == $(this).children('input[type="hidden"]').first().val()){
                   $(this).show();
                   $(this).animate({'display' : 'block', 'position': 'relative'});
                   modifPanel = $(this);
               }
           });
           hide = false;
       }
   }
});
/* Evenement sur input */
$(document).on('change', 'input', function(){
    var _id =  $(this).parents('.modifPanel').children('input[type="hidden"]').val();
    changeBackgroundOnChange(_id);
});

$(document).on('change', 'textarea', function(){
    var _id =  $(this).parents('.modifPanel').children('input[type="hidden"]').val();
    changeBackgroundOnChange(_id);
});


