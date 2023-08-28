@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ __('商品編集画面') }}</h1>
            <form method="POST" action="{{ route('products.update', $product->id) }}">
                @csrf
                @method('PUT')

                <!-- 商品情報ID -->
                <div class="form-inline-row row">
                    <label for="product_id">商品情報ID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="product_id" name="product_id" value="{{ $product->id }}" readonly>
                  </div>
                </div>

                <!-- 商品名 -->
                <div class="form-inline-row row">
                    <label for="product_name">商品名</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}">
                  </div>
                </div>

                <!-- メーカー（カンパニー名） -->
                <div class="form-inline-row row">
                  <label for="company_id">メーカー</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="company_id" name="company_id">
                       @foreach ($companies as $company)
                         <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                          {{ $company->company_name }}
                         </option>
                       @endforeach
                      </select>
                    </div>
                </div>


                <!-- 価格 -->
                <div class="form-inline-row row">
                    <label for="price" class="col-sm-2 col-form-label">価格</label>
                   <div class="col-sm-8">
                    <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
                   </div>
                </div>

                <!-- 在庫数 -->
                <div class="form-inline-row row">
                    <label for="stock" class="col-sm-2 col-form-label">在庫数</label>
                   <div class="col-sm-8">
                    <input type="text" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
                   </div>
                </div>

                <!-- コメント -->
                <div class="form-inline-row row">
                    <label for="comment" class="col-sm-2 col-form-label">コメント</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" id="comment" name="comment">{{ $product->comment }}</textarea>
                  </div>
                </div>

                <div class="form-inline-row row">
                      <label for="img_pass" class="col-sm-2 col-form-label">商品画像</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="img_pass" name="img_pass">
                  </div>
                </div>
            
                <!-- 更新ボタン -->
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
            </form>
        </div>
    </div>
</div>
@endsection
