@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Registro do Candidato')
@section('content')
@if (Session::get('fail'))
<div class="alert alert-danger">
    {{Session::get('fail')}}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::get('success'))
<div class="alert alert-success">
    {{Session::get('success')}}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Cadastro do candidato</h4>
        <p class="mb-30"></p>
    </div>
    <div class="wizard-content">
        <form action="{{route('candidato.store')}}" id="form" method="post" class="tab-wizard wizard-circle wizard">
            @csrf

            <h5>Informações de Login</h5>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome completo :</label>
                            <input name="name" id="name" type="text" class="form-control" placeholder="Nome completo"
                                required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome de usuário :</label>
                            <input name="username" id="username" type="text" class="form-control"
                                placeholder="Nome de usuário" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email :</label>
                            <input id="email" name="email" id="email" type="email" class="form-control"
                                placeholder="nome@email.com" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password :</label>
                            <input name="password" id="password" type="password" class="form-control"
                                placeholder="**********" required />
                        </div>
                    </div>
                </div>
            </section>
            <!-- Step 2 -->
            <h5>Informações Pessoais</h5>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CPF :</label>
                            <input id="cpf" name="cpf" type="number" class="form-control"
                                placeholder="Digite somente números." required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sexo :</label>
                            <input id="sexo" name="sexo" type="text" class="form-control" maxlength="1"
                                placeholder="'M' ou 'F'" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome da Mãe :</label>
                            <input id="nome_mae" name="nome_mae" type="text" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data de Nascimento :</label>
                            <input id="data" name="dt_nascimento" type="date" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Escolaridade :</label>
                            <input id="escolaridade" name="escolaridade" type="text" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Vínculo :</label>
                            <input id="vinculo" name="vinculo" type="text" class="form-control" required />
                        </div>
                    </div>
                </div>
            </section>
            <!-- Step 3 -->
            <h5>Endereço</h5>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Endereço :</label>
                            <input id="endereco" name="endereco" type="text" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Complemento :</label>
                            <input id="complemento" name="complemento" type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Bairro :</label>
                            <input id="bairro" name="bairro" type="text" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cidade :</label>
                            <input id="cidade" name="cidade" type="text" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>UF :</label>
                            <input id="uf" name="uf" type="text" class="form-control" minlength="2" maxlength="2"
                                required />
                        </div>
                        <div class="form-group">
                            <label>CEP :</label>
                            <input id="cep" name="cep" type="text" class="form-control" maxlength="10"
                                placeholder="56.000-000" required />
                        </div>
                    </div>
                </div>
            </section>
            <!-- Step 4 -->
            <h5>Documentos Pessoais</h5>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>RG :</label>
                            <input id="rg" name="rg" type="text" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Orgão Expedidor :</label>
                            <input id="org_exp" name="org_exp" type="text" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data de Emissão :</label>
                            <input id="data" name="dt_emissao" type="date" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Telefone :</label>
                            <input id="tel" name="telefone" type="tel" class="form-control"
                                pattern="[0-9]{2}9[0-9]{4}-[0-9]{4}" required />
                        </div>

                    </div>
                </div>
            </section>
        </form>
    </div>
</div>
<!-- success Popup html Start -->
<button type="button" id="success-modal-btn" hidden data-toggle="modal" data-target="#success-modal"
    data-backdrop="static">
    Launch modal
</button>
<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered max-width-400" role="document">
        <div class="modal-content">
            <div class="modal-body text-center font-18">
                <h3 class="mb-20">Formulário enviado!</h3>
                <div class="mb-30 text-center">
                    <img src="/back/vendors/images/success.png" />
                </div>
                Cadastro realizado com sucesso!
            </div>
            <div class="modal-footer justify-content-center">
                <a href="" class="btn btn-primary">Feito</a>
            </div>
        </div>
    </div>
</div>
<!-- success Popup html End -->
@endsection
