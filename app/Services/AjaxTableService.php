<?php
/**
 * User: amank oppm
 * Date: 17.04.18
 * Time: 13:50
 */

namespace App\Services;

use Illuminate\Http\Request;

class AjaxTableService extends \DB
{
    protected $request;
    protected $search = [];
    protected $searchCallback = null;
    protected $view = false;
    protected $params = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function registerSearch($name, $func)
    {
        $this->search[$name] = $func;
    }

    public function registerSearchCallback($func)
    {
        $this->searchCallback = $func;
    }

    public function setError()
    {
        echo "set error called";
    }

    public function useView($viewFile, $params = [])
    {
        $this->view = $viewFile;
        $this->params = $params;
    }

    public function response($qb,$optional='')
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
