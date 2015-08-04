(function(){
    /**
     * Books module.
     */
    var app = angular.module('app.Books', ['flow']);

    // Books list directive.
    app.directive('myBooks', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/book/myBooks.html',
            controller: 'BooksController',
            controllerAs: 'booksCtrl'
        };
    });

    // Books list controller.
    app.controller('BooksController', function($http, $state, APP_CONFIG) {
        var book   = this;
        book.items = [];

        this.fetchAllBooks = function() {
            $http.get(APP_CONFIG.apiBookUrl).success(function(data){
                book.items = data._embedded.items;
            });
        };

        this.delete = function(id) {
            var book = this;
            return $http.delete(APP_CONFIG.apiBookUrl + '/' + id).then(function(resource) {
                        console.log('Successfully Deleted');
                        console.log(resource);
                        book.fetchAllBooks();
                    }, function(resource) {
                        console.log(resource);
                    });
        };

        this.publish = function(book) {
            var patchInstruction = [
                { "operation": "publish" }
            ];

            return $http({ method: 'PATCH', url: APP_CONFIG.apiBookUrl + '/' + book.id, data: patchInstruction }).then(function(resource) {
                        console.log('Successfully published');
                        console.log(resource);
                        book.published = resource.data.published;
                    }, function(resource) {
                        console.log('Publish failed');
                        console.log(resource);
                    });
        };

        this.unPublish = function(book) {
            var patchInstruction = [
                { "operation": "unpublish" }
            ];

            return $http({ method: 'PATCH', url: APP_CONFIG.apiBookUrl + '/' + book.id, data: patchInstruction }).then(function(resource) {
                        console.log('Successfully un-published');
                        console.log(resource);
                        book.published = resource.data.published;
                    }, function(resource) {
                        console.log('Un-publish failed');
                        console.log(resource);
                    });
        };

        this.fetchAllBooks();
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
    app.controller('BookFormController', function($http, $state, APP_CONFIG) {
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
            $state.go('books');
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

    // Book edit form directive.
    app.directive('myBookEditForm', function(APP_CONFIG){
        return {
            restrict: 'E',
            scope: {},
            templateUrl: APP_CONFIG.baseUrl + 'partials/book/myBookEditForm.html',
            controller: 'BookEditFormController',
            controllerAs: 'bookFormCtrl'
        };
    });

    // Book edit form controller.
    app.controller('BookEditFormController', function($http, $state, $stateParams, APP_CONFIG) {
        var item = this;
        var id   = $stateParams.id;

        item.bookPathUrl = APP_CONFIG.photoPathUrl;
        item.book        = {};
        item.catalogs    = {};

        // Fetch list of catalogs from the server.
        $http.get(APP_CONFIG.apiCatalogsUrl).success(function(data){
            item.catalogs = data._embedded.items;
            console.log('Catalogs');
            console.log(item.catalogs);
        });

        // Fetch the book from server.
        $http.get(APP_CONFIG.apiBookUrl + '/' + id).success(function(data){
            item.book.id           = data.id;
            item.book.name         = data.name;
            item.book.code         = data.code;
            item.book.cost         = data.cost;
            item.book.sellingPrice = data.selling_price;
            item.book.quantity     = data.quantity;
            item.book.rewardPoint  = data.reward_point;
            item.book.catalogs     = data.catalogs;


            // @todo make a better way of creating an array of catalog names out of array of catalog objects.
            /*item.book.catalogs = [];
            $.each(data.catalogs, function(i, catalog){
                item.book.catalogs[i] = catalog.name;
            });*/

            console.log('Selected Catalogs');
            console.log(item.book.catalogs);

            // Fetch book's photos.
            item.loadGallery(data.id);
        });


        var saveBook = this;
        saveBook.formError = '';

        var postSuccessCallback = function(resource) {
            //console.log(resource);
            $state.go('books');
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
            // Remove extra fields that's not needed in saving a book details.
            delete book.photos;

            console.log(book);

            $.each(book.catalogs, function(key, object){
                delete object._links;
                delete object.$$hashKey;
            });

            return $http.put(APP_CONFIG.apiBookUrl, book).then(postSuccessCallback, postFailedCallback);
        };

        this.getId = function() {
            return $stateParams.id;
        };

        this.loadGallery = function(bookId) {
            var book = this;

            $http.get(APP_CONFIG.apiBookUrl + '/' + book.getId()).success(function(data){
                item.book.photos = [];

                angular.forEach(data.book_photos, function(photo) {
                    item.book.photos.push(photo);
                });
            });
        };

        this.deletePhoto = function(idx) {
            var ctrl = this;

            var photoToDelete = ctrl.book.photos[idx];

            return $http.delete(APP_CONFIG.apiBooksDeletePhotoUrl + '/' + photoToDelete.id).then(function(resource) {
                        console.log('Book Photo Successfully Deleted');
                        ctrl.book.photos.splice(idx, 1);
                    }, function(resource) {
                        console.log(resource);
                    });
        };
    });

    /**
     * ng-flow
     * 
     * @param  {Object} flowFactoryProvider) {                   flowFactoryProvider.defaults [description]
     * 
     * @return {[type]}                      [description]
     */
    app.config(['flowFactoryProvider', function (flowFactoryProvider) {
        flowFactoryProvider.defaults = {
            permanentErrors: [404, 500, 501],
            maxChunkRetries: 1,
            chunkRetryInterval: 5000,
            simultaneousUploads: 4
        };

        flowFactoryProvider.on('catchAll', function (event) {
            //console.log('catchAll', arguments);

            /*$.each(arguments, function( index, value ) {
                console.log(value);
            });*/
        });

        // Can be used with different implementations of Flow.js
        // flowFactoryProvider.factory = fustyFlowFactory;
    }]);
})();