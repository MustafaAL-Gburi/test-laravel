@php
    $isEdit = isset($beruf->id);
@endphp

<div class="dialog-title">
    {{ $isEdit ? 'Daten von ' . $beruf->id . ' | ' . $beruf->beruf : 'Neuer Beruf' }}
</div>

<div class="dialog-content">

    {!! Form::open($isEdit ? '/beruf/update/' . $beruf->id : '/beruf/store', 'POST')->setAttribute(
        'onsubmit',
        'return submitDialog(this);',
    ) !!}

    {{-- STATUS --}}
    {!! Form::select('status', 'Status')->options([
            1 => 'aktiv',
            0 => 'inaktiv',
            2 => 'alte Berufsbezeichnung',
        ])->value($beruf->status ?? 1) !!}

    {{-- BERUF --}}
    {!! Form::text('beruf', 'Beruf Name')->value($beruf->beruf ?? '') !!}

    {{-- MAENNLICH --}}
    {!! Form::text('maennlich', 'Beruf Name (maskulin)')->value($beruf->maennlich ?? '') !!}

    {{-- WEIBLICH --}}
    {!! Form::text('weiblich', 'Beruf Name (feminin)')->value($beruf->weiblich ?? '') !!}

    {{-- KEYWORDS --}}
    {!! Form::text('keywords', 'Keywords')->value($beruf->keywords ?? '') !!}

    {{-- BA ID --}}
    {!! Form::text('ba_id', 'BA Id')->value($beruf->ba_id ?? '') !!}

    {{-- BA ZUSTAND --}}
    {!! Form::select('ba_zustand', 'BA Zustand')->options([
            'E' => 'E',
            'A' => 'A',
        ])->value($beruf->ba_zustand ?? '') !!}

    {{-- Cancel button --}}
    <div class="buttonbar">
        <button type="button" class="btn btn-secondary" onclick="closeDialog()">
            Abbrechen
        </button>


        {{-- Save button --}}
        <button type="submit" class="btn btn-success">
            Speichern
        </button>
    </div>

    {!! Form::close() !!}

</div>
