var id = null;
var article = null;
var edit = null;
var binded = false;
var test = false;


//Récupérer l'id des articles édités
$(document).on('click','.article', function(){
    id = $(this).children('input').attr('value');
    article = $(this);
});

$(document).on('hallodeactivated','.art-content', function (event, data){
    content = $(this).html();
    sendArticleAjax('art-content',content);
    edit.parent().removeClass('selected');
    startHallo(false);
    binded = true;
    if (test == false)
    {
        test = true;
    }else
    {
        test = false;
    }
    id = null;
    article = null;
    edit = null;
});

$(document).on('click','.icon-remove',function(){
    var remove = $(this);
    var tabData = { 'dialog' : 'suppressionArticle'};
    sendAjax('ajax/dialog',function(data,textStatus,jqXHR){
        var dialog = data;
        $(dialog).dialog({
            modal : true,
            buttons : {
                "Oui" : function(){
                    var t = $(this);
                    sendAjax('ajax/deleteArticle',(function(data,textStatus,jqXHR){
                        t.dialog('close');
                        var d = '<div>Suppression Réussi !!</div>';
                        article.remove();
                        article = null;
                        $(d).dialog({
                            modal : true,
                            buttons : {
                                "Close" : function(){
                                    $(this).dialog("close");
                                }
                            }
                        });
                    })(t),{'id' : id});
                },
                "Non" : function(){
                    $(this).dialog("close");
                }
            }
        });
    },tabData);
});

$(document).on('click','.icon-plus-sign',function(){
    sendAjax('ajax/dialog', function(data,textStatus,jqXHR){
        var dialog = data;
        var url = makeUrl();
        $(dialog).dialog({
            model : true,
            buttons : {
                "Début" : function(){
                    var tabData = { 'page' : url[1],'position' : 0};
                    sendAjax('ajax/newArticle',function(data,textStatus,jqXHR){
                        $('.articles').prepend(data);
                        resetToolBar();
                    },tabData);
                    $(this).dialog('close');
                },
                "Fin" : function(){
                    var tabData = { 'page' : url[1],'position' : 1};
                    sendAjax('ajax/newArticle',function(data,textStatus,jqXHR){
                        $('.articles').append(data);
                        resetToolBar();
                    },tabData);
                    $(this).dialog('close');
                }
            }
        });
    },{ 'dialog' : 'newArticle'});
});

$(document).on('click','.icon-edit',function(){
    if ($(this).parent().hasClass('selected'))
    {
        $(this).parent().removeClass('selected');
        startHallo(false);
    }else
    {
        if (binded == false)
        {
            article = $(this).parent().parent().parent().parent().parent();
            edit = $(this);
            startHallo(true);
            $(this).parent().addClass('selected');
        }else
        {
            binded = false;
        }
    }
});

$(document).on('hallodeactivated','.art-titre', function (event, data){
    content = $(this).children('h1').html();
    sendArticleAjax('art-titre',content);
    edit.parent().removeClass('selected');
    startHallo(false);
    binded = true;
    id = null;
    article = null;
    edit = null;
});

function setAdminToolbar()
{
    if (!($('.articles').hasClass('no-add')))
    {
        setToolbar($('#corps'),'addArt-bar','tb-add-art','bottom');
    }
    $('.article').each(function(){
        if (!($(this).children('.art-titre').hasClass('not-editable')))
        {
            setToolbar($(this),'art-bar','tb-art','top');
        }
    });
}

function resetToolBar(newArt)
{
    $('.articles').children('.article').each(function(){
        if ($(this).children('.art-bar').length > 0)
        {
            $(this).children('.art-bar').each(function(){
                $(this).remove();
            });
        }
        setToolbar($(this),'art-bar','tb-art','top');
    
    });
}

function setToolbar(art,classToAdd, classOfToolbar,position)
{
    art.css({'margin-bottom':'7em'});
    var div = '<div class="'+classToAdd+'"></div><div class="b" style:"diplay:none;></div>';
    art.prepend(div);
    art.children('.b').toolbar({
        content : '.'+classOfToolbar,
        position : position,
        append : '.'+classToAdd
    });
}
var baseUrl = 'http://localhost/workspace/Symfony/web/';
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
        
        var url = loc.toString().split(baseUrl);
        url[0] = baseUrl;
        return url;
    }
    //
    //URL vide après www.yomaah.fr/symfony/web
    //
    //else if (loc.toString().match('/app.php/'))
    //{
        //var url = loc.toString().split('app.php', 2);
        //url[0] = url[0] + 'app_dev.php/';
        //return url;
    //}
}

//function createNewArticle()
//{
    //var url = makeUrl();
    //$.ajax({
        //type : 'POST',
        //url : url + 'ajax/newArticle',
        //data : { },
        //success : function (data,textStatus, jqXHR)
    //{
        //$('#articles').append(data);
    //}
    //});
//}
function sendAjax(path,successFunction,data)
{
    var url = makeUrl();
    $.ajax({
        type : 'POST',
        url : url[0]+path,
        data : data,
        success : successFunction
    });
}
function sendArticleAjax(champ, content)
{
    var url = makeUrl();
    $.ajax({
        type : 'POST',
        url  : url[0] + 'ajax',
        data : {id : id, champ : champ, content : content },
        success :function(data,textStatus, jqXHR){
        }
    });
}

function startHallo(edit)
{
    article.children('.art-content').hallo({
        plugins : {
            'halloformat': {},
        'halloheadings': { formatBlocks: ["p","h2","h3"]},
        //'halloblock':{},
        'hallojustify': {},
        'hallolists': {},
        'halloreundo': {}
        },
        editable : edit,
        toolbar : 'halloToolbarFixed'
    });
    article.children('.art-titre').hallo({
        plugins : {
            'halloformat': {}
        },
        editable : edit,
        toolbar : 'halloToolbarFixed'
    });
    $('.not-editable').hallo({
        'editable' :false
    });
}

