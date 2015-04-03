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
                console.log('http request triggered');
                $http.defaults.headers.common['Authorization'] = "Bearer " + token || Session.getToken();
            }
        };
    });

    /**
     * Routes
     */
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

    /**
     * Append access token for every request.
     */
    app.run(['Api', function(Api) {
        Api.init();
    }]);

    /*app.run(['$http', 'Session', '$injector', function($http, Session,$injector) {
        $injector.get("$http").defaults.transformRequest = [function(data, headersGetter) {
            console.log('http request triggered');
            if (Session.getToken()) {
                //headersGetter()['Authorization'] = "Bearer " + Session.getToken();
                $http.defaults.headers.common['Authorization'] = "Bearer " + Session.getToken();
                console.log($http.defaults.headers.common);
            }

            if (data)
                return angular.toJson(data);
        }].concat($http.defaults.transformRequest);
    }]);*/
})();