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
         public function edit($id = null)
    {
    $beruf = $id ? Beruf::find($id) : new Beruf();

    return view('berufe.edit', compact('beruf'));
    }
        public function update(Request $request, $id)
{
    $request->validate([
        'beruf' => 'required'
    ]);

    $beruf = Beruf::findOrFail($id);

    $beruf->update($request->all());

  return response()->json([
    'success' => true,
    'msg' => 'Gespeichert!',
    'execute' => "window.ats.performSearch();"
]);
}
public function store(Request $request)
 {
    
    $request->validate([
        'beruf' => 'required'
    ]);
    Beruf::create($request->all());
  

    return response()->json([
        'success' => true,
        'msg' => 'Erstellt!',
        'execute' => "window.ats.performSearch();"
    ]);
 }
// public function store(StoreBerufRequest $request)
// {
//     $beruf = Beruf::create($request->validated());

//     return response()->json([
//         'success' => true,
//         'msg' => 'Erstellt!',
//         'execute' => "window.ats.performSearch();"
//     ]);
// }
public function delete($id)
{
    $beruf = Beruf::findOrFail($id);
    $beruf->delete();

    return response()->json([
        'success' => true,
        'msg' => 'Gelöscht!',
        'execute' => "window.ats.performSearch();"
    ]);
}
 }