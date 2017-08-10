<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use App\Routing\Route\EventoRoute;
use App\Routing\Route\DebugRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);



Router::scope('/', function (RouteBuilder $routes) {
    
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->connect('/:controller/:id',
        ['action'=>'view'],
        ['id' => '\d+', 'pass' => ['id']]);


    $routes->connect(
        '/eventos/:idEvento/:controller',
        ['action'=>'index'],
        ['idEvento' => '\d+', 'pass' => ['idEvento'],'routeClass'=>'EventoRoute']  
    );
    
     $routes->connect(
        '/eventos/:idEvento/:controller/:action/:id',
        [],
        ['id'=>'\d+',
        'idEvento'=>'\d+',
        'pass'=>['id','idEvento'],
        'routeClass'=>'EventoRoute']
    );

    $routes->connect('/eventos/:idEvento/:controller/:action/*', 
        [], 
        ['idEvento'=>'\d+',
        'pass'=>['idEvento'],
        'routeClass'=>'EventoRoute']);
    
    $routes->connect('/eventos/:action/*',['controller'=>'Eventos'],['routeClass'=>'DashedRoute']);

    //TODO #HERON beautifull routing para RESTful

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    
    $routes->fallbacks(DashedRoute::class);

});

Router::scope("/csv",function(RouteBuilder $routes){
    $routes->addExtensions(['csv']);
    $routes->connect('/eventos/:idEvento/divisorDespesas/:action',
            ['controller'=>'DivisorDespesas'],
             ['idEvento'=>'\d+',
            'pass'=>['idEvento'],
            'routeClass'=>'DashedRoute']);
});

Router::prefix('api',function (RouteBuilder $routes){
    $routes->extensions(['json']);
    Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);

     $routes->resources('Eventos',[
        'map' =>[
            'add_consumable/:id' =>[
                'action' => 'addConsumable',
                'method' => 'POST'
            ],
            'add_participante/:id' =>[
                'action' => 'addParticipante',
                'method' => 'POST'
            ]
        ]
    ]);
    $routes->resources('Consumables');
    $routes->resources('Participantes');
    $routes->resources('Collaborations');
    $routes->resources('Consumptions');
    
    $routes->connect(
        '/eventos/:idEvento/:controller',
        ['action'=>'index'],
        ['idEvento' => '\d+', 'pass' => ['idEvento'],'routeClass'=>'DashedRoute']  
    );
    
    $routes->connect(
            '/eventos/:idEvento/divisor/balancoParticipantes', 
            ['controller' => 'DivisorDespesas',
            'action' => 'balancoParticipantes'], 
            ['idEvento' => '\d+', 
                'pass' => ['idEvento'], 
                'routeClass' => 'DashedRoute']
            );
    
    $routes->connect(
            '/eventos/:idEvento/divisor/detalhamentoParticipante/:idParticipante', 
            ['controller' => 'DivisorDespesas',
            'action' => 'detalhamentoParticipante'], 
            ['idEvento' => '\d+', 
              'idParticipante' => '\d+',
                'pass' => ['idEvento','idParticipante'], 
                'routeClass' => 'DashedRoute']
            );
    
    $routes->connect(
            '/eventos/:idEvento/divisor/detalhamentoConsumivel/:idConsumivel', 
            ['controller' => 'DivisorDespesas',
            'action' => 'detalhamentoConsumivel'], 
            ['idEvento' => '\d+', 
              'idConsumivel' => '\d+',
                'pass' => ['idEvento','idConsumivel'], 
                'routeClass' => 'DashedRoute']
            );
            
    $routes->connect(
            '/eventos/:idEvento/divisor/balancoConsumiveis', 
            ['controller' => 'DivisorDespesas',
            'action' => 'balancoConsumiveis'], 
            ['idEvento' => '\d+', 
                'pass' => ['idEvento'], 
                'routeClass' => 'DashedRoute']
            );

    $routes->fallbacks(DashedRoute::class);
    
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
