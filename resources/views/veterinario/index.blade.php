@extends('templates.main', ['titulo' => "Veterinarios", 'tag' => "VET"])

@section('titulo') Veterinarios @endsection

@section('conteudo')

<div class='row'>
    <div class='col-sm-6'>
        <button class="btn btn-primary btn-block" onClick="criar()">
            <b>Cadastrar Novo Veterinarios</b>
        </button>
    </div>
    <div class='col-sm-5' style="text-align: center">
        <input type="text" list="list_vet" class="form-control" autocomplete="on" placeholder="buscar">
        <datalist id="list_vet">
        </datalist>
    </div>
    <div class='col-sm-1' style="text-align: center">
        <button type="button" class="btn btn-default btn-block">
            <img src="{{ asset('img/icons/search.svg') }}">
        </button>
    </div>
</div>
<br>
<x-tablelist :header="['Nome', 'Eventos']" :data="$veterinarios" />
<div class="modal fade" tabindex="-1" role="dialog" id="modalVet">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formVet">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Novo Veterinario</b></h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" class="form-control">
                    <input type="hidden" id="id_pet" class="form-control">
                    <div class="form-group">
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Nome</b></label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <label><b>Crmv</b></label>
                                <input type="text" class="form-control" name="crmv" id="crmv" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-sm-12'>
                                <label> <b> Especialidade </b></label>
                                <select name='especialidade_id' id="especialidade_id" class="form-control" required>
                                    <option selected> </option>
                                    @foreach($especialidades as $item)
                                    <option> {{$item->nome}} </option>
                                    @endforeach
                                </select>
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
                <h5 class="modal-title"><b>Remover Veterinario</b></h5>
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
                <h5 class="modal-title"><b>Informações do Veterinario</b></h5>
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
        $('#modalVet').modal().find('.modal-title').text("Cadastrar Veterinario");
        $("#nome").val('');
        $("#crmv").val('');
        $("#especialidade_id").val('');
        $('#modalVet').modal('show');
    }

    function editar(id) {
        $('#modalVet').modal().find('.modal-title').text("Alterar Veterinario");
        $.getJSON('/api/veterinario/' + id, function(data) {
            $('#id').val(data[0].id);
            $('#nome').val(data[0].nome);
            $('#crmv').val(data[0].crmv);
            $('#especialidade_id').val(data[1].nome);

            $('#modalVet').modal('show');
        });
    }

    function remover(id, nome) {
        $('#modalRemove').modal().find('.modal-body').html("");
        $('#modalRemove').modal().find('.modal-body').append("Deseja Remover o Veterinario '" + nome + "'?");
        $('#id_remove').val(id);
        $('#modalRemove').modal('show');
    }

    function visualizar(id) {

        $('#modalInfo').modal().find('.modal-body').html("");

        $.getJSON('/api/veterinario/' + id, function(data) {
            $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data[0].id + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data[0].nome + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>CRMV:</b> " + data[0].crmv + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>ESPECIALIDADE:</b> " + data[1].nome + "<br><br>");
            $('#modalInfo').modal('show');
        });
    }

    $("#formVet").submit(function(event) {

        event.preventDefault();

        if ($("#id").val() != '') {
            update($("#id").val());
        } else {
            insert();
        }

        $("#modalVet").modal('hide');
    });

    function insert() {

        veterinario = {
            nome: $("#nome").val(),
            crmv: $("#crmv").val(),
            especialidade_id: $("#especialidade_id").val(),
        };
        $.post("/api/veterinario", veterinario, function(data) {
            novoVeterinario = JSON.parse(data);
            linha = getLin(novoVeterinario);
            $('#tabela>tbody').append(linha);

        });
    }

    function update(id) {

        veterinario = {
            nome: $("#nome").val(),
            crmv: $("#crmv").val(),
            especialidade_id: $("#especialidade_id").val(),
        };
        $.ajax({
            type: "PUT",
            url: "/api/veterinario/" + id,
            context: this,
            data: veterinario,
            success: function(data) {
                linhas = $("#tabela>tbody>tr");
                e = linhas.filter(function(i, e) {
                    return e.cells[0].textContent == id;
                });
                if (e) {
                    e[0].cells[1].textContent = veterinario.nome;
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
            url: "/api/veterinario/" + id,
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
                alert(error);
            }
        });

        $('#modalRemove').modal('hide');
    }

    function getLin(veterinario) {
        var linha =
            "<tr style='text-align: center'>" +
            "<td>" + veterinario.nome + "</td>" +
            "<td>" +
            "<a nohref style='cursor:pointer' onClick='editar(" + veterinario.id + ")'><img src={{ asset('img/icons/edit.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='visualizar(" + veterinario.id + ")'><img src={{ asset('img/icons/info.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='remover(" + veterinario.id + ", "+ veterinario.nome+")'><img src={{ asset('img/icons/delete.svg') }}></a>" +
            "</td>" +
            "</tr>";

        return linha;
    }

    function loadVeterinario() {
        $.getJSON('/api/veterinario/load', function(data) {
            for (i = 0; i < data.length; i++) {
                item = '<option value="' + data[i].nome + '">';
                $('#list_vet').append(item);
            }
        });
    }

    $(function() {
        loadVeterinario();
    })
</script>

@endsection