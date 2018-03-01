<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Fluent;

require __DIR__.'/vendor/autoload.php';

// 配置模块加载
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// echo getenv('APP_DEBUG');

// 实例话服务容器，注册事件，路由服务提供者
$app = new Illuminate\Container\Container;
Illuminate\Container\Container::setInstance($app);
with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();

// 启用ORM模块并进行配置
$manager = new Manager();
$manager->addConnection(require './config/database.php');
$manager->bootEloquent();

// 加载view
$app->instance('config', new Fluent);
$app['config']['view.compiled'] = __DIR__.'/cache/views/';
$app['config']['view.paths'] = [__DIR__.'/resources/views/'];
with(new Illuminate\View\ViewServiceProvider($app))->register();
with(new Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

// whoops错误提示
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// 加载路由
require __DIR__.'/routes/web.php';

// 实例化请求并分发处理请求
$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);

$response->send();