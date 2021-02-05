@extends('templates.main', ['titulo' => "Raças", 'tag' => "RAC"])

@section('titulo') Raças @endsection

@section('conteudo')

<div class='row'>
    <div class='col-sm-6'>
        <button class="btn btn-primary btn-block" onClick="criar()">
            <b>Cadastrar Nova Raça</b>
        </button>
    </div>
    <div class='col-sm-5' style="text-align: center">
        <input type="text" list="list_racas" class="form-control" autocomplete="on" placeholder="buscar">
        <datalist id="list_racas">
        </datalist>
    </div>
    <div class='col-sm-1' style="text-align: center">
        <button type="button" class="btn btn-default btn-block">
            <img src="{{ asset('img/icons/search.svg') }}">
        </button>
    </div>
</div>
<br>
<x-tablelist :header="['Nome', 'Eventos']" :data="$racas" />
<div class="modal fade" tabindex="-1" role="dialog" id="modalRaca">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formRaca">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Nova Raça</b></h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" class="form-control">
                    <input type="hidden" id="ih_raca" class="form-control">
                    <div class="form-group">
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Nome</b></label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class='row' style="margin-top:10px">
                            <div class='col-sm-12'>
                                <label><b>Descrição</b></label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="2" required></textarea>
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
                <h5 class="modal-title"><b>Remover Raça</b></h5>
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
                <h5 class="modal-title"><b>Informações da Raça</b></h5>
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
        $('#modalRaca').modal().find('.modal-title').text("Cadastrar Raça");
        $("#nome").val('');
        $("#descricao").val('');
        $('#modalRaca').modal('show');
    }

    function editar(id) {
        $('#modalRaca').modal().find('.modal-title').text("Alterar Raça");

        $.getJSON('/api/raca/' + id, function(data) {
            $('#id').val(data.id);
            $('#nome').val(data.nome);
            $('#descricao').val(data.descricao);
            $('#modalRaca').modal('show');
        });
    }

    function remover(id, nome) {
        $('#modalRemove').modal().find('.modal-body').html("");
        $('#modalRemove').modal().find('.modal-body').append("Deseja Remover a raça '" + nome + "'?");
        $('#id_remove').val(id);
        $('#modalRemove').modal('show');
    }

    function visualizar(id) {

        $('#modalInfo').modal().find('.modal-body').html("");

        $.getJSON('/api/raca/' + id, function(data) {
            $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data.id + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data.nome + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>DESCRIÇÃO</b>: " + data.descricao);
            $('#modalInfo').modal('show');
        });
    }

    $("#formRaca").submit(function(event) {

        event.preventDefault();

        if ($("#id").val() != '') {
            update($("#id").val());
        } else {
            insert();
        }

        $("#modalRaca").modal('hide');
    });

    function insert() {
        raca = {
            nome: $("#nome").val(),
            descricao: $("#descricao").val(),
        };
        $.post("/api/raca", raca, function(data) {
            novoRaca = JSON.parse(data);
            linha = getLin(novoRaca);
            $('#tabela>tbody').append(linha);

        });
    }

    function update(id) {

        raca = {
            nome: $("#nome").val(),
            descricao: $("#descricao").val(),
        };
        $.ajax({
            type: "PUT",
            url: "/api/raca/" + id,
            context: this,
            data: raca,
            success: function(data) {
                linhas = $('#tabela>tbody>tr');
                e = linhas.filter(function(i, e) {
                    return e.cells[0].textContent == id;
                });
                if (e) {
                    e[0].cells[1].textContent = raca.nome;
                }
            },
            error: function(error) {
                alert(error.responseText);
            }
        });
    }

    function remove() {

        var id = $('#id_remove').val();

        $.ajax({
            type: "DELETE",
            url: "/api/raca/" + id,
            context: this,
            success: function() {
                linhas = $("#tabela>tbody>tr");
                e = linhas.filter(function(i, elemento) {
                    return elemento.cells[0].textContent == id;
                });
                if (e) {
                    e.remove();
                }
            },
            error: function(error) {
                alert(error.responseText);
            }
        });

        $('#modalRemove').modal('hide');
    }

    function getLin(raca) {
        var linha =
            "<tr style='text-align: center'>" +
            "<td>" + raca.nome + "</td>" +
            "<td>" +
            "<a nohref style='cursor:pointer' onClick='editar(" + raca.id + ")'><img src={{ asset('img/icons/edit.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='visualizar(" + raca.id + ")'><img src={{ asset('img/icons/info.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='visualizar(" + raca.id +raca.nome +")'><img src={{ asset('img/icons/delete.svg') }}></a>" +
            "</td>" +
            "</tr>";

        return linha;
    }

    function loadRacas() {
        $.getJSON('/api/raca/load', function(data) {
            for (i = 0; i < data.length; i++) {
                item = '<option value="' + data[i].nome + '">';
                $('#list_racas').append(item);
            }
        });
    }

    $(function() {
        loadRacas();
    })
</script>

@endsection