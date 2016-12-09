<?php

namespace Copya\Http\Controllers\FrontEnd;

use Config;
use Copya\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class PagesController extends BaseController
{
    protected $model;

    public function __construct()
    {
        if (is_null($model = config('copya.models.page'))) {
            throw new RuntimeException('Unable to determine user model from configuration.');
        }

        $this->model = new $model;
    }

    /*public function index()
    {
        return view('copya.admin.pages.index', array('sidenav' => $this->getSideNav()));
    }

    public function create()
    {
        return view('copya.admin.pages.form', array('sidenav' => $this->getSideNav()));
    }*/

    public function show(Request $request, $slug)
    {

        $page = $this->model->findBySlug($slug);
        if (!$page || $page->published_at == null) {
            return abort(404);
        }

        return view('vendor.copya.front.pages.show', array('page' => $page))->withShortcodes();
    }

    public function showBase(Request $request)
    {
        $slug = config('copya.base_page');
        $page = $this->model->findBySlug($slug);
        if (!$page || $page->published_at == null) {
            return abort(404);
        }

        return view('vendor.copya.front.pages.show', array('page' => $page))->withShortcodes();
    }
}
