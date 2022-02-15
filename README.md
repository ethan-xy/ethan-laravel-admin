ETHAN-LARAVEL-ADMIN 是基于 Laravel 开发的服务端, 并提供基于 Vue3、 Element Plus、Vite 构建的后台管理模板
 <a href="https://github.com/ethan-xy/ethan-vue-admin" target="_blank">ETHAN-VUE-ADMIN</a>

## 要求
- Laravel  >= 8.0.0
- PHP ^7.3|^8.0

## 特性
- laravel8+vue3前后端分离
- 基于 laravel-permission 权限管理
- 基于 sanctum 鉴权
- 角色，权限，用户，菜单管理等API

## Demo
<a href="http://vue-t.splu.cn/login" target="_blank">测试地址</a>

账号:test
密码:123456

## 安装
需要安装laravel,并配置好数据库
```
composer require ethan-xy/ethan-laravel-admin
```

发布:
```
php artisan ethan:install
```

执行数据迁移
```
php artisan migrate
```

数据填充
```
php artisan db:seed --class="\Ethan\LaravelAdmin\Database\DatabaseSeeder"
```

## 修改
修改config/auth.php，增加配置
```
'auth_provider' => [
    'admin' => [
        'model' => \Ethan\LaravelAdmin\Models\AdminUser::class,
        'login_fields' => [
            'email',
            'name'
        ]
    ],
    'user' => [
        ...
    ]
]
```

修改 app/Http/Kernel.php ：
```
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        ...
        'ethan.permission' => \App\Http\Middleware\EthanAuthCanPermission::class,
    ];

    protected $middlewareGroups = [
        ...
        'api' => [
            ...
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ],
    ];
}
```


## 路由中间件
- auth:sanctum
- ethan.permission

## 依赖扩展包
- spatie/laravel-permission
- laravel/sanctum
- tucker-eric/eloquentfilter