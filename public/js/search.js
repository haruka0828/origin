$(document).ready(function () {
  // メーカー検索ボタンのクリックイベント
  $('#search-by-company-button').on('click', function () {
    searchProductsByCompany();
  });

  // 価格在庫範囲検索ボタンのクリックイベント
  $('#search-by-price-stock-button').on('click', function () {
    searchProductsByPriceAndStock();
  });

  function searchProductsByCompany() {
    var formData = {
      product_search: $('#product_search').val(),
      company_name: $('.company-select').val()
    };
    sendRequest(formData);
  }

  function searchProductsByPriceAndStock() {
    var formData = {
      min_price: $('#min_price').val(),
      max_price: $('#max_price').val(),
      min_stock: $('#min_stock').val(),
      max_stock: $('#max_stock').val()
    };
    sendRequest(formData);
  }

  function sendRequest(formData) {
    $.ajax({
      type: 'GET',
      url: '/step7/public/products/search',
      data: formData,
      dataType: 'json',
    })
    .done(function(response) {
      const products = response.products;
      //console.log(response);
      displayProductList(response);//指導
    })
    .fail(function (data) {
      console.error('Ajax Error:', data.responseText);
    });
  }

  // 商品テーブルを生成する共通の関数
  function displayProductList(response) {
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
});