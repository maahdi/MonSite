function makeUrl()
{
    var loc = window.location;
    if (loc.toString().match('/app_dev.php/'))
    {
        var url = loc.toString().split('app_dev.php', 2);
        url[0] = url[0] + 'app_dev.php/';
        return url;
    }else
    {
        if (loc.toString().match('/literie/'))
        {
            var cut = '/literie/';
        }else if (loc.toString().match('/test/'))
        {
            var cut = '/test/';
        }else if (loc.toString().match('/web/'))
        {
            var cut = '/web/';
        }else
        {
            var cut = false;
        }
        if (cut == false)
        {
            var url = loc.toString().split('/');
            url[0] = url[0] +'//'+ url[2] + '/';
            url[1] = url[3];
        }else if ((cut == '/web/') || (cut == '/literie/'))
        {
            var url = loc.toString().split(cut);
            url[0] = url[0] + '/';
        }else
        {
            var url = loc.toString().split(cut);
            url[0] = url[0] + '/';
        }
        return url;
    }
}

function sendAjax(path,successFunction,data = null)
{
    var url = makeUrl();
    $.ajax({
        type : 'POST',
        url : url[0]+path,
        data : data,
        success : successFunction
    });
}
function sendJson(path, data, successFunction)
{
    var url = makeUrl();
    $.getJSON(url[0]+path, data, successFunction);
}


function appendDisplay(onglet, content, toolbar = null)
{
    $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
    $('.ongletFocus').removeClass('ongletFocus');
    $(onglet).appendTo('.ongletBar').addClass('ongletFocus');
    $(content).appendTo('.display').addClass('focus');
}

/* test en théorie la valeur de l'input de l'onglet avec la valeur id 
 * qui sert a envoyer au serveur
 * */
function testExistsInDom(_id, elem, parentClass)
{
    var retour = false;
    $(parentClass).children(elem).each(function(){
        if ($(this).val() == _id){
            retour = true;
        }
    });
    return retour;
}

function countOnglet()
{
    return $('.onglet').length;
}
