(function(){
    var app = angular.module('app.Http', []);

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