(function(){
    /**
     * Items module.
     */
    var app = angular.module('items', []);

    // Items list directive.
    app.directive('myItems', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/items-list.html',
            controller: 'ItemsController',
            controllerAs: 'itemsCtrl'
        };
    });

    // User's items controller.
    app.controller('ItemsController', function($http, APP_CONFIG) {
        var user   = this;
        user.items = [];

        $http.get(APP_CONFIG.apiItemUrl).success(function(data){
            user.items = data._embedded.items;
        });
    });
})();