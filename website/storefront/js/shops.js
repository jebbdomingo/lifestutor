(function(){
    /**
     * Shops module.
     */
    var app = angular.module('shops', []);

    // Shops list directive.
    app.directive('myShops', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/shops-list.html',
            controller: 'UserShopsController',
            controllerAs: 'shopsCtrl'
        };
    });

    // User's shops controller.
    app.controller('UserShopsController', function($http, APP_CONFIG) {
        var user   = this;
        user.shops = [];

        $http.get(APP_CONFIG.apiShopUrl).success(function(data){
            user.shops = data._embedded.shops;
        });
    });
})();