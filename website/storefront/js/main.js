(function(){
    /**
     * Main app module.
     */
    var app = angular.module('app', ['app.Config', 'app.Http', 'app.Auth', 'app.User', 'header', 'items', 'catalogs', 'ui.router']);

    /**
     * Application Directive.
     */
    app.directive('myApp', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'templates/main.html',
            controller: 'ApplicationController',
            controllerAs: 'appCtrl'
        };
    });
    app.controller('ApplicationController', function(USER_ROLES, AuthService, Session){
        this.currentUser  = Session.getCurrentUser();
        this.userRoles    = USER_ROLES;
        this.isAuthorized = AuthService.isAuthorized;
    });

    // Run.
    app.run(function ($rootScope, AUTH_EVENTS, AuthService) {
        $rootScope.$on('$stateChangeStart', function (event, next) {
            var authorizedRoles = next.data.authorizedRoles;

            if (authorizedRoles !== null && !AuthService.isAuthorized(authorizedRoles)) {
                event.preventDefault();

                if (AuthService.isAuthenticated()) {
                    // User is not allowed.
                    $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
                } else {
                    // User is not logged in.
                    $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
                }
            }
        });
    });
})();