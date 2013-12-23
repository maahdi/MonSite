
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
});
function scroll(id)
{
    $('html, body').animate({ scrollTop : $(id).offset().top}, 600);
    return false;
}
