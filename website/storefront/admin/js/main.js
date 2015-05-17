(function(){
    /**
     * Main app module.
     */
    var app = angular.module('app', ['app.Config', 'app.Http', 'app.Auth', 'ui.router', 'app.Books', 'flow']);

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

        if (!AuthService.isAuthenticated()) {
            location.assign("/");
        }
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

    app.config(['flowFactoryProvider', function (flowFactoryProvider) {
        flowFactoryProvider.defaults = {
            permanentErrors: [404, 500, 501],
            maxChunkRetries: 1,
            chunkRetryInterval: 5000,
            simultaneousUploads: 4
        };

        flowFactoryProvider.on('catchAll', function (event) {
            console.log('catchAll', arguments);
        });
        // Can be used with different implementations of Flow.js
        // flowFactoryProvider.factory = fustyFlowFactory;
    }]);
})();