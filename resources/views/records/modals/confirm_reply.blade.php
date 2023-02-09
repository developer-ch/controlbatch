<!-- Modal Structure -->
<div id="confirmReply" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Registro {{  $record->id??0 }} </h4>
        <hr>
        <div class="col s4 l1 m2"><h5><i class="large material-icons">help</i>Voltar para pendente de expedição.<br/>Tem certeza? Essa operação, não poderá ser desfeita.</h5></div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn red" formaction="{{ route('control.batch.clean.expedition', $record->id??0) }}" name="_method"
            value="GET"><i class="material-icons">check</i>SIM</button>
            <a class="btn modal-close"><i class="material-icons">close</i>NÃO</a>
    </div>
</div>
