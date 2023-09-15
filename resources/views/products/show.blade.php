@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ __('商品情報詳細画面') }}</h1>

            <div class="form-inline-row row">
                <label for="id" class="col-sm-2 col-form-label font-weight-bold">ID:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="id" name="id" value="{{ $product->id }}" readonly>
                </div>
            </div>

            <div class="form-inline-row row">
                <label for="img_pass" class="col-sm-2 col-form-label font-weight-bold">商品画像:</label>
                <div class="col-sm-8">
                    <img src="{{ asset('storage/' . $product->img_pass) }}" alt="商品画像" class="product-image">
                </div>
            </div>

            <div class="form-inline-row row">
                <label for="product_name" class="col-sm-2 col-form-label font-weight-bold">商品名:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="product_name" 
                    name="product_name" value="{{ $product->product_name }}" readonly>
                </div>
            </div>

            <div class="form-inline-row row">
                <label for="company_name" class="col-sm-2 col-form-label font-weight-bold">メーカー名:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="company_name" 
                    name="company_name" value="{{ $product->company->company_name }}" readonly>
                </div>
            </div>

            <div class="form-inline-row row">
                <label for="price" class="col-sm-2 col-form-label font-weight-bold">価格:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="price" 
                    name="price" value="{{ '¥' . number_format($product->price) }}" readonly>
                </div>
            </div>

            <div class="form-inline-row row">
                <label for="stock" class="col-sm-2 col-form-label font-weight-bold">在庫数:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stock" 
                    name="stock" value="{{ $product->stock }}" readonly>
                </div>
            </div>

            <div class="form-inline-row row">
                <label for="comment" class="col-sm-2 col-form-label font-weight-bold">コメント:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="comment" 
                    name="comment" value="{{ $product->comment }}" readonly>
                </div>
            </div>
            
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
            <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
        </div>
    </div>
</div>
@endsection
