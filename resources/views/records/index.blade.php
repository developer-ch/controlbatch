@extends('templates.layout')
@section('title', 'Controle de Lotes')
@section('page')
    <h5><b>CONTROLE DE LOTES</b></h5>
    <hr />
@endsection
@section('actions')
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab  @isset($searchExpedition) disabled @endisset col s3"><a
                        {{ $searchExpedition ?? "class='active'" }} href="#pending">PENDENTES DE EXPEDIÇÃO</a></li>
                <li class="tab col @isset($isFilter) disabled @endisset s3"><a
                        @isset($searchExpedition)class="active"@endisset href="#expedition">EXPEDIDAS</a></li>
            </ul>
        </div>
        <div id="pending" class="col s12">
            <form action="{{ route('control.batch.search') }}" method="GET">
                <div class="row">
                    <div class="input-field col s12 m5">
                        <div class="input-field col s12 m9">
                            <i class="material-icons prefix">description</i>
                            <input minlength="5" id="icon_prefix" type="text" name="process"
                                value="{{ $seachProcess ?? '' }}" required>
                            <label for="icon_prefix">PROCESSO</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select name="type_search_process">
                                <option value="=" selected>IGUAL</option>
                                <option value="like"
                                    @isset($type_search_process) {{ $type_search_process == 'like' ? 'selected' : '' }}@endisset>CONTENHA</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s12 m5">
                        <div class="input-field col s12 m9">
                            <i class="material-icons prefix">description</i>
                            <input minlength="2" id="icon_prefix" type="text" name="product_code"
                                value="{{ $seachProduct ?? '' }}">
                            <label for="icon_prefix">PRODUTO-CODE</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select name="type_search_product" required>
                                <option value="like" selected>CONTENHA</option>
                                <option value="="
                                    @isset($type_search_product) {{ $type_search_product == '=' ? 'selected' : '' }}@endisset>
                                    IGUAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s12 m2">
                        <button class="btn-floating waves-effect waves-light" type="submit">
                            <i class="material-icons left">search</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div id="expedition" class="col s12">
            <form action="{{ route('control.batch.search') }}" method="GET">
                <div class="row">
                    <div class="input-field col s12 m7">
                        <select name="search_expedition">
                            @isset($valuesExpedition)
                                @foreach ($valuesExpedition as $value)
                                    <option value="{{ $value->expedition }}"
                                        @isset($searchExpedition){{ $searchExpedition == $value->expedition ? 'selected' : '' }}@endisset>{{ $value->expedition }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="input-field col s12 m5">
                        <button class="btn-floating waves-effect waves-light" type="submit">
                            <i class="material-icons left">search</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('records.modals.create')

@include('records.modals.edit')
@isset($records)
    @section('listing')
        <form action="{{ route('control.batch.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col s12">
                    <div class="col s12 m6">
                        @if ($records->count() == 0)
                            <label><input type="checkbox" id="select-all" class="filled-in" disabled><span></span></label>
                        @else
                            @isset($searchExpedition)
                            @else
                                <label><input type="checkbox" id="select-all" class="filled-in"><span>MARCAR
                                        {{ $records->count() }}
                                        REGISTRO(S)</span></label>
                            @endisset
                        @endif
                    </div>
                    <div class="col s12 m6 right">
                        @isset($searchExpedition)
                            <button class="btn-floating right black waves-effect waves-light tooltipped Large"
                                data-tooltip='CLICK: Imprimir registro(s) selecionado(s)'
                                formaction="{{ route('control.batch.print.expedition') }}" name="_method" value="GET"
                                type="submit"><i class="material-icons left">print</i>
                            </button>
                        @else
                            <a href="#confirmeDelete" id='btn-delete-selected'
                                class="btn-floating right red tooltipped modal-trigger"
                                data-tooltip='CLICK: Excluir registro(s) selecionado(s)' data-position="bottom"
                                @isset($searchExpedition) disabled @endisset>
                                <i class="material-icons">delete</i>
                            </a>
                            <a href="#create" class="btn-floating right green tooltipped modal-trigger"
                                data-tooltip='CLICK: Cadastrar um novo registro.' data-position="bottom"
                                @isset($searchExpedition) disabled @endisset>
                                <i class="material-icons">add</i>
                            </a>
                            <button id='btn-print-selected'
                                class="btn-floating right black waves-effect waves-light tooltipped Large"
                                data-tooltip='CLICK: Imprimir registro(s) selecionado(s)'
                                formaction="{{ route('control.batch.print') }}" name="_method" value="GET" type="submit"><i
                                    class="material-icons left">print</i>
                            </button>
                        @endisset
                        @isset($isFilter)
                            @if ($isFilter)
                                <a id='btn-cler-filters' href={{ route('control.batch.index') }}
                                    class="btn right yellow tooltipped" data-tooltip='CLICK: REMOVER FILTRO(S)' data-position="top">
                                    <i class="material-icons blue-text text-darken-4">layers_clear</i> <span class="new badge"
                                        data-badge-caption="Registro(s)">{{ $records->count() }}</span></a>
                            @endif
                        @endisset
                    </div>
                </div>

                <div class="col s12" style="overflow:auto;height:40vh;overflow:auto;width:100%">
                    <table class="highlight responsive-table">
                        <thead class="centered">
                            <tr>
                                <th>#</th>
                                <th>ENDEREÇO</th>
                                <th>PRODUTO-CODIGO</th>
                                <th>PRODUTO-DESCRIÇÃO</th>
                                <th>PROCESSO</th>
                                <th>LOTE-PRODUTO</th>
                                <th>PESO LIQUIDO</th>
                                <th>EDIÇÃO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td class="id">
                                        <label>
                                            <input id="{{ $record->id }}" type="checkbox" class="filled-in"
                                                name="items_selected[]" value="{{ $record->id }}"
                                                @isset($searchExpedition) checked @else onchange="hideActions(true)" @endisset /><span>{{ $record->id }}</span>
                                        </label>
                                    </td>
                                    <td class="address">{{ $record->address }}</td>
                                    <td class="product_code"><a
                                            href="{{ route('control.batch.filters', ['process' => $record->process, 'product' => $record->product_code]) }}"><b>{{ $record->product_code }}</b></a>
                                    </td>
                                    <td class="product_description">{{ $record->product_description }}</td>
                                    <td class="process"><a
                                            href="{{ route('control.batch.filters', ['process' => $record->process]) }}"><b><b>{{ $record->process }}</b></b></a>
                                    </td>
                                    <td class="batch">{{ $record->batch }}</td>
                                    <input class="net_weight" type="hidden" value="{{ $record->net_weight }}" />
                                    <td><b>{{ $record->net_weight }}</b></td>
                                    <td>
                                        <div class="col s12">
                                            <div class="col s6 m6">
                                                <a href="#" class="open-modal-edit modal-trigger"
                                                    data-tooltip='CLICK: Alterar o registro.' data-position="bottom"
                                                    id="{{ $record->id }}">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <p>Nenhum registro, informe os filtros para pesquisar...</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" id='btn-expedition-selected'>
                <div class="col S8 m3">
                    <select name="shipping_date">
                        <option value="" disabled selected>SELECIONE A CARGA</option>
                        <option value="CARGA01">CARGA01</option>
                        <option value="CARGA02">CARGA02</option>
                        <option value="CARGA03">CARGA03</option>
                        <option value="CARGA04">CARGA04</option>
                        <option value="CARGA05">CARGA05</option>
                        <option value="CARGA06">CARGA06</option>
                        <option value="CARGA07">CARGA07</option>
                        <option value="CARGA08">CARGA08</option>
                        <option value="CARGA09">CARGA09</option>
                        <option value="CARGA10">CARGA10</option>
                    </select>
                </div>
                <div class="col s4 m3">
                    <button class="btn blue waves-effect waves-light" formaction="{{ route('control.batch.expedition') }}"
                        name="_method" value="PUT" type="submit">EXPEDIR
                        <i class="material-icons left">eject</i>
                    </button>
                </div>
                <div class="input-field col S8 m3">
                    <i class="material-icons prefix">location_searching</i>
                    <input id="input-field icon_prefix" type="text" name="address_target"
                        value="{{ old('address_target') }}">
                    <label for="icon_prefix">ENDEREÇO DESTINO</label>
                </div>
                <div class="col s4 m3">
                    <button class="input-field btn waves-effect waves-light"
                        formaction="{{ route('control.batch.movement') }}" name="_method" value="PUT"
                        type="submit">MOVIMENTAR
                        <i class="material-icons left">move_to_inbox</i>
                    </button>
                </div>
            </div>
            @include('records.modals.delete')
        </form>
    @endsection
@endisset

@push('scripts')
    <script>
        const checkbox = document.getElementById("select-all")
        let lista = document.querySelectorAll("input");
        let itensSelected = false;
        const blockElement = (el) => {
            document.getElementById(el).style.display = 'none';
            checkbox.checked = false
        }
        const unBlockElement = (el) => {
            document.getElementById(el).style.display = 'block';
        }


        const hideActions = (checkSelected = false) => {
            if (checkSelected) {
                itensSelected = false;
                lista = document.querySelectorAll("input");
                for (var i = 1; i < lista.length; i++) {
                    if (lista[i].checked) {
                        itensSelected = true;
                        i = lista.length;
                    }
                }
            }
            if (itensSelected) {
                unBlockElement('btn-expedition-selected')
                unBlockElement('btn-print-selected')
                unBlockElement('btn-delete-selected')
                return
            }
            blockElement('btn-expedition-selected')
            blockElement('btn-print-selected')
            blockElement('btn-delete-selected')
        }

        hideActions()
        checkbox.onclick = () => {
            lista = document.querySelectorAll("input");
            itensSelected = checkbox.checked;
            for (var i = 0; i < lista.length; i++) {
                lista[i].checked = checkbox.checked;
            }
            hideActions()
        };
        $('a.open-modal-edit').click((e) => {
            console.log();
            const $id = e.currentTarget.id;
            @foreach ($records as $item)
                if ({{ $item->id }} == $id) {
                    $('form#form_edit').attr('action', "{{ route('control.batch.update', $item->id) }}")
                    $('input#edit_id').val('{{ $item->id }}')
                    $('input#edit_product_code').val('{{ $item->product_code }}')
                    $('input#edit_product_description').val('{{ $item->product_description }}')
                    $('input#edit_process').val('{{ $item->process }}')
                    $('input#edit_batch').val('{{ $item->batch }}')
                    $('input#edit_net_weight').val('{{ $item->net_weight }}')
                    $('input#edit_address').val('{{ $item->address }}')
                    $('#edit').modal('open', true)
                }
            @endforeach
        })
    </script>
@endpush
