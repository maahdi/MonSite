
$(window).ready(function(){
    $('#slider').nivoSlider(
    {
        effect: 'sliceUp',
        animSpeed:650,
        pauseTime:6000,
        directionNavHide: false,
        captionOpacity: 1,
        prevText:'<',
        nextText:'>'
    });
    $('.sectionAdmin').mouseover(function(){
        $(this).css(
            {'-webkit-border-radius': '3px 3px 3px 3px',
            '-moz-border-radius': '3px 3px 3px 3px',   
            'border-radius':'3px 3px 3px 3px',
            'background-color': '#777',
            'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #777), color-stop(93%, #b3b3b3))',
            'background-color': '-moz-linear-gradient(top, #777 0%, #b3b3b3 93%)',
            'background-color': '-ms-linear-gradient(top, #777 0%, #b3b3b3 93%)',
            'background-color': 'linear-gradient(to bottom, #777 0%, #b3b3b3 93%)',
            'cursor':'pointer'
            });
    });

    $('.sectionAdmin').mouseleave(function(){
        $(this).css({'background-color' : '#f1ecec'});
    });

    $(window).scroll(function () {
        posScroll = $(document).scrollTop();
        if(posScroll >= 350)
            $('#back-top').fadeIn(600);
        else
            $('#back-top').fadeOut(400);
    }); 

    $('#back-top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('.sectionAdmin').on('click',function(){
        if ($('.barAdmin').children('.admin-content').length > 0 && lien != $(this).attr('id'))
        {
            lien = $(this).attr('id');
            if (close)
            {
                $('.admin-content').remove();
                $('.tool-container').css({'z-index' : '1'});
                $(d).hide().appendTo('.barAdmin');
                getAdminInterface();
                getAdminContent(lien);
                $(d).slideToggle('slow');
            }else
            {
                $('.admin-content').slideToggle('slow').queue(function(){
                    $('.admin-content').remove();
                    $('.tool-container').css({'z-index' : '1'});
                    $(d).hide().appendTo('.barAdmin').slideToggle('slow').queue(function(){
                        getAdminInterface();
                        getAdminContent(lien);
                        $(this).dequeue();
                    });
                    $(this).dequeue();
                });
            }
        }else if ($('.barAdmin').children('.admin-content').length > 0 && lien == $(this).attr('id'))
        {
            $('.admin-content').slideToggle('slow');
            if (close)
            {
                close = false;
            }else
            {
                close = true;
            }
        }else
        {
            close = false;
            lien = $(this).attr('id');
            $('.tool-container').css({'z-index' : '1'});
            $(d).hide().appendTo('.barAdmin').slideToggle('slow').queue(function(){
                getAdminInterface();
                getAdminContent(lien);
                $(this).dequeue();
            });
        }
    });
});

/*
 * Variable pour affichage des pages admin
 */
var close = true;
var lien = null;
var d = '<div class="admin-content small-12 columns tool-container gradient"></div>';
var struct = new Array();
var contentStructure = null;

function getAdminInterface()
{
    sendAjax('ajax/adminInterface', function(data)
    {
        $('.admin-content').append(data);
    },{'lien' : lien });
}

function getAdminContent(lien)
{
    var url = makeUrl();
    var donnee = {'lien' : lien};
    sendAjax('ajax/adminContentStructure', function (data){
        contentStructure = data;
        struct = contentStructure.match(/%[a-zA-Z]*%/g);
        $.getJSON(url[0]+"ajax/adminContent",donnee,function (data){
            $.each(data, function (key,val){
                var article = null;
                var i = 0;
                $.each(struct,function (key,value){
                    var tmp = value.split("%");
                    if (i == 0)
                    {
                        article = contentStructure.replace(value,val[tmp[1]]);
                    }else
                    {
                        article = article.replace(value,val[tmp[1]]);
                    }
                i++;
                });
                $('.contentI').append(article);
            });
            contentStructure = null;
        });
    },{ 'lien' : lien});
    /*
     * Url pour choisir sur mon site automatiquement vers quel bundle il faut rediriger
     */
}

function scroll(id)
{
    $('html, body').animate({ scrollTop : $(id).offset().top}, 800);
    return false;
}

$(document).on('mouseover','.btn-menuI',function(){
    $(this).css(
        {'-webkit-border-radius': '3px 3px 3px 3px',
        '-moz-border-radius': '3px 3px 3px 3px',   
        'border-radius':'3px 3px 3px 3px',
        'background-color': '#777',
        'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #777), color-stop(93%, #b3b3b3))',
        'background-color': '-moz-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': '-ms-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': 'linear-gradient(to bottom, #777 0%, #b3b3b3 93%)',
        'cursor':'pointer'
        });
});
$(document).on('mouseleave','.btn-menuI',function(){
    $(this).css({'background-color' : '#f1ecec'});
});
