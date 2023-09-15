$(document).ready(function() {
  $('#search-form').on('submit', function(e) {
    e.preventDefault(); 
    var formData = {
      //product_search: $('#search-query').val(),
      product_search: $('#product_search').val(),
      min_price: $('#min_price').val(),
      max_price: $('#max_price').val(),
      min_stock: $('#min_stock').val(),
      max_stock: $('#max_stock').val()
    };
    console.log('Ajaxリクエストデータ:', formData);
    searchProducts(formData);//追加
    });
   
    function searchProducts(formData) {//追加
    $.ajax({
      type: 'POST',
      url: '/step7/public/products/search', 
      data: formData,
      dataType: 'json',
    })
    .done(function(response) {
      // 検索結果を表示するための処理を実行
      const products = response.data;
      if (products && products.length > 0) {
        displayProductList(products);
      } else {
        console.error('No products found.');
      }
    })
    .fail(function(xhr, status, error) {
      console.error('Ajax search Error:', status, error);
    });
   }
  // 商品テーブルを生成する共通の関数
  function displayProductList(products) {
   const productList = document.getElementById('product-list');
   productList.innerHTML = ''; // リストを一旦クリア
   
   products.forEach(function(product) {//Uncaught TypeError: Cannot read properties of undefined
     const row = document.createElement('tr');
     row.innerHTML = `
       <td>${product.id}</td>
       <td><img src="${product.image_pass}" alt="${product.name}" ></td>
       <td>${product.name}</td>
       <td>¥${product.price}</td>
       <td>${product.stock}個</td>
       <td>${product.company.company_name}</td>
     `;
     productList.appendChild(row);
    });
  }
});