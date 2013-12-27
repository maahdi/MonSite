
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
            'background-color': '#1fa141',
            'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #1fa141), color-stop(93%, #47dc89))',
            'background-color': '-moz-linear-gradient(top, #1fa141 0%, #47dc89 93%)',
            'background-color': '-ms-linear-gradient(top, #1fa141 0%, #47dc89 93%)',
            'background-color': 'linear-gradient(to bottom, #1fa141 0%, #47dc89 93%)',
            'cursor':'pointer'
            });
        $(this).children('ul,li').css({'color' : '#e4f30c'});
    });
    $('.sectionAdmin').mouseleave(function(){
        $(this).css({'background-color' : 'transparent'});
        $(this).children('ul,li').css({'color' : 'black'});
    });
    $('.sectionAdmin').on('click',function(){
        var fn = function(data,textStatus,jqXHR){
            $('.barAdmin').append(data);
            //récupérer l'id de ul pour envoyer ajax
            //dans ajaxcontroller on utilisera pourutiliser le bon repo
            //envoi en json et constition de la page
            //faire fonction qui fait le squelette de la page et on y insère les données dedans
            //faire animation en incluant la page pour faire un genre de déroulement vers le bas
        }
        sendAjax('ajax/barre_admin',)
    })
});
function scroll(id)
{
    $('html, body').animate({ scrollTop : $(id).offset().top}, 600);
    return false;
}

