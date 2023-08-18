@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center display-6">{{ __('ユーザー新規登録画面') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="名前">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="アドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3"></div>                                                 
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="パスワード">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="パスワード確認">
                            </div>
                        </div>

                     <div class="row mb-0 button">
                         <div class="col-md-8 mx-auto">
                            <button type="submit" class="btn btn-warning">
                            {{ __('新規登録') }}
                            </button>
        
                            @if (Route::has('login'))
                           <button type="button" class="btn btn-primary ml-4" onclick="location.href='{{ route('login') }}'">
                           {{ __('戻る') }}
                            </button>
                            @endif
                         </div>
                    </div>

                       <style>
                         div.button {
                         text-align: center;
                         }
                         div.button button {
                         margin: 0px 50px;
                         }
                       </style>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
