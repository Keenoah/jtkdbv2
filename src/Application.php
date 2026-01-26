<?php
declare(strict_types=1);

namespace App;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router; // Added for automatic URL handling

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        $this->addPlugin('CakePdf');

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }

        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]))
            ->add(new AuthenticationMiddleware($this));

        return $middlewareQueue;
    }

public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        // 1. Detect if we are on an Admin Page OR the Reports Page
        $path = $request->getPath();
        
        // Treat '/reports' as an Admin area too
        $isAdmin = (strpos($path, '/admins') === 0) || (strpos($path, '/reports') === 0);

        // 2. Define Settings based on the detection
        if ($isAdmin) {
            // ADMIN SETTINGS (Load Admins table, Admin Session)
            $loginUrl = Router::url(['controller' => 'Admins', 'action' => 'login']);
            $userModel = 'Admins';
            $fields = ['username' => 'username', 'password' => 'password'];
            $sessionKey = 'Auth.Admin'; 
        } else {
            // USER SETTINGS (Load Users table, User Session)
            $loginUrl = Router::url(['controller' => 'Users', 'action' => 'login']);
            $userModel = 'Users';
            $fields = ['username' => 'email', 'password' => 'password'];
            $sessionKey = 'Auth.User'; 
        }

        // 3. Create the Service
        $service = new AuthenticationService([
            'unauthenticatedRedirect' => $loginUrl,
            'queryParam' => 'redirect',
        ]);

        // 4. Load Identifiers
        $service->loadIdentifier('Authentication.Password', [
            'fields' => $fields,
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => $userModel,
            ],
        ]);

        // 5. Load Authenticators
        $service->loadAuthenticator('Authentication.Session', [
            'sessionKey' => $sessionKey,
        ]);

        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => $loginUrl,
        ]);

        return $service;
    }

    public function services(ContainerInterface $container): void
    {
    }

    protected function bootstrapCli(): void
    {
        $this->addOptionalPlugin('Bake');
        $this->addPlugin('Migrations');
    }
}