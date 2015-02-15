$(document).ready(function() {

    $('#modal').dialog({
    autoOpen: false,   // 自動でオープンしない
        modal: true,   // モーダル表示する
        hide: "fade",  // 非表示時のエフェクト
        height: 700,
        width: 900
    });

});


function albumModal(self){

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
        alert('通信に失敗しました');
    }).always(function(json){
        // 成功・失敗に関わらず通信が終了した際の処理
    });

}


function picModal(album_id){
    $('#modal > #album-list').remove();
    $('#modal').append("<img src=http://img.ysklog.net/loading.gif>");
    $.ajax({
        type:"get",
        url:"/ajax/facebook/pictures/"+album_id,
        dataType:'html'
    }).done(function(html){
        $('#modal > img').remove();
        $('#modal').append(html);
    }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        alert('通信に失敗しました');
    }).always(function(json){
      // 成功・失敗に関わらず通信が終了した際の処理
    });
}

function picDecide(id,source){

    $('#modal > #picture-list').remove();
    $('#picture_id').val(id);
    $('#picture_source').val(source);

    $('#albumModal').attr('disabled', 'disabled');
    $('#albumModal').text("写真を選択済みです");
    $('#modal').dialog('close');

}
