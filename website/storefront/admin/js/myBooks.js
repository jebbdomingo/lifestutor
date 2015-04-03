(function(){
    /**
     * Books module.
     */
    var app = angular.module('app.Books', []);

    // Books list directive.
    app.directive('myBooks', function(APP_CONFIG){
        console.log(APP_CONFIG.baseUrl + 'partials/myBooks.html');
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/myBooks.html',
            controller: 'BooksController',
            controllerAs: 'booksCtrl'
        };
    });

    // User's items controller.
    app.controller('BooksController', function($http, APP_CONFIG) {
        var user   = this;
        user.items = [];

        $http.get(APP_CONFIG.apiBookUrl).success(function(data){
            user.items = data._embedded.items;
        });
    });
})();