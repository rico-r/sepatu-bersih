@extends('layout.base')

@section('title', 'Login')

@section('body-tag')
class="bg-gradient-primary"
@endsection

@section('body')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-xl-4 col-lg-6 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Buat akun</h1>
                                </div>
                                <form class="user">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="name" name="nama"
                                            placeholder="Nama">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email" name="email"
                                            placeholder="Email">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="password"
                                                id="password" placeholder="Password">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" name="repeatPassword"
                                                id="repeatPassword" placeholder="Ulangi Password">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Daftar
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection