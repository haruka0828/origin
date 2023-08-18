@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header text-center display-6">{{ __('ユーザーログイン画面') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                        <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"autofocus placeholder="パスワード">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-6" mx-auto">
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="アドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       
                        <div class="button">
                          <div class="row mb-0">
                            <div class="col-md-8 mx-auto">
                              <button type="submit" class="btn btn-primary">
                              {{ __('ログイン') }}
                              </button>

                             @if (Route::has('register'))
                              <button type="button" class="btn btn-primary ml-4" onclick="location.href='{{ route('register') }}'">
                              {{ __('新規登録') }}
                              </button>
                             @endif
                            </div>
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
