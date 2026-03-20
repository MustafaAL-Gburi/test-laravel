@php
    $isEdit = isset($beruf->id);
@endphp
<div class="dialog-title">
    {{ $isEdit ? 'Daten bearbeiten' : 'Neuer Beruf' }}
</div>

<div class="dialog-content">

    {!! Form::open($isEdit ? '/beruf/update/' . $beruf->id : '/beruf/store', 'POST')->setAttribute(
        'onsubmit',
        'return submitDialog(this);',
    ) !!}

    {!! Form::text('beruf', 'Beruf Name')->value($beruf->beruf ?? '') !!}

    {!! Form::text('maennlich', 'Beruf Name (maskulin)')->value($beruf->maennlich ?? '') !!}

    {!! Form::text('weiblich', 'Beruf Name (feminin)')->value($beruf->weiblich ?? '') !!}

    {!! Form::text('keywords', 'Keywords')->value($beruf->keywords ?? '') !!}

    <br>

    <div style="display:flex; justify-content: space-between;">
        <button type="button" class="btn btn-secondary" onclick="closeDialog()">Abbrechen</button>
        <button type="submit" class="btn btn-success">Speichern</button>
    </div>

    {!! Form::close() !!}

</div>
