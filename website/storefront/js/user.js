(function(){
    var app = angular.module('app.User', ['app.Session']);

    /**
     * Signup Directive.
     */
    app.directive('mySignup', function(SOCIAP_CONFIG, AUTH_EVENTS){
        return {
            restrict: 'E',
            scope: { currentUser: '=currentuser' },
            templateUrl: SOCIAP_CONFIG.baseUrl + 'partials/signup.html',
            controller: 'SignupController',
            controllerAs: 'signupCtrl'
        };
    });
    app.controller('SignupController', function($scope, $rootScope, $http, SOCIAP_CONFIG, AUTH_EVENTS, AuthService){
        this.credentials = {
            username: '',
            password: '',
            firstname: '',
            lastname: ''
        };

        var signup = this;
        signup.formError = '';

        var successSignupCallback = function(resource) {
            $(SOCIAP_CONFIG.signupModalId).modal('hide');
            console.log('Successfull signup');
            console.log(resource);

            // Reset credentials to support succeeding sign up/sign-in
            var credentials = {
                username: signup.credentials.username,
                password: signup.credentials.password
            };

            // On successfull sign-up, automatically log-in the user.
            AuthService.login(credentials).then(function(user) {
                $scope.currentUser = user;
                $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
                $(SOCIAP_CONFIG.signupModalId).modal('hide');
            }, function(resource) {
                console.log('Signup > Login Failed');
                console.log(resource);

                signup.formError = resource.data.error_description;
                $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
            });
        };

        var failedSignupCallback = function(resource) {
            console.log(resource);
            $.each(resource.data.errors.children, function (field, obj) {
                if (typeof obj.errors !== 'undefined') {
                    switch (field) {
                        case 'username':
                            if (obj.errors[0] == 'This value is already used.')
                                signup.formError = "The email address is already taken.";
                            else
                                signup.formError = "Email address is required.";
                            break;
                        case 'password':
                            signup.formError = "Password is required.";
                            break;
                        case 'firstname':
                            signup.formError = "First name is required.";
                            break;
                    }
                }
            });
        };

        this.signup = function(credentials) {
            console.log(credentials);
            return $http.post(SOCIAP_CONFIG.apiUserSignupUrl, credentials).then(successSignupCallback, failedSignupCallback);
        };
    });
})();