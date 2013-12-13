$('.art-content').hallo({
    plugins : {
      'halloformat': {}
    },
    editable :true
});
$('.art-titre').hallo({
    plugins : {
      'halloformat': {}
    },
    editable : true
});
$('.not-editable').hallo({
    'editable' :false
});

$('.art-png').hallo({
    'editable' :false
});

$('.art-content').bind('hallodeactivated', function (event, data){
  content = $(this).html();
  sendAjax('art-content',content);

});

$('.art-titre').bind('hallodeactivated', function (event, data){
  content = $(this).html();
  sendAjax('art-titre',content);

});

function sendAjax(champ, content)
{
  id = $('#id').attr('value');
  $.ajax({
      type : 'POST',
      url  : 'ajax',
      data : {id : id, champ : champ, content : content },
      success :function(data,textStatus, jqXHR){
          $('#pays').prepend(data);
      }
  });
}
