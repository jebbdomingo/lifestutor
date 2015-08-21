(function(){
    var app = angular.module('app.Http', ['ui.router']);

    /**
     * Auth Interceptor.
     */
    app.config(function ($httpProvider) {
        $httpProvider.interceptors.push(['$injector', function ($injector) {
            return $injector.get('AuthInterceptor');
        }]);
    });
    app.factory('AuthInterceptor', function ($rootScope, $q, AUTH_EVENTS) {
        return {
            responseError: function (response) {
                console.log("AuthInterceptor Response: (" + response.status + ")");
                $rootScope.$broadcast({
                    401: AUTH_EVENTS.notAuthenticated,
                    403: AUTH_EVENTS.notAuthorized,
                    419: AUTH_EVENTS.sessionTimeout,
                    440: AUTH_EVENTS.sessionTimeout
                }[response.status], response);
                return $q.reject(response);
            }
        };
    });

    app.factory('Api', function ($http, Session) {
        return {
            init: function (token) {
                if (token) {
                    console.log(token);
                    $http.defaults.headers.common['Authorization'] = "Bearer " + token || Session.getToken();
                } else {
                    console.log('no token ' + token);
                }
            }
        };
    });

    /**
     * Routes
     */
    app.config(function ($stateProvider, APP_CONFIG, USER_ROLES) {
        /*var shops = {
            name: 'myshops',
            url: '/myshops',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-shops.html",
            data: {
                    //authorizedRoles: null //[USER_ROLES.member, USER_ROLES.admin]
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };*/

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

        var home = {
            name: 'home',
            url: '',
            templateUrl: APP_CONFIG.baseUrl + "templates/userhome.html",
            data: {
                    authorizedRoles: null
                  }
        };

        var items = {
            name: 'items',
            url: '/products',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-items.html",
            reloadOnSearch: false,
            data: {
                    authorizedRoles: null //[USER_ROLES.member, USER_ROLES.admin]
                  },
        };

        /*var catalogItems = {
            name: 'catalog_items',
            url: '/products',
            templateUrl: APP_CONFIG.baseUrl + "templates/my-items.html",
            data: {
                    authorizedRoles: null //[USER_ROLES.member, USER_ROLES.admin]
                  },
            reloadOnSearch: false
        };*/

        $stateProvider.state(login);
        $stateProvider.state(logout);
        $stateProvider.state(home);
        $stateProvider.state(items);
        //$stateProvider.state(catalogItems);
        //$stateProvider.state(shops);
    });

    /**
     * Append access token for every request.
     */
    app.run(['Api', function(Api) {
        Api.init();
    }]);
})();