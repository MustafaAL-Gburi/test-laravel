@if (!empty($data))
    @if (\App\Helpers\helper::can('berufe->view'))
        <table id="data-table" class="table table-hover table-striped" style="width: 100%">
            <thead>
                <tr>
                    <th width="50">Id</th>
                    <th>Beruf</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $db)
                    <tr>
                        <td>{{ $db->id }}</td><!-- $db=objekt von ats ajax tabelle, ->id=Feldname -->
                        <td>{{ $db->beruf }}</td><!-- $db=objekt von ats ajax tabelle, ->beruf=Feldname -->
                        <td class="actions">
                            @if (\App\Helpers\helper::can('berufe->view') && \App\Helpers\helper::cant('berufe->edit'))
                                <a class="icon open-dialog list-action" title="Anzeigen"
                                    href="/beruf/edit/{{ $db->id }}"><i class="far fa-eye"></i></a>
                            @endif
                            @if (\App\Helpers\helper::can('berufe->edit'))
                                <a class="icon list-action open-dialog" title="Bearbeiten"
                                    href="/beruf/edit/{{ $db->id }}"><i class="far fa-edit"></i></a>
                            @endif
                            @if (\App\Helpers\helper::can('berufe->delete'))
                                <a class="icon icon-danger dialog-delete" data-dialog="Beruf wirklich löschen?"
                                    href="/beruf/loeschen/{{ $db->id }}">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@else
    <div style="text-align:center; padding:20px; color:#777;">
        📭 Keine Daten gefunden
    </div>
@endif
