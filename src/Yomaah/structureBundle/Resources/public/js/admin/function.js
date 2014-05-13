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


function appendDisplay(_onglet, content, toolbar = null)
{
    $('.focus').removeClass('focus').css({'position' : 'absolute', 'display' : 'none'});
    $('.ongletFocus').removeClass('ongletFocus');
    $(_onglet).appendTo('.ongletBar').addClass('ongletFocus');
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
function addDisplayContent(onglet)
{
    sendJson('ajax/getInterfaceStructureObject', { 'id' : onglet.navBar }, function(data){
        var html = data.html;
        var srcUrl = data.srcUrl;
        var toChange = html.match(/%[a-zA-Z]*%/g);
        onglet.setType(data.type);
        if (data.type == 'miniatured'){
            $('<section class="miniaturesContainer"></section>').appendTo('.focus');
            $('<section class="modifPanelContainer"></section>').appendTo('.focus');
            var funct = function(article, _onglet){
                var miniature = $('.'+_onglet.id).children('.miniaturesContainer').first();
                var modifPanel = $('.'+_onglet.id).children('.modifPanelContainer').first();
                miniature.append(article[0]);
                modifPanel.append(article[2]);
                modifPanel.children('.modifPanel').hide();
                modifPanel.hide();
                var maxHeight = $('.modifPanelContainer').height()*2;
                var minHeight = $('.modifPanelContainer').height();
                modifPanel.addClass('ui-resizable-ns');
                modifPanel.resizable({handles : 'n, s', maxHeight : maxHeight, minHeight : minHeight, distance : 1});
                modifPanel.resizable('disable');
            };
            var saveStorage = function(_onglet){
                $('.modifPanelContainer').children('.modifPanel').each(function(){
                    var _id = $(this).children('input[type="hidden"]').val();
                    $('.modifPanelContainer .modifPanel .contentModifPanel .adminInput').children('input').each(function(){
                        saveOrigin(_onglet.navBar,_id, $(this).val(), $(this).attr('name'));
                        _onglet.setKeyOfSavedElement(_id);
                    });
                });
            };
        }
        sendJson("ajax/adminContent", { 'id' : onglet.navBar }, function (data){
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
        });
    });
}
function Onglet(_id)
{
    this.navBar = _id;
    this.savedElement = {};
    this.setId = function(_id){
        this.id = _id;
    };
    this.setType = function (_type){
        this.type = _type;
    };
    this.setKeyOfSavedElement = function (_id){
        if (this.savedElement[this.navBar+_id] == undefined){
            this.savedElement[this.navBar+_id] = true;
        }
    };
    /* tester après récupération des enregeristrements dans simpleStorage*/
    this.testSavedElementExists = function(_id){
        //if (this.savedElement[this.navBar+_id] != undefined){
            //return false;
        //}else{
            //return false;
        //}
        return false;
    };
    this.unsetKeyOfSavedElement = function(_id, _name){
        this.savedElement[this.id+_id+_name] = false;
    };
    this.setSavedStorageFunction = function(_function){
        //this.getStorage = _function;
    };
}

function unsetArray(tab, index)
{
    var retour = {};
    $.each(tab, function(key, value){
        if (value != index){
            retour[key] = value;
        }
    });
    return retour;
}
function saveOrigin(_navBar,_id, name, toSaved)
{
    simpleStorage.set(_navBar+_id+name, toSaved);
}

function changeBackgroundOnChange(_id)
{
    var miniatureContainer = $('.'+onglets[currentNavBarId]).children('.miniaturesContainer');
    miniatureContainer.children('.miniature').each(function(){
        if ($(this).children('input[type="hidden"]').val() == _id){
            $(this).css({'background-color' : '#b82c4d'});
        }
    });

}
