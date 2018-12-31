<?php

namespace AvoRed\Framework\AdminMenu;

use Illuminate\Support\ServiceProvider;
use AvoRed\Framework\AdminMenu\Facade as AdminMenuFacade;

class AdminMenuProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->registerAdminMenu();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
        $this->app->alias('adminmenu', 'AvoRed\Framework\AdminMenu\Builder');
    }

    /**
     * Register the Admin Menu instance.
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->singleton('adminmenu', function () {
            return new Builder();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['adminmenu', 'AvoRed\Framework\AdminMenu\Builder'];
    }

    /**
     * Register the Menus.
     *
     * @return void
     */
    protected function registerAdminMenu()
    {
        AdminMenuFacade::add('subscriptions', function (AdminMenu $systemMenu) {
            $systemMenu->label('Subscriptions')->route('#')->icon('ti-user');
        });

        AdminMenuFacade::add('user', function (AdminMenu $menu) {
            $menu->label('Customers')->route('#')->icon('ti-user');
        });

        AdminMenuFacade::add('distributionCenters', function (AdminMenu $menu) {
            $menu->label('Distribution Centers')->route('#')->icon('ti-truck');
        });

        AdminMenuFacade::add('system', function (AdminMenu $systemMenu) {
            $systemMenu->label('Settings')->route('#')->icon('ti-settings');
        });

        $distributionCentersMenu = AdminMenuFacade::get('distributionCenters');
        $distributionCentersMenu->subMenu('distributionCenter', function (AdminMenu $menu) {
            $menu->key('list')->label('Overview')->route('admin.user.index');
        });

        $userMenu = AdminMenuFacade::get('user');

        $userMenu->subMenu('user', function (AdminMenu $menu) {
            $menu->key('user')->label('Overview')->route('admin.user.index');
        });
        $userMenu->subMenu('user_group', function (AdminMenu $menu) {
            $menu->key('user_group')->label('Customers Groups')->route('admin.user-group.index');
        });

        $systemMenu = AdminMenuFacade::get('system');

        $systemMenu->subMenu('configuration', function (AdminMenu $menu) {
            $menu->key('configuration')->label('Configuration')->route('admin.configuration')->icon('ti-settings');
        });

        $systemMenu->subMenu('admin-user', function (AdminMenu $menu) {
            $menu->key('admin-user')->label('Staff')->route('admin.admin-user.index');
        });

        $systemMenu->subMenu('role', function (AdminMenu $menu) {
            $menu->key('role')->label('Roles/Permissions')->route('admin.role.index');
        });

        $systemMenu->subMenu('themes', function (AdminMenu $menu) {
            $menu->key('themes')->label('Themes')->route('admin.theme.index');
        });

    }
}
