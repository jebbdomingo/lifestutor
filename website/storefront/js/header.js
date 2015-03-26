(function(){
    /**
     * Top menu module.
     */
    var app = angular.module('header', ['ui.router']);

    // Top menu directive.
    app.directive('topMenu', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'templates/header.html',
            controller: 'TabController',
            controllerAs: 'tabCtrl'
        };
    });

    // Top menu controller.
    app.controller('TabController', function(APP_CONFIG) {
        this.loginModalId  = APP_CONFIG.loginModalId;
        this.signupModalId = APP_CONFIG.signupModalId;
        this.tabs = [
            {name: 'home', label: 'Home', url: ''},
            {name: 'myitems', label: 'My Items', url: '#/myitems'}
        ];
        this.tab = 'home'; // Active tab.

        this.selectTab = function(tab){
            this.tab = tab;
            
            //$location.url(tab);
        };

        this.isTabSelected = function(selected) {
            return this.tab === selected;
        };
    });

    // Module config.
    app.config(function ($stateProvider, APP_CONFIG, USER_ROLES) {
        var home = {
            name: 'home',
            url: '',
            templateUrl: APP_CONFIG.baseUrl + "templates/userhome.html",
            data: {
                    authorizedRoles: null
                  }
        };

        var items = {
            name: 'myitems',
            url: '/myitems',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-items.html",
            data: {
                    //authorizedRoles: null //[USER_ROLES.member, USER_ROLES.admin]
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };

        var shops = {
            name: 'myshops',
            url: '/myshops',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-shops.html",
            data: {
                    //authorizedRoles: null //[USER_ROLES.member, USER_ROLES.admin]
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };

        var login = {
            name: 'login',
            url: '/login',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-login.html",
            data: {
                    authorizedRoles: null
                  }
        };

        var logout = {
            name: 'logout',
            url: '/logout',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-logout.html",
            data: {
                    authorizedRoles: null
                  }
        };

        $stateProvider.state(home);
        $stateProvider.state(items);
        $stateProvider.state(shops);
        $stateProvider.state(login);
        $stateProvider.state(logout);
    });

    app.controller('PageCtrl', function (/* $scope, $location, $http */) { console.log("Page Controller reporting for duty."); });
})();