@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ __('商品情報詳細画面') }}</h1>
            <table class="table table-borderless">
                <tr>
                    <th>ID</th>
                    <td>{{ $product->id }}</td>
                </tr>
                <tr>
                    <th>商品画像</th>
                    <td>
                        <img src="{{ asset('storage/' . $product->img_pass) }}" alt="商品画像" style="max-width: 300px;">
                    </td>
                </tr>
                <tr>
                    <th>商品名</th>
                    <td>{{ $product->product_name }}</td>
                </tr>
                <tr>
                    <th>価格</th>
                    <td>{{ '¥' . number_format($product->price) }}</td>
                </tr>
                <tr>
                    <th>在庫</th>
                    <td>{{ $product->stock }}</td>
                </tr>
                <tr>
                    <th>メーカー名</th>
                    <td>{{ $product->company->company_name }}</td>
                </tr>
                <tr>
                    <th>コメント</th>
                    <td>{{ $product->comment }}</td>
                </tr>
            </table>
                


            <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>

        </div>
    </div>
</div>
@endsection
