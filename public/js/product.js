$(document).ready(function() {
      $.ajax({
        url: '/products',
        type: 'GET',
        cache: false,
        dataType: 'json',
      })
      .done(function(response) {
        // 商品一覧を表示するための処理を実行
        displayProducts(response.products);
      })
      .fail(function(xhr, status, error) {
        // エラーハンドリングを行う
        console.error('Ajax Error:', status, error);
      })
      .always(function(response) {
        // 通信の成否にかかわらず実行する処理
      });
    
     // 商品一覧を表示する関数
     function displayProducts(products) {
     // 商品一覧を表示するための要素を取得
     const productList = document.getElementById('product-list');

     // 商品一覧をクリア（一旦空にする）
     productList.innerHTML = '';

     // 受け取った商品データをループで処理
     products.forEach(function(product) {
      // 商品情報を表示するHTML要素を生成
      const productElement = document.createElement('div');
      productElement.className = 'product'; // 商品のクラス名などを設定

      // プロダクトIDを表示
      const productId = document.createElement('p');
      productId.textContent = 'ID: ' + product.id; // プロダクトIDを設定
      productElement.appendChild(productId);

      // 商品画像を表示
      const productImage = document.createElement('img');
      productImage.src = product.image_url; // 商品画像のURLを設定
      productElement.appendChild(productImage);

      // 商品名を表示
      const productName = document.createElement('h2');
      productName.textContent = product.name; // 商品名を設定
      productElement.appendChild(productName);

      // 価格を表示
      const productPrice = document.createElement('p');
      productPrice.textContent = '価格: ¥' + product.price; // 価格を設定
      productElement.appendChild(productPrice);

      // 在庫を表示
      const productStock = document.createElement('p');
      productStock.textContent = '在庫: ' + product.stock + '個'; // 在庫数を設定
      productElement.appendChild(productStock);

      // メーカー名を表示
      const productCompanyName = document.createElement('p');
      productCompanyName.textContent = 'メーカー名: ' + product.company.company_name; // メーカー名を設定
      productElement.appendChild(productCompanyName);

      // 商品情報を商品一覧に追加
      productList.appendChild(productElement);
    });
  }
});