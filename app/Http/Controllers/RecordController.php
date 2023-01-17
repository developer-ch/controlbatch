<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $isFilter = false;
        $records = Record::limit(20)->whereExpeditionOrExpedition(null, '')->orderByDesc('id')->get();
        return view('records.index', compact('records', 'isFilter'));
    }

    public function filter($process, $product = null)
    {
        $isFilter = true;
        if ($product) {
            $records = Record::whereExpeditionAndProcessAndProductCode('', $process, $product)->orderByDesc('id')->orderBy('process')->orderBy('product_code')->get();
        } else
            $records = Record::whereExpeditionOrExpeditionAndProcess(null, '', $process)->orderByDesc('id')->orderBy('process')->orderBy('product_code')->get();


        $seachProcess = $process;
        $seachProduct = $product;
        return view('records.index', compact('records', 'isFilter', 'seachProcess', 'seachProduct'));
    }

    public function search(Request $request)
    {
        $type_search_process = $request->type_search_process;

        $valueProcess = $type_search_process == 'like' ? '%' . $request->process . '%' : $request->process;

        $type_search_product = $request->type_search_product;

        $valueProduct = $type_search_product  == 'like' ? '%' . $request->product_code . '%' : $request->product_code;

        $isFilter = true;
        if ($request->product_code) {
            $records = Record::whereExpeditionOrExpedition(null, '')->where('process', $type_search_process, $valueProcess)->where('product_code', $type_search_product, $valueProduct)->orderBy('process')->orderBy('product_code')->get();
        } else
            $records = Record::whereExpeditionOrExpedition(null, '')->where('process', $type_search_process, $valueProcess)->orderBy('process',)->orderBy('product_code')->get();

        $seachProcess = $request->process;
        $seachProduct = $request->product_code;

        return view('records.index', compact('records', 'isFilter', 'seachProcess', 'seachProduct', 'type_search_process', 'type_search_product'));
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
            $shippingDate = date('dmY-') . $request->shipping_date;
            $itemsSelected = $request->items_selected;

            foreach ($itemsSelected as $item) {
                $record = Record::find($item);
                $record->update(["expedition" => $shippingDate]);
            }

            return back()->with('success', 'SUCESSO: Expedição realizada!');
        }
        return back()->with('error', 'ERRO: Expedição não realizada, informe a CARGA.');
    }

    public function deleteItemsSelected(Request $request)
    {
        $itemsSelected = $request->items_selected;

        foreach ($itemsSelected as $item) {
            Record::find($item)->delete();
        }

        return back()->with('success', 'Registro(s) excluido(s) com sucesso!');
    }

    public function create()
    {
        return redirect()->route('control.batch.index');
    }

    public function store(Request $request)
    {
        Record::create($request->all());
        return redirect()->route('control.batch.filters',['process' => $request->process,'product' => $request->product_code])->with('success', 'Cadastrado com sucesso!');
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

    public function print(Request $request)
    {
        $recordsPrint = Record::find($request->items_selected);
        $groupProcess =  Record::select('process',Record::raw('SUM(net_weight) as total_net_weight'))->groupBy('process')->orderBy('process')->find($request->items_selected);
        $groupProcessProduct =  Record::select('process','product_code',Record::raw('SUM(net_weight) as total_net_weight'))->groupBy('process','product_code')->orderBy('process')->orderBy('product_code')->find($request->items_selected);
        return view('records.print',compact('recordsPrint','groupProcess','groupProcessProduct'));

    }
}