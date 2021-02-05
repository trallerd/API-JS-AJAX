@extends('templates.main', ['titulo' => "Pets", 'tag' => "PET"])

@section('titulo') Pets @endsection

@section('conteudo')

<div class='row'>
    <div class='col-sm-6'>
        <button class="btn btn-primary btn-block" onClick="criar()">
            <b>Cadastrar Novo Pet</b>
        </button>
    </div>
    <div class='col-sm-5' style="text-align: center">
        <input type="text" list="list_pets" class="form-control" autocomplete="on" placeholder="buscar">
        <datalist id="list_pets">
        </datalist>
    </div>
    <div class='col-sm-1' style="text-align: center">
        <button type="button" class="btn btn-default btn-block">
            <img src="{{ asset('img/icons/search.svg') }}">
        </button>
    </div>
</div>
<br>
<x-tablelist :header="['Nome', 'Eventos']" :data="$pets" />
<div class="modal fade" tabindex="-1" role="dialog" id="modalPets">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formPets">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Novo Pet</b></h5>
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
                                <label><b>Data Nascimento</b></label>
                                <input type="text" class="form-control" name="nascimento" id="nascimento" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-sm-12'>
                                <label> <b> Raça </b></label>
                                <select name='raca_id' id="raca_id" class="form-control" required>
                                    <option selected> </option>
                                    @foreach($racas as $item)
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
                <h5 class="modal-title"><b>Remover Pet</b></h5>
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
                <h5 class="modal-title"><b>Informações do Pet</b></h5>
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
        },
    );

    function criar() {
        $('#modalPets').modal().find('.modal-title').text("Cadastrar Pet");
        $("#nome").val('');
        $("#nascimetno").val('');
        $("#raca_id").val('');
        $('#modalPets').modal('show');
    }

    function editar(id) {
        $('#modalPets').modal().find('.modal-title').text("Alterar Pet");

        $.getJSON('/api/pet/' + id, function(data) {
            $('#id').val(data[0].id);
            $('#nome').val(data[0].nome);
            $('#nascimento').val(data[0].nascimento);
            $('#raca_id').val(data[1].nome);
            $('#modalPets').modal('show');
        });
    }

    function remover(id, nome) {
        $('#modalRemove').modal().find('.modal-body').html("");
        $('#modalRemove').modal().find('.modal-body').append("Deseja Remover o Pet '" + nome + "'?");
        $('#id_remove').val(id);
        $('#modalRemove').modal('show');
    }

    function visualizar(id) {

        $('#modalInfo').modal().find('.modal-body').html("");

        $.getJSON('/api/pet/' + id, function(data) {
            $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data[0].id + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data[0].nome + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>DATA NASCIMENTO:</b> " + data[0].nascimento + "<br><br>");
            $('#modalInfo').modal().find('.modal-body').append("<b>RAÇA:</b> " + data[1].nome + "<br><br>");
            $('#modalInfo').modal('show');
        });
    }

    $("#formPets").submit(function(event) {

        event.preventDefault();

        if ($("#id").val() != '') {
            update($("#id").val());
        } else {
            insert();
        }

        $("#modalPets").modal('hide');
    });

    function insert() {

        pet = {
            nome: $("#nome").val(),
            nascimento: $("#nascimento").val(),
            raca_id: $("#raca_id").val(),
        };
        $.post("/api/pet", pet, function(data) {
            novoPet = JSON.parse(data);
            linha = getLin(novoPet);
            $('#tabela>tbody').append(linha);

        });
    }

    function update(id) {

        pet = {
            nome: $("#nome").val(),
            nascimento: $("#nascimento").val(),
            raca_id: $("#raca_id").val(),
        };
        $.ajax({
            type: "PUT",
            url: "/api/pet/" + id,
            context: this,
            data: pet,
            success: function(data) {
                linhas = $("#tabela>tbody>tr");
                e = linhas.filter(function(i, e) {
                    return e.cells[0].textContent == id;
                });
                if (e) {
                    e[0].cells[1].textContent = pet.nome;
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
            url: "/api/pet/" + id,
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

    function getLin(pet) {
        var linha =
            "<tr style='text-align: center'>" +
            "<td>" + pet.nome + "</td>" +
            "<td>" +
            "<a nohref style='cursor:pointer' onClick='editar(" + pet.id + ")'><img src={{ asset('img/icons/edit.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='visualizar(" + pet.id + ")'><img src={{ asset('img/icons/info.svg') }}></a>" +
            "<a nohref style='cursor:pointer' onClick='remover(" + pet.id +pet.nome + ")'><img src={{ asset('img/icons/delete.svg') }}></a>" +
            "</td>" +
            "</tr>";

        return linha;
    }

    function loadpets() {
        $.getJSON('/api/pet/load', function(data) {
            for (i = 0; i < data.length; i++) {
                item = '<option value="' + data[i].nome + '">';
                $('#list_pets').append(item);
            }
        });
    }

    $(function() {
        loadpets();
    })
</script>

@endsection