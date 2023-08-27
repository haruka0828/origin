function confirmDelete(productId) {
    if (confirm('本当に削除しますか？')) {
        document.getElementById('delete-form-' + productId).submit();
    }
}
