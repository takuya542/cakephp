$(document).ready(function() {

    $('#modal').dialog({
    autoOpen: false,   // 自動でオープンしない
        modal: true,   // モーダル表示する
        hide: "fade",  // 非表示時のエフェクト
        height: 600,
        width: 900
    });

});


function albumModal(){

    $('#modal > #album-list').remove();
    $('#modal > #picture-list').remove();
    $('#modal').dialog('open');

    $.ajax({
        type:"get",
        url:"/ajax/facebook/albums",
        dataType:'html'
    }).done(function(html){
        $('#modal').append(html);
    }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        //alert(textStatus);
        //alert(errorThrown);
        //alert(XMLHttpRequest);
    }).always(function(json){
        // 成功・失敗に関わらず通信が終了した際の処理
    });

}


function picModal(album_id){
    $('#modal > #album-list').remove();
    $.ajax({
        type:"get",
        url:"/ajax/facebook/pictures/"+album_id,
        dataType:'html'
    }).done(function(html){
        $('#modal').append(html);
    }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        alert(textStatus);
    }).always(function(json){
      // 成功・失敗に関わらず通信が終了した際の処理
    });
}

function picDecide(id,source){
    $('#modal > #picture-list').remove();
    $('#picture_id').val(id);
    $('#picture_source').val(source);
    $('#modal').dialog('close');
}
