{{-- ========================================= --}}
{{-- Berufe List View --}}
{{-- ========================================= --}}

{{-- Check if data exists --}}
@if (!empty($data))

    {{-- Check view permission --}}
    @if ($can_view ?? \App\Helpers\helper::can('berufe->view'))

        {{-- Data Table --}}
        <table id="data-table" class="list fixed-header max-height" style="width: 100%">
            <thead>
                <tr>
                    {{-- Table Headers --}}
                    <th width="50">Id</th>
                    <th>Beruf</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through data --}}
                @foreach ($data as $db)
                    <tr>
                        {{-- Display record ID --}}
                        <td>{{ $db->id }}</td>

                        {{-- Display profession name --}}
                        <td>{{ $db->beruf }}</td>

                        {{-- Action buttons --}}
                        <td class="actions">

                            {{-- View button (only if can view but not edit) --}}
                            @if (($can_view ?? \App\Helpers\helper::can('berufe->view')) && !($can_edit ?? \App\Helpers\helper::can('berufe->edit')))
                                <a class="icon open-dialog list-action" title="Anzeigen"
                                    href="/beruf/edit/{{ $db->id }}">
                                    <i class="far fa-eye"></i>
                                </a>
                            @endif

                            {{-- Edit button --}}
                            @if ($can_edit ?? \App\Helpers\helper::can('berufe->edit'))
                                <a class="icon list-action open-dialog" title="Bearbeiten"
                                    href="/beruf/edit/{{ $db->id }}">
                                    <i class="far fa-edit"></i>
                                </a>
                            @endif

                            {{-- Delete button --}}
                            @if ($can_delete ?? \App\Helpers\helper::can('berufe->delete'))
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

    {{-- No data found message --}}
@else
    <div style="text-align:center; padding:20px; color:#777;">
        📭 Keine Daten gefunden
    </div>
@endif
