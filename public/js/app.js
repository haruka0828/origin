 // 商品削除の確認ダイアログ表示とフォーム送信
    function confirmDelete(productId) {
        if (confirm('本当に削除しますか？')) {
            document.getElementById('delete-form-' + productId).submit();
        }
    }