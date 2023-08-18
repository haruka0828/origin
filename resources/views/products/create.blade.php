@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('成功だよ！') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('商品新規登録') }}
                    <!-- 商品一覧登録画面へのボタン -->
                    <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
