<!-- Modal Structure -->
<div id="edit" class="modal modal-fixed-footer">
    <form id="form_edit" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <h4>EDIÇÃO</h4>
            <hr>
            <div class="row">
                <input id="edit_id" type="hidden" name="id" required>
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">short_text</i>
                    <input placeholder="" id="edit_product_code" type="text" name="product_code"
                        value="{{ $record->product_code ?? '' }}" autofocus required>
                    <label for="edit_product_code">PRODUTO</label>
                </div>
                <div class="input-field col s12 m8">
                    <i class="material-icons prefix">description</i>
                    <input placeholder="" id="edit_product_description" type="text" name="product_description"
                        value="{{ $record->product_description ?? '' }}" required>
                    <label for="edit_product_description">DESCRICAO</label>
                </div>
                <div class="input-field col s12 m3">
                    <i class="material-icons prefix">short_text</i>
                    <input placeholder="" id="edit_process" type="text" name="process"
                        value="{{ $record->process ?? '' }}" required>
                    <label for="edit_process">PROCESSO</label>
                </div>
                <div class="input-field col s12 m9">
                    <i class="material-icons prefix">short_text</i>
                    <input placeholder="" id="edit_batch" type="text" name="batch"
                        value="{{ $record->batch ?? '' }}" required>
                    <label for="icon_prefix">LOTE CLIENTE</label>
                </div>
                <div class="input-field col s12 m5">
                    <i class="material-icons prefix">fitness_center</i>
                    <input placeholder="" id="edit_net_weight" type="text" name="net_weight"
                        value="{{ $record->net_weight ?? '' }}" required>
                    <label for="edit_net_weight">PESO LIQUIDO</label>
                </div>
                <div class="input-field col s7">
                    <i class="material-icons prefix">location_searching</i>
                    <input placeholder="" id="edit_address" type="text" name="address"
                        value="{{ $record->address ?? '' }}" required>
                    <label for="icon_prefix">Endereço</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn waves-effect waves-light" type="submit">ALTERAR
                <i class="material-icons left">save</i>
            </button>
            <a href="{{ redirect()->back() }}" class="btn black modal-close"><i
                    class="material-icons">close</i>FECHAR</a>
        </div>
    </form>
</div>
