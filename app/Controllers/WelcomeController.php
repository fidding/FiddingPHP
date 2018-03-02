<?php
namespace App\Controllers;

use App\Models\Users;
use Illuminate\Container\Container;
use Core\View as View;

class WelcomeController
{
    public function index()
    {
        $student = Users::first();
        $data = $student->getAttributes();

        $view = new View();
        return $view->make('test')
            ->with('data', $data)
            ->with('test', 'test');

        // $app = Container::getInstance();
        // $factory = $app->make('view');
        // return $factory->make('welcome')->with('data', $data);
        // return $data;
        // return 'welcome';
    }
}