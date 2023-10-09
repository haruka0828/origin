$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  displayProducts();
    
  function displayProducts() {
    $.ajax({
      url: '/step7/public/products',
      type: 'GET',
      dataType: 'json',
      data: {
        sort_column: 'id',
        sort_order: 'desc'
      }
    })
    .done(function(response) {
      const productsData = response.products;
      //console.log(response);
      displayProductList(productsData);
    })
    .fail(function(xhr, status, error) {
      console.error('Ajax Error:', status, error);
    });
  }
 // 商品テーブルを生成する共通の関数
 function displayProductList(response) {
  //console.log(response); // この行を追加
  const productList = document.getElementById('product-list');
  productList.innerHTML = ''; // リストを一旦クリア

  var baseUrl = 'http://localhost/step7/public/storage/';

  response.forEach(function(product) {//指導
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${product.id}</td>
      <td><img src="${baseUrl + product.img_pass}" class="product-image"></td>
      <td>${product.product_name}</td>
      <td>¥${product.price}</td>
      <td>${product.stock}個</td>
      <td>${product.company.company_name}</td>
      <td><a href="/step7/public/products/${product.id}" class="btn btn-info">詳細</a></td>
      <td>
      <!-- 削除ボタン -->
       <form id="delete-form-${product.id}" action="/step7/public/products/${product.id}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <button type="button" class="btn btn-danger" onclick="confirmDelete(${product.id})">削除</button>
       </form>
      </td>
    `;
    productList.appendChild(row);
  });
  }
  //削除機能
  window.confirmDelete = function(id) {
    if (window.confirm('本当に削除しますか？')) {
      $.ajax({
        type: 'DELETE',
        url: '/step7/public/products/' + id,
      })
      .done(function (data) {
        console.log('商品の削除成功:', data);
          $('#product-' + data.id).remove();
          displayProducts();
      })
      .fail(function () {
        console.error('商品の削除失敗:', textStatus, errorThrown);
          alert('商品の削除に失敗しました');
      });
    }
  }
});