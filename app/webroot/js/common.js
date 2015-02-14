$(document).ready(function() {

    $("#albumModal").click(function(){

        $('#modal').dialog('open');

        $.ajax({
            type:"get",
            url:"/ajax/facebook/albums",
            dataType:'html',
        }).done(function(html){
          $('#modal').append(html);
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
          //alert(textStatus);
          //alert(errorThrown);
          //alert(XMLHttpRequest);
        }).always(function(json){
          // 成功・失敗に関わらず通信が終了した際の処理
        });

    });

    $('#modal').dialog({
    autoOpen: false,  // 自動でオープンしない
        modal: true,      // モーダル表示する
        resizable: false, // リサイズしない
        draggable: false, // ドラッグしない
        show: "clip",     // 表示時のエフェクト
        hide: "fade"      // 非表示時のエフェクト
    });


});

function picModal(album_id){
    $('#modal > #album-list').remove();
    $.ajax({
        type:"get",
        url:"/ajax/facebook/pictures",
        dataType:'html',
        data = {
            album_id : album_id
        }
    }).done(function(html){
        $('#modal').append(html);
    }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        alert(textStatus);
    }).always(function(json){
      // 成功・失敗に関わらず通信が終了した際の処理
    });
}
