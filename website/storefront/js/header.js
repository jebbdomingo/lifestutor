(function(){
    /**
     * Top menu module.
     */
    var app = angular.module('header', []);

    // Top menu directive.
    app.directive('topMenu', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'templates/header.html',
            controller: 'TabController',
            controllerAs: 'tabCtrl'
        };
    });

    // Top menu controller.
    app.controller('TabController', function(APP_CONFIG) {
        this.loginModalId  = APP_CONFIG.loginModalId;
        this.signupModalId = APP_CONFIG.signupModalId;
        this.tabs = [
            {name: 'home', label: 'Home', url: ''},
            {name: 'myitems', label: 'Products', url: '#/products'}
        ];
        this.tab = 'home'; // Active tab.

        this.selectTab = function(tab){
            this.tab = tab;
            
            //$location.url(tab);
        };

        this.isTabSelected = function(selected) {
            return this.tab === selected;
        };
    });

    

    app.controller('PageCtrl', function (/* $scope, $location, $http */) { console.log("Page Controller reporting for duty."); });
})();