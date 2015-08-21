(function(){
    /**
     * Catalogs module.
     */
    var app = angular.module('catalogs', []);

    // Items list directive.
    app.directive('myCatalogs', function(APP_CONFIG){
        return {
            restrict: 'E',
            templateUrl: APP_CONFIG.baseUrl + 'partials/catalogs-list.html',
            controller: 'CatalogsController',
            controllerAs: 'catalogsCtrl'
        };
    });

    // User's items controller.
    app.controller('CatalogsController', function($http, APP_CONFIG) {
        var $this      = this;
        $this.catalogs = [];

        $http.get(APP_CONFIG.apiCatalogsUrl).success(function(data){
            $this.catalogs = data._embedded.items;
        });
    });
})();