(function(){
    /**
     * Books module.
     */
    var app = angular.module('app.Books', []);

    // Books list directive.
    app.directive('myBooks', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/myBooks.html',
            controller: 'BooksController',
            controllerAs: 'booksCtrl'
        };
    });

    // Books list controller.
    app.controller('BooksController', function($http, APP_CONFIG) {
        var book   = this;
        book.items = [];

        $http.get(APP_CONFIG.apiBookUrl).success(function(data){
            book.items = data._embedded.items;
        });
    });

    // Book form directive.
    app.directive('myBookForm', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/book/myBookForm.html',
            controller: 'BookFormController',
            controllerAs: 'bookFormCtrl'
        };
    });

    // Book form controller.
    app.controller('BookFormController', function($http, APP_CONFIG) {
        this.book = {
            name: '',
            code: '',
            cost: '',
            sellingPrice: '',
            quantity: '',
            rewardPoint: ''
        };

        var saveBook = this;
        saveBook.formError = '';

        var postSuccessCallback = function(resource) {
            console.log('Successfull saveBook');
            console.log(resource);
        };

        var postFailedCallback = function(resource) {
            console.log(resource);
            $.each(resource.data.errors.children, function (field, obj) {
                if (typeof obj.errors !== 'undefined') {
                    switch (field) {
                        case 'name':
                            saveBook.formError = "Book's name is required.";
                            break;
                        case 'cost':
                            saveBook.formError = "Cost is required.";
                            break;
                        case 'sellingPrice':
                            saveBook.formError = "Selling Price is required.";
                            break;
                        case 'quantity':
                            saveBook.formError = "Quantity is required.";
                            break;
                    }
                }
            });
        };

        this.saveBook = function(book) {
            console.log(book);
            return $http.post(APP_CONFIG.apiBookUrl, book).then(postSuccessCallback, postFailedCallback);
        };
    });
})();