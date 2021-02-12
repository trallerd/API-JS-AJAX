<div class="table-responsive" style="overflow-x: visible; overflow-y: visible;">
    <table class='table table-striped' id="tabela">
        <thead>
            <tr style="text-align: center">
                @foreach ($header as $item)
                <th>{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody >
            @foreach ($data as $item)
            <tr style="text-align: center" >
                <td style="display:none;">{{ $item->id }}</td>
                <td>{{ $item->nome }}</td>
                <td>
                    <a nohref style="cursor:pointer" onClick="editar('{{$item->id}}')"><img src="{{ asset('img/icons/edit.svg') }}"></a>
                    <a nohref style="cursor:pointer" onClick="visualizar('{{$item->id}}')"><img src="{{ asset('img/icons/info.svg') }}"></a>
                    <a nohref style="cursor:pointer" onClick="remover('{{$item->id}}','{{$item->nome}}')"><img src="{{ asset('img/icons/delete.svg') }}"></a>
                </td>
            </tr>
            </form>
            @endforeach
        </tbody>
    </table>
</div>