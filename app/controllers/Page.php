<?php
class Page extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $data = [
            'titulo' => 'baseProject',
        ];
        $this->view('pages/index', $data);
    }
}
