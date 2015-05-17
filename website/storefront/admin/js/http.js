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
        var dashboard = {
            name: 'dashboard',
            url: '',
            templateUrl: APP_CONFIG.baseUrl + "templates/dashboard.html",
            data: {
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };

        var books = {
            name: 'books',
            url: '/books',
            templateUrl: APP_CONFIG.baseUrl + "templates/book/books.html",
            data: {
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };

        var bookForm = {
            name: 'book_form',
            url: '/book_form',
            templateUrl: APP_CONFIG.baseUrl + "templates/book/form.html",
            data: {
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };

        var bookEditForm = {
            name: 'book_edit_form',
            url: '/book_form/:id',
            templateUrl: APP_CONFIG.baseUrl + "templates/book/edit_form.html",
            data: {
                    authorizedRoles: [USER_ROLES.member, USER_ROLES.admin]
                  }
        };

        $stateProvider.state(dashboard);
        $stateProvider.state(books);
        $stateProvider.state(bookForm);
        $stateProvider.state(bookEditForm);
    });

    /**
     * Append access token for every request.
     */
    app.run(['Api', function(Api) {
        Api.init();
    }]);
})();