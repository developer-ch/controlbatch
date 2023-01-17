<!-- Modal Structure -->
<div id="create" class="modal modal-fixed-footer">
    <form action="{{ route('control.batch.store')}}" method="POST">
        @csrf
        <div class="modal-content">
            <h4>Lançamento</h4>
            <hr>
            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">description</i>
                    @if (old('product_code'))
                        <input id="icon_prefix" type="text" name="product_code" value="{{ old('product_code') }}"
                            required>
                    @else
                        <input id="icon_prefix" type="text" name="product_code" autofocus="autofocus" required>
                    @endif
                    <label for="icon_prefix">PRODUTO</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">description</i>
                    <input id="icon_prefix" type="text" name="product_description"
                        value="{{ old('product_description') }}" required>
                    <label for="icon_prefix">DESCRICAO</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">description</i>
                    <input id="icon_prefix" type="text" name="process" value="{{ old('process') }}" required>
                    <label for="icon_prefix">PROCESSO</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">description</i>
                    <input id="icon_prefix" type="text" name="batch" autofocus="autofocus" required>
                    <label for="icon_prefix">LOTE CLIENTE</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">fitness_center</i>
                    <input id="icon_prefix" type="text" name="net_weight" required>
                    <label for="icon_prefix">PESO LIQUIDO</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">location_searching</i>
                    <input id="icon_prefix" type="text" name="address" value="{{ old('address') }}" required>
                    <label for="icon_prefix">ENDEREÇO</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn waves-effect waves-light" type="submit">SALVAR
                <i class="material-icons left">save</i>
            </button>
            <a class="btn black modal-close"><i class="material-icons">close</i>FECHAR</a>
        </div>
    </form>
</div>