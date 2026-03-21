 @extends('layouts.master')

 @section('page_title', 'Berufe')

 @section('leftpanel')
     <ul>
         <li>
             <div class="form-group">
                 <input type="text" id="volltext" class="form-control" placeholder="Volltext Suche">
             </div>
         </li>

         <li class="divider"></li>

         <li>
             <a class="open-dialog" href="/beruf/edit">
                 <i class="fa fa-plus"></i> Neuer Beruf
             </a>
         </li>
     </ul>
 @endsection
 @section('Help')
     @include('sidebars.Help.berufe', ['active' => 'anzeigen'])
 @endsection

 @section('content')

     <div class="d-flex justify-content-between align-items-center mt-2">
         <div class="pagination-info"></div>
         <div class="pagination-numbers"></div>
     </div>
     <div id="results"></div>
 @endsection

 @push('scripts')
     <script type="application/javascript">
        var searchFields = ['volltext'];
        $(document).ready(function () {
            window.ats = $('#results').AjaxTable({
        url: '/berufe/get_list',
        method: 'GET',

        // 🔥 sorting
        sortable: ['id', 'beruf'],
        defaultSort: [['beruf', 'asc']],

        // 🔥 pagination
        paginate: '.pagination-numbers',
        info: '.pagination-info',
        perPage: 20,
        paginateLength: 5,

        // 🔥 مهم جداً
        onUpdate: function () {
            registerDefaultEvents($('#results'));
        }
    });
            ats.searchObserve(searchFields);
        });
    </script>
 @endpush
