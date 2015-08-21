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
    app.controller('ItemsController', function($http, $location, APP_CONFIG) {
        var $this      = this;
        var $catalogId = $location.search().catalog;
        var $url       = null;

        $this.items = [];

        console.log($catalogId);

        if ($catalogId) {
            $url = APP_CONFIG.apiStoreCatalogItemsUrl + '/' + $catalogId;
        } else {
            $url = APP_CONFIG.apiStoreItemsUrl;
        }

        $http.get($url).success(function(data){
            $this.items = data._embedded.items;
        });

        this.getCatalogItems = function(catalogId) {
            console.log(catalogId);
            //var path = $location.path('/products/123');
            var path = $location.search('catalog', catalogId);
            
            var $url = APP_CONFIG.apiStoreCatalogItemsUrl + '/' + catalogId;

            $http.get($url).success(function(data){
                $this.items = data._embedded.items;
            });
        };
    });
})();