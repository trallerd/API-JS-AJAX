@extends('templates.main', ['titulo' => "Clinicas", 'tag' => "ICA"])

@section('titulo') Clinicas @endsection

@section('conteudo')

<div class='row'>
    <div class='col-sm-6'>
        <button class="btn btn-primary btn-block" onClick="criar()">
            <b>Cadastrar Nova Clinicas</b>
        </button>
    </div>
    <div class='col-sm-5' style="text-align: center">
        <input type="text" list="list_clinicas" class="form-control" autocomplete="on" placeholder="buscar">
        <datalist id="list_clinicas">
        </datalist>
    </div>
    <div class='col-sm-1' style="text-align: center">
        <button type="button" class="btn btn-default btn-block">
            <img src="{{ asset('img/icons/search.svg') }}">
        </button>
    </div>
</div>
<br>
<x-tablelist :header="['Nome', 'Eventos']" :data="$clinicas" />
<div class="modal fade" tabindex="-1" role="dialog" id="modalClinica">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formClinica">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Nova Clinica</b></h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" class="form-control">
                    <input type="hidden" id="id_clinica" class="form-control">
                    <div class="form-group">
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Nome</b></label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Cep</b></label>
                                <input type="text" class="form-control" name="cep" id="cep" required>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Endereço</b></label>
                                <input type="text" class="form-control" name="endereco" id="endereco" required>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Telefone</b></label>
                                <input type="text" class="form-control" name="telefone" id="telefone" required>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalRemove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="id_remove" class="form-control">
            <div class="modal-header">
                <h5 class="modal-title"><b>Remover Clinica</b></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onClick="remove()"><b>Sim, remover!</b></button>
                <button type="cancel" class="btn btn-secondary" data-dismiss="modal"><b>Não, cancelar!</b></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Informações da Clinica</b></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="cancel" class="btn btn-success" data-dismiss="modal"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    function criar() {
        $('#modalClinica').modal().find('.modal-title').text("Cadastrar Clinica");
        $("#nome").val('');
        $("#cep").val('');
        $("#endereco").val('');
        $("#telefone").val('');
        $('#modalClinica').modal('show');
    }

    function editar(id) {
        $('#modalClinica').modal().find('.modal-title').text("Alterar Clinica");

        $.getJSON('/api/clinica/' + id, function(data) {
            $('#id').val(data.id);
            $('#nome').val(data.nome);
            $('#cep').val(data.cep);
            $('#endereco').val(data.endereco);
            $('#telefone').val(data.telefone);
            $('#modalClinica').modal('show');
        });
    }

    function remover(id,nome) {
            $('#modalRemove').modal().find('.modal-body').html("");
            $('#modalRemove').modal().find('.modal-body').append("Deseja Remover a Clinica '" + nome + "'?");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show');
    }

    function visualizar(id) {

        $('#modalInfo').modal().find('.modal-body').html("");

        $.getJSON('/api/clinica/' + id, function(data) {
            $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data.id + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data.nome + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>CEP:</b> " + data.cep + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>ENDEREÇO:</b> " + data.endereco + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>TELEFONE:</b> " + data.telefone + "<br><br>");
            $('#modalInfo').modal('show');
        });
    }

    $("#formClinica").submit(function(event) {

        event.preventDefault();

        if ($("#id").val() != '') {
            update($("#id").val());
        } else {
            insert();
        }

        $("#modalClinica").modal('hide');
    });

    function insert() {

        clinica = {
            nome: $("#nome").val(),
            cep: $("#cep").val(),
            endereco: $("#endereco").val(),
            telefone: $("#telefone").val(),
        };
        $.post("/api/clinica", clinica, function(data) {
            novoClinica = JSON.parse(data);
            linha = getLin(novoClinica);
            $('#tabela>tbody').append(linha);

        });
    }

    function update(id) {

        clinica = {
            nome: $("#nome").val(),
            cep: $("#cep").val(),
            endereco: $("#endereco").val(),
            telefone: $("#telefone").val(),
        };
        $.ajax({
            type: "PUT",
            url: "/api/clinica/" + id,
            context: this,
            data: clinica,
            success: function(data) {
                linhas = $("#tabela>tbody>tr");
                e = linhas.filter(function(i, e) {
                    return e.cells[0].textContent == id;
                });
                if (e) {
                    e[0].cells[1].textContent = clinica.nome;
                }
            },
            error: function(error) {
                alert(error);
            }
        });
    }

    function remove() {

        var id = $('#id_remove').val();

        $.ajax({
            type: "DELETE",
            url: "/api/clinica/" + id,
            context: this,
            success: function() {
                linhas = $('#tabela>tbody>tr');
                e = linhas.filter(function(i, elemento) {
                    return elemento.cells[0].textContent == id;
                });
                if (e) {
                    e.remove();
                }
            },
            error: function(error) {
                alert(error);
            }
        });

        $('#modalRemove').modal('hide');
    }

    function getLin(clinica) {
        var linha =
            "<tr style='text-align: center'>" +
            "<td>" + clinica.nome + "</td>" +
            "<td>" +
            "<a nohref style='cursor:pointer' onClick='editar(" + clinica.id + ")'><img src={{ asset('img/icons/edit.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='visualizar(" + clinica.id + ")'><img src={{ asset('img/icons/info.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='remover(" + clinica.id +clinica.nome + ")'><img src={{ asset('img/icons/delete.svg') }}></a>" +
            "</td>" +
            "</tr>";
        return linha;
    }

    function loadClinicas() {
        $.getJSON('/api/clinica/load', function(data) {
            for (i = 0; i < data.length; i++) {
                item = '<option value="' + data[i].nome + '">';
                $('#list_clinicas').append(item);
            }
        });
    }

    $(function() {
        loadClinicas();
    })
</script>

@endsection