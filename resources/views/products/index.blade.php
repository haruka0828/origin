@extends('layouts.app')

@section('content')
           
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           
            <h1>{{ __('商品一覧画面') }}</h1>
                         
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('products.search') }}" method="get" class="search-form" id="product-search-form">
                      <!-- 商品名部分一致検索フォーム -->
                      <input type="text" class="form-control equal-width-form product-search" name="product_search" id="product_search" placeholder="検索キーワード">

                      <!-- メーカー選択 -->
                      <select name="company_name" class="form-control equal-width-form company-select">
                        @foreach ($companies as $id => $companyName)
                        <option value="{{ $id }}">{{ $companyName }}</option>
                        @endforeach
                      </select>
                      <!-- 検索ボタン -->
                      <button type="button" class="btn btn-primary search-button" id="search-by-company-button">検索</button>
                    </form>

                    <form action="{{ route('products.search') }}" method="get" class="search-form" id="price-stock-search-form">
                      <input type="number" name="min_price" id="min_price" placeholder="最低価格">
                      <input type="number" name="max_price" id="max_price" placeholder="最高価格">
                      <input type="number" name="min_stock" id="min_stock" placeholder="最小在庫数">
                      <input type="number" name="max_stock" id="max_stock" placeholder="最大在庫数">
                      <button type="button" class="btn btn-primary search-button" id="search-by-price-stock-button">検索</button>
                    </form>

                    <table class="table table-borderless table-striped">
                     <thead>
                      <tr>
                      <th>ID</th>
                      <th>商品画像</th>
                      <th>商品名</th>
                      <th>価格</th>
                      <th>在庫</th>
                      <th>メーカー名</th> 
                      <!-- 商品新規登録画面へのボタン -->
                      <th><a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a></th> 
                      </tr>
                     </thead>
                     <tbody>

                      @php
                           $rowIndex = 0;
                      @endphp
                    <div id="product-list">
                      @foreach ($products as $product)
                      <tr class="{{ $rowIndex % 2 === 0 ? 'even-row' : 'odd-row' }}">
                      <td>{{ $product->id }}</td>
                      <td>
                          <img src="{{ asset('storage/' . $product->img_pass) }}" alt="商品画像" class="product-image">
                      </td>
                      <td>{{ $product->product_name }}</td>
                      <td>{{ '¥' . number_format($product->price) }}</td>
                      <td>{{ $product->stock }}</td>
                      <td>{{ $product->company->company_name }}</td>
                      <td><a href="{{ route('products.show', $product->id) }}" class="btn btn-info">詳細</a></td>
                      <td>
                      <!-- 削除ボタン -->
                        <form id="delete-form-{{ $product->id }}" 
                        action="{{ route('products.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" 
                        onclick="confirmDelete({{ $product->id }})">削除</button>
                        </form>
                        </td>
                        </tr>
                      @endforeach
                    </div>
                      </tbody>
                    </table>
                    <!-- ページネーション -->
                    <div class="pagination justify-content-center">
                        {{ $products->links() }}
                    </div>
        </div>
    </div>
</div>
@endsection