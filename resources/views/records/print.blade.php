@extends('templates.layout')
@section('title', 'Controle de Lotes')
@section('page')
    <h5><b>CONTROLE DE LOTES</b></h5>
    <hr />
@endsection
@isset($recordsPrint)
    @section('listing')
        <div class="col s12">
            <table>
                <thead class="centered">
                    <tr>
                        <th>LOTE-PRODUTO</th>
                        <th>ENDEREÇO</th>
                        <th>#</th>
                        <th>PESO LIQUIDO</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $oldProcess = '';
                        $oldProduct = '';
                    @endphp
                    @foreach ($recordsPrint as $key => $record)
                        @if ($oldProcess != $record->process)
                            <tr>
                                <td colspan="3"><b>Sub total  processo: {{ $record->process }}</b></td>
                                <td>Total Processo</td>
                            </tr>
                            @php
                                $oldProcess = $record->process;
                            @endphp
                        @endif
                        
                        @if ($oldProcess != $record->process || $oldProduct != $record->product_code)
                            <tr>
                                <td colspan="3"><b>Sub total  Produto: {{ $record->product_code . " - " . $record->product_description }}</b></td>
                                <td>Total Produto</td>
                            </tr>
                            @php
                                $oldProduct = $record->product_code;
                            @endphp
                        @endif
                        <tr>
                            <td class="batch">{{ $record->batch }}</td>
                            <td class="address">{{ $record->address }}</td>
                            <td class="id"><span>{{ $record->id }}</span></td>
                            <td><b>{{ $record->net_weight }}</b></td>
                        </tr>
                    @endforeach

                    <h6>TOTAL GERAL: {{ $recordsPrint->count() }} Volumes</h6>
                </tbody>
            </table>
        </div>
    @endsection
@endisset

@push('scripts')
    <script></script>
@endpush
