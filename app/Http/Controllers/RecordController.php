<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordStoreRequest;
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
        $valuesSelectAddresses = Record::listAddressNotExpedition();
        return view('records.index', compact('records', 'valuesExpedition', 'valuesSelectProcess', 'valuesSelectProducts','valuesSelectAddresses'));
    }

    public function search(Request $request)
    {
        $valueProcess = $request->process;
        $valueProduct = $request->product_code;
        $valueAddress = $request->address;
        $product_description = $request->description;
        $limit = $request->limitRegister ?? 1000;

        $isFilter = true;
        if ($valueProcess && $valueProcess !== "ALL" && $valueProduct && $valueAddress) {
            $records = Record::limit($limit)->whereExpedition($request->search_expedition ?? '')->where('process', $valueProcess)->where('product_code', $valueProduct)->where('address', $valueAddress)->orderBy('process')->orderBy('product_code')->orderByDesc('id')->get();
        } elseif ($valueProcess && $valueProcess !== "ALL" && $valueProduct) {
            $records = Record::limit($limit)->whereExpedition($request->search_expedition ?? '')->where('process', $valueProcess)->where('product_code', $valueProduct)->orderBy('process')->orderBy('product_code')->orderByDesc('id')->get();
        } elseif ($valueProcess && $valueProcess !== "ALL") {
            $records = Record::limit($limit)->whereExpedition($request->search_expedition ?? '')->whereProcess($valueProcess)->orderBy('process')->orderBy('product_code')->orderByDesc('id')->get();
        } elseif ($valueProduct) {
            $records = Record::limit($limit)->whereExpedition($request->search_expedition ?? '')->where('product_code', $valueProduct)->orderBy('process')->orderBy('product_code')->orderByDesc('id')->get();
        } elseif ($valueAddress) {
            $records = Record::limit($limit)->whereExpedition($request->search_expedition ?? '')->where('address', $valueAddress)->orderBy('process')->orderBy('product_code')->orderByDesc('id')->get();
        } else {
            $records = Record::limit($limit)->whereExpedition($request->search_expedition ?? '')->orderByDesc('id')->get();
        }

        $seachProcess = $request->process;
        $seachProduct = $request->product_code;
        $seachAddress = $request->address;
        $searchExpedition = $request->search_expedition ?? '';
        $openModalRegister = $request->openModalRegister ?? false;

        $valuesExpedition = Record::listExpedition();
        $valuesSelectProcess = Record::listProcessNotExpedition();
        $valueProcess = $valueProcess !== 'ALL' ? $valueProcess : '';
        $valuesSelectProducts = Record::listProductNotExpedition($valueProcess ?? '');
        $valuesSelectAddresses = Record::listAddressNotExpedition($valueProcess ?? '',$valueProduct ?? '');


        if ($searchExpedition == '')
            return view('records.index', compact('records', 'isFilter', 'seachProcess', 'seachProduct','seachAddress', 'valuesExpedition', 'valuesSelectProcess', 'valuesSelectProducts', 'openModalRegister', 'product_description','valuesSelectAddresses'));
        return view('records.index', compact('records', 'isFilter', 'searchExpedition', 'seachProcess', 'seachProduct', 'seachAddress' , 'valuesExpedition', 'valuesSelectProcess', 'valuesSelectProducts', 'openModalRegister', 'product_description','valuesSelectAddresses'));
    }

    public function moveSelectedToTarget(Request $request)
    {
        if (!$request->address_target)
            return back()->with('error', 'Movimentação não realizada, informe o ENDEREÇO DESTINO.');

        $addressTarget = $request->address_target;
        $items = $request->items_selected;

        foreach ($items as $item) {
            $record = Record::find($item);
            $record->update(["address" => $addressTarget, "old_address" => $record->address]);
        }

        return back()->with('success', "Itens movimentados para endereço {$addressTarget}");
    }

    public function updateExpeditionItemsSelected(Request $request)
    {
        if (!$request->shipping_date)
            return back()->with('error', 'Expedição não realizada, informe a CARGA.');
            
        $shippingDate = date('d/m/Y-') . $request->shipping_date;
        $itemsSelected = $request->items_selected;

        foreach ($itemsSelected as $item) {
            $record = Record::find($item);
            $record->update(["expedition" => $shippingDate]);
        }
        return redirect()->route('control.batch.index')->with('success', 'Expedição realizada!');
    }

    public function cleanExpeditionItem(Record $record)
    {
        $record->update(["expedition" => '']);
        return back()->with('success', "Registro {$record->id} está pendente de expedição novamente.");
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
            $inputs = $request->input();
            Record::create($inputs);
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
        return back()->with('success', "Registro {$record->id}  alterado!");
    }

    public function destroy(Record $record)
    {
        return redirect()->route('control.batch.index');
    }

    public function print(Request $request,  $showForSeparation = true)
    {
        $recordsPrint = Record::orderBy('process')->orderBy('product_code')->find($request->items_selected);
        $groupProcess =  Record::select('process', Record::raw('SUM(net_weight) as total_net_weight'))->groupBy('process')->orderBy('process')->find($request->items_selected);
        $groupProcessProduct =  Record::select('process', 'product_code', Record::raw('SUM(net_weight) as total_net_weight'))->groupBy('process', 'product_code')->orderBy('process')->orderBy('product_code')->find($request->items_selected);
        return view('records.print', compact('recordsPrint', 'groupProcess', 'groupProcessProduct', 'showForSeparation'));
    }
    public function printExpedition(Request $request)
    {
        return $this->print($request, false);
    }
}
