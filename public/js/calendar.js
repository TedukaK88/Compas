// ======================  予約キャンセルモーダル機能  ============================
$(function () {
    $('.modalOpen').each(function(){
        $(this).on('click',function(){
            var part = $(this).data('part'); //part取得
            var date = $(this).data('date'); //date取得
            document.getElementById('showDate').innerText = '予約日：' + date;
            document.getElementById('showPart').innerText = '時間：リモ' + part + '部';
            $('#cancelPart').val(part); //form valueをpartで上書き
            $('#cancelDate').val(date); //form valueをdateで上書き

            $("#modal").fadeIn();
            return false;
        });
    });
    $('.modalClose').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
    });
});
// ============================================================================