$(function() {
    // 検索とソートを保持
    var params = {
      product_search: '',
      company_neme: '',
      sort_column: 'id',
      sort_order: 'asc',
      min_price: '',
      max_price: '',
      min_stock: '',
      max_stock: ''
    };
  
    // 商品一覧を更新する関数
    var updateProductList = function() {
    //console.log(params); //出力
    $.get('/step7/public/products', params, function(data) {
      displayProductList(data.products);
    });
    };
    // 商品テーブルを生成する共通の関数
    function displayProductList(response) {
    //console.log(response);
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
    // 検索ボタンがクリックされたときの処理
    $('#search-by-company-button').on('click', function() {
      params.product_search = $('#product_search').val();
      params.company_name = $('select[name="company_name"]').val();
      //console.log(params); //出力
    });
    //価格在庫範囲検索ボタンがクリックされたときの処理
    $('#search-by-price-stock-button').on('click', function() {
        params.min_price = $('#min_price').val();
        params.max_price = $('#max_price').val();
        params.min_stock = $('#min_stock').val();
        params.max_stock = $('#max_stock').val();
        //console.log(params); //出力
      });
    // ソートボタンがクリックされたときの処理
    $('#sort-button').on('click', function(event) {
        event.preventDefault(); //フォームの送信を防ぐ
        params.sort_column = $('select[name="sort_column"]').val(); //カラムを取得
        if (params.sort_column === 'company_name') {
            params.sort_column = 'company_id';
        }
        params.sort_order = (params.sort_order === 'asc') ? 'desc' : 'asc';
      updateProductList();
    });
  });