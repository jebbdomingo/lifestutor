(function(){
    var app = angular.module('app.Auth', ['app.Session']);

    /**
     * Login Directive.
     */
    app.directive('myLogin', function(APP_CONFIG, AUTH_EVENTS){
        return {
            restrict: 'E',
            scope: { currentUser: '=currentuser' },
            templateUrl: APP_CONFIG.baseUrl + 'partials/login.html',
            controller: 'LoginController',
            controllerAs: 'loginCtrl',
            link: function (scope) {
                var showDialog = function () {
                    $(APP_CONFIG.loginModalId).modal();
                };

                scope.$on(AUTH_EVENTS.notAuthenticated, showDialog);
                scope.$on(AUTH_EVENTS.sessionTimeout, showDialog);
            }
        };
    });
    app.controller('LoginController', function($scope, $rootScope, APP_CONFIG, AUTH_EVENTS, AuthService){
        this.credentials = {
            username: '',
            password: ''
        };

        var login = this;
        login.formError = '';

        this.login = function(credentials){
            AuthService.login(credentials).then(function(user) {
                $scope.currentUser = user;
                $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
                $(APP_CONFIG.loginModalId).modal('hide');
            }, function(resource) {
                login.formError = resource.data.error_description;
                $rootScope.$broadcast(AUTH_EVENTS.loginFailed)
            });
        };
    });

    /**
     * Logout Directive.
     */
    app.directive('myLogout', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: { currentUser: '=currentuser' },
            templateUrl: APP_CONFIG.baseUrl + 'partials/logout.html',
            controller: 'LogoutController',
            controllerAs: 'logoutCtrl'
        };
    });
    app.controller('LogoutController', function($scope, $rootScope, Session, AUTH_EVENTS){
        this.logout = function(){
            $rootScope.$broadcast(AUTH_EVENTS.logoutSuccess);
            Session.destroy();

            // Reset main app controller > current user.
            $scope.currentUser = {};

            // TODO: implment AuthService.logout
            // AuthService.logout(token)
        };

        this.logout();
    });

    /**
     * Authentication Service.
     */
    app.factory('AuthService', function($http, APP_CONFIG, OAUTH_CREDENTIALS, Session, Api){
        var authService = {};

        authService.login = function (credentials) {
            credentials.grant_type    = OAUTH_CREDENTIALS.oAuthGrantType;
            credentials.client_id     = OAUTH_CREDENTIALS.oAuthClientId;
            credentials.client_secret = OAUTH_CREDENTIALS.oAuthClientSecret;

            // Call get_user API to fetch user details by token.
            var fetchUserCallback = function(resource){
                token = resource.data.access_token;
                
                Session.setToken(token);
                Api.init(token);

                return $http.get(APP_CONFIG.apiLoggedInUserUrl).then(function (resource){
                    Session.setCurrentUser(resource.data.user);
                    return Session.getCurrentUser();
                });
            }

            // Post client credentials to obtain an access token.
            return $http.post(OAUTH_CREDENTIALS.oAuthUrl, credentials).then(fetchUserCallback);
        };

        // TODO: implement token revocation.
        // authService.logout

        authService.isAuthenticated = function () {
            var result = !!Session.getToken();
            console.log("Is Authenticated: " + result);

            // In case of browser refresh re-initiliaze API to append the token on each HTTP request.
            if (result) {
                Api.init(Session.getToken());
            }

            return result;
        };

        authService.isAuthorized = function (authorizedRoles) {
            if (!angular.isArray(authorizedRoles)) {
                authorizedRoles = [authorizedRoles];
            }

            return (authService.isAuthenticated() && function(){
                $.each(authorizedRoles, function(index, role){
                    return $.inArray(role, Session.getCurrentUser().roles);
                });
            } !== -1);
        };

        return authService;
    });
})();