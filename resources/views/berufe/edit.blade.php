@php
    $isEdit = isset($beruf->id);
@endphp

<div class="dialog-title">
    {{ $isEdit ? 'Beruf bearbeiten' : 'Neuer Beruf' }}
</div>

{!! Form::open($isEdit ? '/beruf/update/' . $beruf->id : '/beruf/store', 'POST')->setAttribute(
    'onsubmit',
    'return submitDialog(this);',
) !!}

{!! Form::text('beruf', 'Beruf')->value($beruf->beruf ?? '') !!}

<br>

<button type="submit" class="btn btn-success">
    {{ $isEdit ? 'Speichern' : 'Erstellen' }}
</button>

{!! Form::close() !!}
