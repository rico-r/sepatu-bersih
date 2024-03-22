@extends('layout.base')

@section('title', 'Login')

@section('body-tag')
class="bg-gradient-primary"
@endsection

@section('body')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-7 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <form class="user" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                            id="username" name="username"
                                            value="{{ old('username') }}"
                                            placeholder="Masukkan username..." required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password"
                                            id="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe" name="rememberMe" {{ old('rememberMe') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="rememberMe">Ingat Saya</label>
                                        </div>
                                    </div>
                                    @include('layout.error-container', ['field' => 'auth'])
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button >
                                </form>
                                <hr>
                                @if (Route::has('register'))
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Buat akun</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection