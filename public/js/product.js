$(document).ready(function() {
  // 商品一覧を初期表示
  displayProducts();

  function displayProducts() {
    $.ajax({
      url: '/step7/public/products',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(response) {
      // 商品一覧を表示するための処理を実行
      const products = response.data;
      displayProductList(products);
    })
    .fail(function(xhr, status, error) {
      // エラーハンドリングを行う
      console.error('Ajax Error:', status, error);
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