<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::limit(0)->whereExpeditionOrExpedition(null, '')->orderByDesc('id')->get();
        $valuesExpedition = Record::listExpedition();
        $valuesSelectProcess = Record::listProcessNotExpedition();
        $valuesSelectProducts = Record::listProductNotExpedition();
        return view('records.index', compact('records', 'valuesExpedition', 'valuesSelectProcess', 'valuesSelectProducts'));
    }

    public function search(Request $request)
    {
        $valueProcess = $request->process;
        $valueProduct = $request->product_code;

        $isFilter = true;
        if ($valueProcess && $valueProcess !== "ALL" && $valueProduct) {
            $records = Record::whereExpedition($request->search_expedition ?? '')->where('process', $valueProcess)->where('product_code', $valueProduct)->orderBy('process')->orderBy('product_code')->get();
        } elseif ($valueProcess && $valueProcess !== "ALL") {
            $records = Record::whereExpedition($request->search_expedition ?? '')->whereProcess($valueProcess)->orderBy('process')->orderBy('product_code')->get();
        } elseif ($valueProduct) {
            $records = Record::whereExpedition($request->search_expedition ?? '')->where('product_code', $valueProduct)->orderBy('process')->orderBy('product_code')->get();
        } else {
            $records = Record::whereExpedition($request->search_expedition ?? '')->orderByDesc('id',)->get();
        }

        $seachProcess = $request->process;
        $seachProduct = $request->product_code;
        $searchExpedition = $request->search_expedition ?? '';
        $openModalRegister = $request->openModalRegister ?? false;
    
        $valuesExpedition = Record::listExpedition();
        $valuesSelectProcess = Record::listProcessNotExpedition();
        $valueProcess = $valueProcess !== 'ALL' ? $valueProcess : '';
        $valuesSelectProducts = Record::listProductNotExpedition($valueProcess ?? '');


        if ($searchExpedition == '')
            return view('records.index', compact('records', 'isFilter', 'seachProcess', 'seachProduct', 'valuesExpedition', 'valuesSelectProcess', 'valuesSelectProducts','openModalRegister'));
        return view('records.index', compact('records', 'isFilter', 'searchExpedition', 'seachProcess', 'seachProduct', 'valuesExpedition', 'valuesSelectProcess', 'valuesSelectProducts','openModalRegister'));
    }

    public function moveSelectedToTarget(Request $request)
    {
        if ($request->address_target) {
            $addressTarget = $request->address_target;
            $itemsSelected = $request->items_selected;

            foreach ($itemsSelected as $item) {
                $record = Record::find($item);
                $record->update(["address" => $addressTarget, "old_address" => $record->address]);
            }

            return back()->with('success', 'SUCESSO: Movimentação realizada');
        }
        return back()->with('error', 'ERRO: Movimentação não realizada, informe o ENDEREÇO DESTINO.');
    }

    public function updateExpeditionItemsSelected(Request $request)
    {
        if ($request->shipping_date) {
            $shippingDate = date('d/m/Y-') . $request->shipping_date;
            $itemsSelected = $request->items_selected;

            foreach ($itemsSelected as $item) {
                $record = Record::find($item);
                $record->update(["expedition" => $shippingDate]);
            }

            return back()->with('success', 'SUCESSO: Expedição realizada!');
        }
        return back()->with('error', 'ERRO: Expedição não realizada, informe a CARGA.');
    }

    public function cleanExpeditionItem(Record $record)
    {
        $record->update(["expedition" => '']);
        return back()->with('success', 'SUCESSO: Expedição realizada!');
    }

    public function deleteItemsSelected(Request $request)
    {
        $itemsSelected = $request->items_selected;

        foreach ($itemsSelected as $item) {
            Record::find($item)->delete();
        }
        return redirect()->route('control.batch.index')->with('success', 'Registro(s) excluido(s) com sucesso!');
    }

    public function create()
    {
        return redirect()->route('control.batch.index');
    }

    public function store(Request $request)
    {
        Record::create($request->all());
        return redirect()->route('control.batch.search', ['process' => $request->process, 'product_code' => $request->product_code] + ['description' => $request->product_description] + ['openModalRegister' => true])->with('success', 'Cadastrado com sucesso!');
    }

    public function show(Record $record)
    {
        return redirect(route('control.batch.index'))->with('warning', 'Teste');
    }

    public function edit(Record $record)
    {
        return redirect()->route('control.batch.index');
    }

    public function update(Request $request, Record $record)
    {
        $record->update($request->input());
        return back()->with('success', 'Registro alterado!');
    }

    public function destroy(Record $record)
    {
        return redirect()->route('control.batch.index');
    }

    public function print(Request $request,  $showForSeparation = true)
    {
        $recordsPrint = Record::find($request->items_selected);
        $groupProcess =  Record::select('process', Record::raw('SUM(net_weight) as total_net_weight'))->groupBy('process')->orderBy('process')->find($request->items_selected);
        $groupProcessProduct =  Record::select('process', 'product_code', Record::raw('SUM(net_weight) as total_net_weight'))->groupBy('process', 'product_code')->orderBy('process')->orderBy('product_code')->find($request->items_selected);
        return view('records.print', compact('recordsPrint', 'groupProcess', 'groupProcessProduct', 'showForSeparation'));
    }
    public function printExpedition(Request $request)
    {
        return $this->print($request, false);
    }
}
