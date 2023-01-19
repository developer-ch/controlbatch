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
                <thead>
                    <tr>
                        <th>PROCESSO</th>
                        <th>PRODUTO</th>
                        @if ($showForSeparation)
                            <th>#</th>
                            <th>ENDEREÇO</th>
                        @endif
                        <th>LOTE_PRODUTO</th>
                        <th>PESO_LIQ(KG)</th>
                        <th>VOLUMES</th>
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
                                <td colspan="{{$showForSeparation?5:3}}"><b><b>{{ $record->process }} Total</b></b></td>
                                <td><b><b>{{ number_format($groupProcess->firstWhere('process', $record->process)->total_net_weight, 3, ',', '.') }}</b></b>
                                </td>
                                <td><b><b>{{ $recordsPrint->Where('process', $record->process)->count() }}</b></b></td>
                            </tr>
                            @php
                                $oldProcess = $record->process;
                            @endphp
                        @endif

                        @if ($oldProcess != $record->process || $oldProduct != $record->product_code)
                            <tr>
                                <td><b><b>{{ $record->process }}</b></b></td>
                                <td colspan="{{$showForSeparation?4:2}}"><b><b>{{ $record->product_code . ' - ' . $record->product_description }}
                                        Total</b></b></td>
                                <td><b><b>{{ number_format($groupProcessProduct->Where('process', $record->process)->firstWhere('product_code', $record->product_code)->total_net_weight, 3, ',', '.') }}</b></b>
                                </td>
                                <td><b><b>{{ $recordsPrint->Where('process', $record->process)->Where('product_code', $record->product_code)->count() }}</b></b>
                                </td>
                            </tr>
                            @php
                                $oldProduct = $record->product_code;
                            @endphp
                        @endif
                        <tr>
                            <td><b>{{ $record->process }}</b></td>
                            <td><b>{{ $record->product_code }}</b></td>
                            @if ($showForSeparation)
                                <td>{{ $record->id }}</td>
                                <td>{{ $record->address }}</td>
                            @endif
                            <td>{{ $record->batch }}</td>
                            <td>{{ number_format($record->net_weight, 3, ',', '.') }}</td>
                            <td>1</td>
                        </tr>
                    @endforeach

                    <h6><b>TOTAL GERAL: {{number_format($recordsPrint->sum('net_weight'),3, ',', '.')}} Kg e {{ $recordsPrint->count() }} Volumes</b></h6>
                </tbody>
            </table>
        </div>
    @endsection
@endisset

@push('scripts')
    <script></script>
@endpush
