<?php

namespace App\Http\Controllers;

use App\Models\Beruf;
use App\Services\AjaxTableService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBerufRequest;
use App\Http\Requests\UpdateBerufRequest;

class BerufController extends Controller
{
    /**
     * Display the index page for berufe.
     */
    public function index()
    {
        return view('berufe.index');
    }

    /**
     * Get the list of berufe for AJAX table.
     */
    public function getList(AjaxTableService $table)
    {
        $queryBuilder = Beruf::query();

        // Search functionality
        $table->registerSearch('volltext', function ($value) use ($queryBuilder) {
            $queryBuilder->where(function ($q) use ($value) {
                $q->where('beruf', 'like', "%$value%")
                  ->orWhere('maennlich', 'like', "%$value%")
                  ->orWhere('weiblich', 'like', "%$value%")
                  ->orWhere('keywords', 'like', "%$value%");
            });
        });

        // Set the view for the table with permissions to avoid N+1 queries
        $table->useView('berufe.list', [
            'can_view' => \App\Helpers\helper::can('berufe->view'),
            'can_edit' => \App\Helpers\helper::can('berufe->edit'),
            'can_delete' => \App\Helpers\helper::can('berufe->delete'),
        ]);

        return $table->response($queryBuilder);
    }

    /**
     * Show the edit form for a beruf.
     */
    public function edit($id = null)
    {
        $beruf = $id ? Beruf::find($id) : new Beruf();

        return view('berufe.edit', compact('beruf'));
    }

    /**
     * Update an existing beruf.
     */
    public function update(UpdateBerufRequest $request, $id)
    {
        $beruf = Beruf::findOrFail($id);
        $beruf->update($request->validated());

        return $this->successResponse('Gespeichert!');
    }

    /**
     * Store a new beruf.
     */
    public function store(StoreBerufRequest $request)
    {
        Beruf::create($request->only([
            'beruf',
            'maennlich',
            'weiblich',
            'keywords',
            'ba_id',
            'status',
            'ba_zustand',
            'fragebogen_id'
        ]));

        return $this->successResponse('Erstellt!');
    }

    /**
     * Delete a beruf.
     */
    public function delete($id)
    {
        $beruf = Beruf::findOrFail($id);
        $beruf->delete();

        return $this->successResponse('Gelöscht!');
    }

    /**
     * Return a standardized success response.
     */
    private function successResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'msg' => $message,
            'execute' => "window.ats.performSearch();"
        ]);
    }
}