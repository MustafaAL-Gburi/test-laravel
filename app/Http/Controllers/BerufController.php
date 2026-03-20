<?php

namespace App\Http\Controllers;

use App\Models\Beruf;
use App\Services\AjaxTableService;
use Illuminate\Http\Request;

class BerufController extends Controller
{
    public function index()
    {
        return view('berufe.index');
    }

    public function get_list(AjaxTableService $table)
    {
        $qb = Beruf::query();

        // search
        $table->registerSearch('volltext', function($value) {
            $this->where(function($q) use ($value) {
                $q->where('beruf', 'like', "%$value%")
                  ->orWhere('maennlich', 'like', "%$value%")
                  ->orWhere('weiblich', 'like', "%$value%")
                  ->orWhere('keywords', 'like', "%$value%");
            });
        });

        // view
        $table->useView('berufe.list');

        return $table->response($qb);
     } 
 }