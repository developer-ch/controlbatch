<!-- Modal Structure -->
<div id="confirmeDelete" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Exclusão de registro(s)</h4>
        <hr>
        <div class="col s4 l1 m2"><h5><i class="large material-icons">help</i>Tem certeza? Essa operação, não poderá ser desfeita.</h5></div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn red" formaction="{{ route('control.batch.exclusion') }}" name="_method"
            value="DELETE"><i class="material-icons">check</i>SIM</button>
            <a class="btn modal-close"><i class="material-icons">close</i>NÃO</a>
    </div>
</div>
