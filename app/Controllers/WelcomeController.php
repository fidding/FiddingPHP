<?php
namespace App\Controllers;

use App\Models\Users;
use Illuminate\Container\Container;

class WelcomeController
{
    public function index()
    {
        $student = Users::first();
        $data = $student->getAttributes();

        \Redis::set('a', '123');
        $a = \Redis::get('a');
        \Redis::delete('a');
        return \View::make('test')
            ->with('data', $data)
            ->with('test', 'test');

        // $app = Container::getInstance();
        // $factory = $app->make('view');
        // return $factory->make('welcome')->with('data', $data);
        // return $data;
        // return 'welcome';
    }
}