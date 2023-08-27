@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ __('商品新規登録画面') }}</h1>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-inline-row row">
                      <label for="product_name" class="col-sm-2 col-form-label">商品名</label>
                   <div class="col-sm-8">
                      <input type="text" class="form-control" id="product_name" name="product_name" required>
                   </div>
                </div>

                <div class="form-inline-row row">
                      <label for="company_name" class="col-sm-2 col-form-label">メーカー名</label>
                   <div class="col-sm-8">
                        <select name="company_name" class="form-control">
                           @foreach ($companies as $id => $companyName)
                           <option value="{{ $id }}">{{ $companyName }}</option>
                           @endforeach
                        </select>
                   </div>
                </div>

                <div class="form-inline-row row">
                      <label for="price" class="col-sm-2 col-form-label">価格</label>
                   <div class="col-sm-4">
                      <input type="number" class="form-control" id="price" name="price" required>
                   </div>
                </div>

                <div class="form-inline-row row">
                      <label for="stock" class="col-sm-2 col-form-label">在庫数</label>
                   <div class="col-sm-4">
                      <input type="number" class="form-control" id="stock" name="stock" required>
                   </div>
                </div>

                <div class="form-inline-row row">
                      <label for="comment" class="col-sm-2 col-form-label">コメント</label>
                  <div class="col-sm-8">
                     <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                  </div>
                </div>

                <div class="form-inline-row row">
                      <label for="img_pass" class="col-sm-2 col-form-label">商品画像</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="img_pass" name="img_pass">
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">新規登録</button>
            </form>

            <!-- 商品一覧画面へのボタン -->
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">戻る</a>
        </div>
    </div>
</div>
@endsection
