 @extends('layouts.master')

 @section('page_title', 'Berufe')

 @section('leftpanel')
     <ul>
         @if (\App\Helpers\helper::can('berufe->view'))
             <li>
                 {!! Form::text('volltext')->placeholder('Volltext Suche')->addClass('volltext') !!}
             </li>
             <li class="divider"></li>
         @endif
         @if (\App\Helpers\helper::can('berufe->new'))
             <li>
                 <a class="open-dialog" href="/beruf/edit"><i class="fa fa-plus"></i>Neuer Beruf</a>
             </li>
         @endif
         @if (\App\Helpers\helper::can('berufe->import'))
             <li>
                 <a class="open-dialog" href="/berufe/import"><i class="fa fa-upload"></i>Berufe Import</a>
             </li>
         @endif
     </ul>
 @endsection()
 @section('Help')
     @include('sidebars.Help.berufe', ['active' => 'anzeigen'])
 @endsection
 @section('breadcrump')
     <a href="/">Verwaltung</a>
     <a>Berufe</a>
 @endsection()

 @section('content')
     <div id="results">
     </div>
 @endsection

 @push('scripts')
     <script type="application/javascript">
        var searchFields = ['volltext'];
        $(document).ready(function () {
            var ats = $('#results').AjaxTable({
                url: '/berufe/get_list',
                sortable: ['id', 'beruf'],
                defaultSort: [['beruf', 'asc']],
                perPage: 100,
                onUpdate: function() { registerDefaultEvents($('#results')); }
            });
            ats.searchObserve(searchFields);
        });
    </script>
 @endpush
