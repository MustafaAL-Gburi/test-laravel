<?php
/**
 * Service for handling AJAX table requests (DataTables compatible)
 * User: amank oppm
 * Date: 17.04.18
 * Time: 13:50
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AjaxTableService
{
    protected Request $request;
    protected array $search = [];
    protected $searchCallback = null;
    protected $view = false;
    protected array $params = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function registerSearch(string $name, callable $func): self
    {
        $this->search[$name] = $func;
        return $this;
    }

    public function registerSearchCallback(callable $func): self
    {
        $this->searchCallback = $func;
        return $this;
    }

    public function setError(): void
    {
        // TODO: Implement proper error handling
        \Log::error('AjaxTableService error called');
    }

    public function useView(string $viewFile, array $params = []): self
    {
        $this->view = $viewFile;
        $this->params = $params;
        return $this;
    }

    public function response(Builder $qb, string $optional = ''): array
    {
        if (isset($this->request->order) && !empty($this->request->order)) {
            foreach ($this->request->order as $order) {
                $qb->orderBy($order[0], $order[1]);
            }
        }
        if (isset($this->request->search) && !empty($this->request->search)) {
            if (!is_null($this->searchCallback)) {
                $this->searchCallback->call($qb, (object) $this->request->search);
            } else {
                foreach ($this->request->search as $name => $value) {
                    if (isset($this->search[$name]) && $value != '') {
                        //$qb = $this->search[$name]($qb, $value);
                        $this->search[$name]->call($qb, $value);
                    }
                }
            }
        }
        if (isset($this->request->total) && $this->request->total) {
            $start = (isset($this->request->start) && $this->request->start > 0) ? ($this->request->start / $this->request->length) + 1 : 1;
            $result = $qb->paginate($this->request->length, ['*'], 'page', $start);
            if ($this->view === false) {
                return [
                    'draw' => $this->request->draw ?? 1,
                    'total' => $result->total(),
                    'data' => $result->items()
                ];
            } else {
                $this->params['data'] = $result->items();
                $view = view($this->view, $this->params)->with(['optional'=>$optional]);
                return [
                    'draw' => $this->request->draw ?? 1,
                    'total' => $result->total(),
                    'view' => $view->render()
                ];
            }
        } else {
            $start = (isset($this->request->start) && $this->request->start > 0) ? $this->request->start : 0;
            $length = $this->request->length ?? 10;
            if ($this->view === false) {
                return [
                    'draw' => $this->request->draw ?? 1 ,
                    'data' => $qb->skip($start)->take($length)->get()
                ];
            } else {
                $this->params['data'] = $qb->skip($start)->take($length)->get();
                $view = view($this->view, $this->params)->with(['optional'=>$optional]);
                return [
                    'draw' => $this->request->draw ?? 1,
                    'view' => $view->render()
                ];
            }
        }
    }
}
