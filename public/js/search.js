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
      company_name: $('#company_name').val()
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
      //const products = response.products.products;
      //const products = response.products.data;
      //const products = response.data;
      console.log(products)
      displayProductList(products);
    })
    .fail(function (data) {
      console.error('Ajax Error:', data.responseText);
    });
  }

  // 商品テーブルを生成する共通の関数
  function displayProductList(products) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = ''; // リストを一旦クリア

    products.forEach(function(product) {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${product.id}</td>
        <td><img src="${product.image_pass}" alt="${product.name}" ></td>
        <td>${product.product_name}</td>
        <td>¥${product.price}</td>
        <td>${product.stock}個</td>
        <td>${product.company_id}</td>
      `;
      productList.appendChild(row);
    });
   }
});