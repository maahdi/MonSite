/* Event sur class admin-btn */
var click = false;
var min = false;
var currentNavBarId = null;
var onglets = [];
var maj = {};
var panelHide = true;

$(document).on('click', '.admin-btn', function (){

    $(document).scrollTop(0);
    $('#slider').nivoSlider("stop");
    if ($('.AdminPanel').length)
    {
        if (panelHide){
            panelHide = false;
            $('#corps').slideToggle(100).css({'display' : 'none', 'z-index' : '00', 'left' : '200em'});
            $('.AdminPanel').slideToggle(100).css({'display' : 'block', 'z-index' : '90', 'left' : '0'});
        }else{
            $('.AdminPanel').slideToggle(100).css({'display' : 'none', 'z-index' : '00', 'left' : '200em'});
            $('#corps').css({'display' : 'block', 'z-index' : '00', 'left' : '0em'});
            panelHide = true;
        }
    }else
    {
        var btn = $(this);
        sendAjax('ajax/getInterface', function(data){
           $('.a').append(data); 
           $('.onglet').addClass('ongletFocus');
           $('.content').addClass('focus');
           $('.toolBar').addClass('toolBarFocus accueil');
           $('#corps').slideToggle(100).css({'display' : 'none', 'z-index' : '00', 'left' : '200em'});
               $('.AdminPanel').slideToggle(100).css({'display' : 'block', 'z-index' : '90', 'left' : '0'});
           btn.animate({'top' : '0.6em'});
           click = true;
           min = true;
           panelHide = false;
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
            $('.toolBar').removeClass('toolBarFocus').css({ 'position' : 'absolute', 'display' : 'none'});
            $(this).addClass('ongletFocus');
            var attr = '.'+$(this).attr('id');
            currentNavBarId = $(this).children('input[type="hidden"]').first().val();
            hide[currentNavBarId] = true;
            $(attr).each(function(){
                if ($(this).hasClass('toolBar')){
                    $(this).addClass('toolBarFocus').css({ 'display' : 'block', 'position' : 'relative'});
                }else{
                    $(this).addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
                }
            });
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
    var last = false;
    if (countOnglet() == 1){
        focus = false;
        last = true;
    }
    if (focus){
        unsetArray(onglets, onglets[currentNavBarId]);
        var next = $(this).parent().next()
        if ($(this).parent().next().length == 0){
            var next = $(this).parent().prev();
        }
        $(this).parent().remove();
        $('.'+attr).remove();
        currentNavBarId = next.children('input[type="hidden"]').val();
        next.addClass('ongletFocus');
        attr = '.'+ next.attr('id');
        $(attr).each(function(){
            $(this).css({ 'display' : 'block', 'position' : 'relative'});
            if ($(this).hasClass('toolBar')){
                $(this).addClass('toolBarFocus');
            }else{
                $(this).addClass('focus');
            }
        });
    }else{
        unsetArray(onglets, onglets[attr]);
        hide[attr] = false;
        save['onglet'] = $('.ongletFocus').first();
        save['content'] = $('.focus').first();
        save['toolbar'] = $('.toolBarFocus').first();
        $(this).parent().remove();
        $('.' + attr).remove();
        save['onglet'].addClass('ongletFocus');
        save['content'].addClass('focus').css({ 'display' : 'block', 'position' : 'relative'});
        if (!(last)){
            save['toolbar'].addClass('toolBarFocus').css({ 'display' : 'block', 'position' : 'relative'});
        }else{
            $('.toolbar').addClass('toolBarFocus').css({ 'display' : 'block', 'position' : 'relative'});
        }
        currentNavBarId = save['onglet'].children('input[type="hidden"]').val();
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
            appendDisplay(newOnglet, data.content, data.toolbar);
            currentNavBarId = _id;
            onglets[_id] = new Onglet(_id);
            onglets[_id].setId($(newOnglet).attr('id'));
            hide[_id] = true;
            addDisplayContent(onglets[_id]);
        });
    }else
    {
        $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
        $('.ongletFocus').removeClass('ongletFocus');
        $('.toolBar').removeClass('toolBarFocus').css({'position' : 'absolute', 'display': 'none'});
        $('#' + onglets[_id].id).addClass('ongletFocus');
        $('.' + onglets[_id].id).each(function(){
            $(this).css({ 'display' : 'block', 'position' : 'relative'});
            if ($(this).hasClass('toolBar')){
                $(this).addClass('toolBarFocus');
            }else{
                $(this).addClass('focus');
            }
        });
        currentNavBarId = _id;
    }
});

/* Event sur les miniatures*/
var hide = [];
var toMajBackground = '#b82c4d';
var normalBackground = '#a5aabf';
var clickBackground = '#606fdb';
var modifPanelId = [];

$(document).on('click', '.miniature', function(){
   var _id = $(this).children('input[type="hidden"]').val();
   var modifPanelContainer = $('.' + onglets[currentNavBarId].id).children('.modifPanelContainer');
   var modifPanels = $('.' + onglets[currentNavBarId].id+' .modifPanelContainer').children('.modifPanel');
   var miniatureContainer = $('.'+onglets[currentNavBarId].id).children('.miniaturesContainer');
   var miniature = $('.'+onglets[currentNavBarId].id+ ' .miniaturesContainer').children(' .miniature');
   var test = function (_id){
       if (onglets[currentNavBarId].modified[currentNavBarId+_id] == undefined
           || !(onglets[currentNavBarId].modified[currentNavBarId+_id])){
            return false;
       }else if (onglets[currentNavBarId].modified[currentNavBarId+_id]){
            return true;
       }
   }; 
   miniature.each(function(){
       if (test($(this).children('input[type="hidden"]').val())){

           $(this).css({'background-color' : toMajBackground, 'border' : 'none'});
       }else{
           $(this).css({'background-color' : normalBackground});
       }
   });
   if (hide[currentNavBarId]){
       modifPanelContainer.show();
       modifPanels.hide();
       if (test(_id) === false){
           $(this).css({'background-color' : clickBackground});
       }else{
            $(this).css({'border': '2px solid '+clickBackground});
       }
       modifPanels.each(function(){
           if (_id == $(this).children('input[type="hidden"]').val()){
               modifPanelId[currentNavBarId] = _id;
               miniatureContainer.animate({'height' : '55%'});
               $(this).show();
               $(this).animate({'display' : 'block', 'position': 'relative'});
               hide[currentNavBarId] = false;
               miniature.animate({'width' : 'auto','height': '10em', 'font-size' :'0.8em', 'padding' : '0.5em'});
               miniature.children('.description').children('div').children('p').animate({ 'margin-left' : '0.5em'});
               miniature.children('.description').children('div').children('img').animate({'margin-top' : '0.5em'});
               if (miniature.children('.description-text').length > 0){
                    miniature.children('.description-text').children('div').children('p').animate({ 'font-size': '0.9em', 'margin-left': '0.1em'});
               }
               modifPanelContainer.resizable('enable');
           }
       });
   }else{
       var notSame = true;
       if (_id == modifPanelId[currentNavBarId]){
            miniatureContainer.animate({'height':'100%'});
            modifPanelContainer.hide();
            miniature.animate({'width' : 'auto','height' : '11em', 'font-size' :'1em', 'padding' : '1em' });
            modifPanelContainer.resizable("disable");
            miniature.children('.description').children('div').children('p').animate({ 'margin-left' : '0.9em'});
            miniature.children('.description').children('div').children('img').animate({'margin-top' : '1em'});
            if (miniature.children('.description-text').length > 0){
                 miniature.children('.description-text').children('div').children('p').animate({ 'font-size': '0.9em', 'margin-left': '0.9em'});
            }
            hide[currentNavBarId] = true;
            notSame = false;
            modifPanelId[currentNavBarId] = null;
       }
       if (notSame){
           if (test(_id) === false){
               $(this).css({'background-color' : clickBackground});
           }else{
                $(this).css({'border': '2px solid '+clickBackground});
           }
           modifPanelContainer.resizable('enable');
           modifPanels.hide();
           modifPanels.each(function(){
               if (_id == $(this).children('input[type="hidden"]').first().val()){
                   $(this).show();
                   $(this).animate({'display' : 'block', 'position': 'relative'});
                   modifPanelId[currentNavBarId] = _id;
               }
           });
           hide[currentNavBarId] = false;
       }
   }
});
/* Evenement sur input */
$(document).on('change', 'input', function(){
    var _id =  $(this).parents('.modifPanel').children('input[type="hidden"]').val();
    var c = $(this).attr('name');
    if ($(this).attr('type') == 'text'){
        onChange(onglets[currentNavBarId], _id, $(this).attr('name'), $(this).val(), c);
    }
});
//$(document).on('focus', 'input', function(){
    //var c = $(this).attr('name');
    //var _id =  $(this).parents('.modifPanel').children('input[type="hidden"]').val();
    //var desc;
    //$('.'+onglets[currentNavBarId].id).children('.miniaturesContainer').children('.miniature').each(function(){
        //if (_id == $(this).children('input[type="hidden"]').val()){
            //desc = $(this).children('.description').children('div').children();
            //if (desc.length == 0){
                //desc = $(this).children('.description-text').children('div').children();
            //}
        //}
    //});
    //if (!($(this).hasClass('datepicker*'))){
        //var toLink;
        //desc.each(function(){
            //if ($(this).hasClass(c)){
                //toLink = $(this);
            //}
        //});
        //$(this).keyup(function(event){
            //if (event.wich != '13' && event.wich != '27'){
                //toLink.text($(this).val());
            //}
        //});
    //}
//});

$(document).on('change', 'textarea', function(){
    var _id =  $(this).parents('.modifPanel').children('input[type="hidden"]').val();
    onChange(onglets[currentNavBarId], _id, $(this).attr('name'), $(this).val());
});


