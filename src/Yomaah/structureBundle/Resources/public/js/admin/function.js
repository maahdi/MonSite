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
