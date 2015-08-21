(function(){
    var app = angular.module('app.Session', []);

    /**
     * Session Service.
     */
    app.service('Session', function(){
        if(typeof(Storage) === "undefined") {
            alert('Sorry! No Web Storage support..');
            return false;
        }

        this.currentUser = null;

        this.setToken = function(token){
            localStorage.setItem("token", token);
        };

        this.setCurrentUser = function(user){
            var tmpUser       = {};
            tmpUser.id        = user.id;
            tmpUser.username  = user.username;
            tmpUser.firstname = user.firstname
            tmpUser.lastname  = user.lastname
            tmpUser.roles     = user.roles

            localStorage.setItem('user', JSON.stringify(tmpUser));
        };

        this.destroy = function(){
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.currentUser = null;
        };

        this.getToken = function(){
            return localStorage.getItem('token');
        };

        this.getCurrentUser = function() {
            if (this.currentUser == null) {
                var user = localStorage.getItem('user');

                //this.currentUser = (user !== null) ? JSON.parse(user) : null;
                if (user !== null) {
                    this.currentUser = JSON.parse(user);
                    //console.log('session.js:46 JSON.parse is called');
                } else {
                    this.currentUser = null;
                }
            }

            return this.currentUser;
        };

        return this;
    });
})();