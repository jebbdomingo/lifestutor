(function(){
    /**
     * Catalogs module.
     */
    var app = angular.module('catalogs', []);

    // Items list directive.
    app.directive('myCatalogs', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/catalogs-list.html',
            controller: 'CatalogsController',
            controllerAs: 'catalogsCtrl'
        };
    });

    // User's items controller.
    app.controller('CatalogsController', function($http, APP_CONFIG) {
        var ctrl      = this;
        ctrl.catalogs = [
            { name: 'No catalog found', published: true }
        ];

        $http.get(APP_CONFIG.apiCatalogsUrl).success(function(data){
            console.log(data);
            ctrl.catalogs = data._embedded.items;
        });
    });
})();