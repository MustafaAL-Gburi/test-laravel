<div class="dialog-title">Beruf bearbeiten</div>

{!! Form::open('/beruf/update/' . $beruf->id, 'POST')->setAttribute('onsubmit', 'return submitDialog(this);') !!}

{!! Form::text('beruf', 'Beruf')->value($beruf->beruf) !!}

<br>

<button type="submit" class="btn btn-success">Speichern</button>

{!! Form::close() !!}
