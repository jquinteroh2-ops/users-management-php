<?php

declare(strict_types=1);

final class WebRoutes
{
    /**
     * @return array<string, array<string, string>>
     */
    public static function routes(): array
    {
        return array(
            'home' => array(
                'method' => 'GET',
                'action' => 'home',
            ),
            'users.create' => array(
                'method' => 'GET',
                'action' => 'create',
            ),
            'users.store' => array(
                'method' => 'POST',
                'action' => 'store',
            ),
            'users.index' => array(
                'method' => 'GET',
                'action' => 'index',
            ),
            'users.show' => array(
                'method' => 'GET',
                'action' => 'show',
            ),
            'users.edit' => array(
                'method' => 'GET',
                'action' => 'edit',
            ),
            'users.update' => array(
                'method' => 'POST',
                'action' => 'update',
            ),
            'users.delete' => array(
                'method' => 'POST',
                'action' => 'delete',
            ),
            'auth.login' => array(
                'method' => 'GET',
                'action' => 'login',
            ),
            'auth.authenticate' => array(
                'method' => 'POST',
                'action' => 'authenticate',
            ),
            'auth.logout' => array(
                'method' => 'GET',
                'action' => 'logout',
            ),
            'auth.forgot' => array(
                'method' => 'GET',
                'action' => 'forgot',
            ),
            'auth.forgot.send' => array(
                'method' => 'POST',
                'action' => 'forgot.send',
            ),
            // Ejercicio 25: CRUDL de emisoras (vistas web)
            'emisoras.index' => array(
                'method' => 'GET',
                'action' => 'emisoras.index',
            ),
            'emisoras.create' => array(
                'method' => 'GET',
                'action' => 'emisoras.create',
            ),
            'emisoras.store' => array(
                'method' => 'POST',
                'action' => 'emisoras.store',
            ),
            'emisoras.show' => array(
                'method' => 'GET',
                'action' => 'emisoras.show',
            ),
            'emisoras.edit' => array(
                'method' => 'GET',
                'action' => 'emisoras.edit',
            ),
            'emisoras.update' => array(
                'method' => 'POST',
                'action' => 'emisoras.update',
            ),
            'emisoras.delete' => array(
                'method' => 'POST',
                'action' => 'emisoras.delete',
            ),
            // Ejercicio 25: API REST (JSON) de emisoras
            'api.emisoras.index' => array(
                'method' => 'GET',
                'action' => 'api.emisoras.index',
            ),
            'api.emisoras.show' => array(
                'method' => 'GET',
                'action' => 'api.emisoras.show',
            ),
            'api.emisoras.store' => array(
                'method' => 'POST',
                'action' => 'api.emisoras.store',
            ),
            'api.emisoras.update' => array(
                'method' => 'PUT',
                'action' => 'api.emisoras.update',
            ),
            'api.emisoras.delete' => array(
                'method' => 'DELETE',
                'action' => 'api.emisoras.delete',
            ),
        );
    }
}