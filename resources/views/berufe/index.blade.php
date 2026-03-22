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

        // Main document ready handler
        $(document).ready(function () {

            // AjaxTable initialization: retrieve data for the list view
            // and render in #results container
            window.ats = $('#results').AjaxTable({
                url: '/berufe/get_list',
                method: 'GET',

                // Enabled columns for sorting
                sortable: ['id', 'beruf'],
                defaultSort: [['beruf', 'asc']],

                // Pagination settings
                paginate: '.pagination-numbers',
                info: '.pagination-info',
                perPage: 20,
                paginateLength: 5,

                // Update event: bind row actions after each table refresh
                onUpdate: function () {
                    registerDefaultEvents($('#results'));
                }
            });

            // Live text search with debounce
            let timer;

            $('#volltext').on('keyup', function () {
                clearTimeout(timer);

                let value = $(this).val();

                timer = setTimeout(function () {
                    // only search if enough characters to reduce server load
                    if (value.length >= 2 || value.length === 0) {
                        window.ats.search('volltext', value);
                    }
                }, 100);
            });

        });

    </script>
 @endpush
