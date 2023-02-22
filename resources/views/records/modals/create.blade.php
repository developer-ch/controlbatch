<!-- Modal Structure -->
<div id="create" class="modal bottom-sheet">
    <form action="{{ route('control.batch.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="modal-content">
            <h6><b>LANÇAMENTO</b></h6>
            <hr>
            <div class="row">
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">description</i>
                    <input id="product_code" type="text" name="product_code" value="{{ $seachProduct ?? '' }}"
                    required>
                    <label for="product_code">PRODUTO</label>
                </div>
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">description</i>
                    <input id="product_description" type="text" name="product_description"
                    value="{{ $product_description ?? '' }}" required>
                    <label for="product_description">DESCRICAO</label>
                </div>
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">description</i>
                    <input id="process" type="text" name="process" value="{{ $seachProcess ?? '' }}" required>
                    <label for="process">PROCESSO</label>
                </div>
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">description</i>
                    <input id="batch" type="text" name="batch" autofocus="autofocus" required>
                    <label for="batch">LOTE-PRODUTO</label>
                </div>
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">fitness_center</i>
                    <input id="net_weight" type="text" name="net_weight" required>
                    <label for="net_weight">PESO-LIQUIDO</label>
                </div>
                <div class="input-field col s12 m4">
                    <i class="material-icons prefix">location_searching</i>
                    <input id="address" type="text" name="address" value="" required>
                    <label for="address">ENDEREÇO</label>
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit">SALVAR
                <i class="material-icons left">save</i>
            </button>
            <a class="btn black modal-close"><i class="material-icons">close</i>FECHAR</a>
        </div>
    </form>
</div>
