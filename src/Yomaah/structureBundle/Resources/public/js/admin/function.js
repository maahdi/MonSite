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


function appendDisplay(_onglet, content, toolbar)
{
    $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
    $('.ongletFocus').removeClass('ongletFocus');
    $(_onglet).appendTo('.ongletBar').addClass('ongletFocus');
    $(content).children('.content').appendTo('.display').addClass('focus');;
    $('.toolBar').css({'display' : 'none', 'position' : 'absolute'});
    $('.toolBar').removeClass('toolBarFocus');
    $('.navBar').after(toolbar);
    $('.toolbar').each(function(){
        if ($(this).hasClass(_onglet.id)){
            $(this).css({'display':'block','position':'relative'}).addClass('toolBarFocus');
        }
    });
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
var loadedScript = false;
function addDisplayContent(onglet)
{
    sendJson('ajax/getInterfaceStructureObject', { 'id' : onglet.navBar }, function(data){
        var html = data.html;
        var srcUrl = data.srcUrl;
        onglet.setType(data.type);
        if (data.type == 'miniatured'){
            var toChange = html.match(/%[a-zA-Z]*%/g);
            var successFunction = function (data){
                var funct = function(article, _onglet){
                    $('.'+_onglet.id).children('.miniaturesContainer').first().append(article[0]);
                    var modifPanel = $('.'+_onglet.id).children('.modifPanelContainer').first();
                    modifPanel.append(article[2]);
                    modifPanel.hide();
                    var maxHeight = $('.modifPanelContainer').height()*2;
                    var minHeight = $('.modifPanelContainer').height();
                    modifPanel.addClass('ui-resizable-n');
                    modifPanel.resizable({handles : 'n', maxHeight : maxHeight, minHeight : minHeight, distance : 1});
                    modifPanel.resizable('disable');
                };
                var saveStorage = function(_onglet){
                    var modifPanelContainer = $('.'+_onglet.id).children('.modifPanelContainer').first();
                    modifPanelContainer.children('.modifPanel').each(function(){
                        var _id = $(this).children('input[type="hidden"]').val();
                        $(this).children('.contentModifPanel').children('.adminInput').children('input').each(function(){
                                saveOrigin(_onglet.navBar, _id, $(this).attr('name') , $(this).val());
                                if ($(this).hasClass('datepickerDebut')){
                                    $(this).datepicker({ maxDate : $('.datepickerFin').val(),
                                                        dateFormat : "dd/mm/yy"});
                                
                                }else if ($(this).hasClass('datepickerFin')){
                                    $(this).datepicker({ minDate : $('.datepickerDebut').val(),
                                                        dateFormat : "dd/mm/yy"});
                                }
                        });
                        $(this).children('.contentModifPanel').children('.adminInput').children('textarea').each(function(){
                                saveOrigin(_onglet.navBar, _id, $(this).attr('name') , $(this).val());
                        });
                    });
                };
                $.each(data, function (key,val){
                    var article = null;
                    var i = 0;
                    var onePass = false;
                    $.each(toChange, function (key, value){
                        var tmp = value.split("%");
                        if (tmp[1] == 'srcUrl' && onePass == false){
                            val[tmp[1]] = srcUrl+'/'+val[tmp[1]];
                            onePass = true;
                        }
                        if (i == 0)
                        {
                            article = html.replace(value, val[tmp[1]]);
                        }else
                        {
                            article = article.replace(value, val[tmp[1]]);
                        }
                        i++;
                    });
                    funct($(article),onglet);
                });
                saveStorage(onglet);
            };
        }else if (data.type == 'dragDrop'){
            var successFunction = function (data)
            {
                var saveStorage = function()
                {
                
                };
                var funct = function()
                {
                
                };
                $(data).children().each(function(key, value){
                    var src;
                    if ($(this).hasClass('dragDrop-min-up')){

                        src = $(this).children('img').attr('src');
                        $(this).children('img').attr('src',srcUrl +'/active/'+ src);
                        $('.'+onglet.id).children('.dragDrop').children('.dragDropActive').append(value);

                    }else if ($(this).hasClass('dragDropBar-btn')){

                        $('.'+onglet.id).children('.dragDrop').children('.dragDropBar').append(value);

                    }else{
                        src = $(this).children('img').attr('src');
                        $(this).children('img').attr('src', srcUrl +'/inactive/'+ src);
                        $('.'+onglet.id).children('.dragDrop').children('.dragDropInactive').append(value);
                    }
                });
            };
        }else if (data.type == 'online'){
            var toChange = html.match(/%[a-zA-Z]*%/g);
            var arrayToChange = html.match(/%[a-zA-Z]*\[[a-zA-Z]*\]%/g);
            console.log(arrayToChange.length);
            if (loadedScript != false)
            {
                loadedScript.remove();
                loadedScript = false;
            }
            var funct = function(script)
            {
                if (script !== false || script != undefined){
                    var s = document.createElement("script");
                    s.type = 'text/javascript';
                    s.text = script;
                    document.body.appendChild(s);
                    loadedScript = s;
                }
            };
            funct(data.script);
            var successFunction = function (data)
            {
                var saveStorage = function()
                {
                
                };
                $.each(data, function (key,val){
                    var article = null;
                    var i = 0;
                    var onePass = false;
                    $.each(toChange, function (key, value){
                        var tmp = value.split("%");
                        if (tmp[1] == 'srcUrl' && onePass == false){
                            val[tmp[1]] = srcUrl+'/'+val[tmp[1]];
                            onePass = true;
                        }
                        if (i == 0)
                        {
                            article = html.replace(value, val[tmp[1]]);
                        }else
                        {
                            article = article.replace(value, val[tmp[1]]);
                        }
                        i++;
                    });
                    $.each(arrayToChange, function (key, va){
                        var tmp = va.split('%');
                        var arrayKey;
                        /* va = %matin[debut]%*/
                        var valueKey;
                        $.each(tmp, function (key, v){
                            if (key == 1){
                                var tmpKey = v.match(/\[[a-zA-Z]*\]/g);
                                valueKey = tmpKey[0].match(/[a-zA-Z]*/g);
                                /* value[1] = "debut" */
                                var tmpValueKey = v.match(/[a-zA-Z]*\[/g);
                                $.each(tmpValueKey, function(key, value){
                                    var tmpV = v.split('[');
                                    arrayKey = tmpV[0].split(']');
                                });
                                /* arrayKey[0] = "matin";*/
                            }
                        });
                        article = article.replace(va, val[arrayKey[0]][valueKey[1]]);
                    });
                    $('.'+onglet.id).children('.onlineContainer').append(article);
                });
                $(document).trigger('onlineloaded');
            };
        }
        sendJson('ajax/adminContent', { 'id' : onglet.navBar }, successFunction);
    });
}
function Onglet(_id)
{
    this.navBar = _id;
    this.modified = new Array();
    this.setId = function(_id){
        this.id = _id;
    };
    this.setType = function (_type){
        this.type = _type;
    };
    this.unsetModifiedElement = function(_id){
        if (this.modified[this.navBar+_id] != undefined && this.modified[this.navBar+_id]){

            this.modified[this.navBar+_id] = false;
        }
    };
    /* tester après récupération des enregistrements dans simpleStorage*/
    this.majElement = function(_id, _name, _donnee){
        saveOrigin(this.navBar+_id+_name, _donnee);
        return false;
    };

    this.testModifElement = function(_id, _name, _donnee){
        var donnee = getDonnee(this.navBar+_id+_name);
        if (_donnee === donnee){
            return true;
        }else{
            return false;
        }
    };
    this.getSavedElement = function(_id, _name){
        return getDonnee(this.navBar+_id+_name);
    };
}

function revertText(elem, onglet)
{
    var _id = onglet.navBar+onglet.id+elem.attr('name');
    var donnee = onglet.getSavedElement(_id);
    elem.val(donnee);
    return false;
}

function unsetArray(tab, value)
{
    tab.splice(tab.indexOf(value), 1);
    return false;
}
function getDonnee(_id)
{
    return simpleStorage.get(_id);
}
function saveOrigin(_navBar,_id, _name, toSaved)
{
    var key = _navBar+_id+_name;
    simpleStorage.set(key, toSaved);
    return false;
}

function changeBackgroundOnChange(_id, _background)
{
    var miniatureContainer = $('.'+onglets[currentNavBarId].id).children('.miniaturesContainer');
    miniatureContainer.children('.miniature').each(function(){
        if ($(this).children('input[type="hidden"]').val() == _id){
            if (_background == 'click'){
                $(this).css({'background-color': clickBackground, 'border' : 'none'});
            
            }else if (_background == 'maj'){
                $(this).css({'background-color' : toMajBackground, 'border' : '2px solid '+clickBackground});
            }
        }
    });
    return false;

}
function onChange(_onglet, _id, _name , _value, c)
{
    if (_onglet.testModifElement(_id, _name, _value)){
        _onglet.modified[currentNavBarId+_id] = false;
        changeBackgroundOnChange(_id, 'click');
        $('.'+_onglet.id).children('.modifPanelContainer').children('.buttonsPanel').children('.reset-btn').css({'display' : 'none'});
        $('.'+_onglet.id).children('.modifPanelContainer').children('.buttonsPanel').children('.maj-btn').css({'display' : 'none'});
    }else{
        _onglet.modified[currentNavBarId+_id] = true;
        changeBackgroundOnChange(_id, 'maj');
        $('.'+_onglet.id).children('.modifPanelContainer').children('.buttonsPanel').children('.reset-btn').css({'display' : 'inline-block'});
        $('.'+_onglet.id).children('.modifPanelContainer').children('.buttonsPanel').children('.maj-btn').css({'display' : 'inline-block'});
    }
    $('.'+onglets[currentNavBarId].id).children('.miniaturesContainer').children('.miniature').each(function(){
        if (_id == $(this).children('input[type="hidden"]').val()){
            desc = $(this).children('.description').children('div').children();
            if (desc.length == 0){
                desc = $(this).children('.description-text').children('div').children();
            }
        }
    });
    var toLink;
    desc.each(function(){
        if ($(this).hasClass(c)){
            toLink = $(this);
        }
    });
    toLink.text(_value);
    return false;
}
