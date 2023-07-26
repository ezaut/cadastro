@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Registrar Candidato')
@section('content')
    <form action="{{ route('candidato.store') }}" method="post">
        @csrf
        <div class="pd-20 card-box mb-30">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nome</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" type="text" placeholder="Seu nome completo" name="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nome de Usuário</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" type="text" placeholder="Seu nome completo" name="username">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" placeholder="nome@email.com" type="email" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Senha</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" value="Sua senha" type="password" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Confirme a senha</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" value="Sua senha" type="password" name="password_confirm">
                    </div>
                </div>

        </div>
        <div class="actions clearfix" style="padding: 10px">
            <ul role="menu" aria-label="Pagination">
                <button class="btn btn-primary" type="submit">
                    Cadastrar
                </button>
                <button type="button" type="reset" class="btn btn-danger">
                    Cancelar
                </button>
            </ul>
        </div>
    </form>
@endsection
