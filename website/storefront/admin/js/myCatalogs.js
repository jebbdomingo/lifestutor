(function(){
    /**
     * Catalogs module.
     */
    var app = angular.module('app.Catalogs', []);

    // Catalogs list directive.
    app.directive('myCatalogsSidebar', function(APP_CONFIG){
        return {
            restrict: 'A',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/catalog/myCatalogsSidebar.html',
            controller: 'CatalogsSidebarController',
            controllerAs: 'catalogsCtrl'
        };
    });

    // Catalogs list controller.
    app.controller('CatalogsSidebarController', function($http, $state, APP_CONFIG) {
        var $this        = this;
        $this.catalogs   = [];

        this.fetchAllCatalogs = function() {
            $http.get(APP_CONFIG.apiCatalogsUrl).success(function(data){
                $this.catalogs = data._embedded.items;
            });
        };

        this.fetchAllCatalogs();
    });

    // Catalog items list directive.
    app.directive('myCatalogItems', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/catalog/myCatalogItems.html',
            controller: 'CatalogItemsController',
            controllerAs: 'catalogItemsCtrl'
        };
    });

    // Catalog items list controller.
    app.controller('CatalogItemsController', function($http, $state, $stateParams, APP_CONFIG) {
        var catalogid = $stateParams.catalog_id;
        var $this     = this;

        $this.items = [];

        this.fetchCatalogItems = function() {
            $http.get(APP_CONFIG.apiCatalogItemsUrl + '/' + catalogid).success(function(data){
                $this.items = data._embedded.items;
            });
        };

        // @todo fetch the catalog entity as well

        this.fetchCatalogItems();
    });
})();