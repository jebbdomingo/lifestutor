(function(){
    var baseurl = $('#baseUrl').val();

    /**
     * Application config module.
     */
    var app = angular.module('app.Config', []);

    /**
     * Application Config.
     */
    app.constant('APP_CONFIG', {
        apiUserUrl:             'http://lifestutor.local:8083/api/v1/users',
        apiCatalogsUrl:         'http://lifestutor.local:8083/api/v1/storefront/catalogs',
        apiItemUrl:             'http://lifestutor.local:8083/api/v1/items',
        apiShopUrl:             'http://lifestutor.local:8083/api/v1/shops',
        apiUserSignupUrl:       'http://lifestutor.local:8083/oauthserver/v1/signups',
        apiLoggedInUserUrl:     'http://lifestutor.local:8083/api/v1/loggedinuser',
        loginModalId:           '#loginModal',
        signupModalId:          '#signupModal',
        apiBookUrl:             'http://lifestutor.local:8083/api/v1/books',
        apiCatalogItemsUrl:     'http://lifestutor.local:8083/api/v1/catalog-items',
        photoPathUrl:           'http://lifestutor.local:8083/photo',
        apiBooksDeletePhotoUrl: 'http://lifestutor.local:8083/api/v1/books/delete/photo',
        //apiBookUploadUrl:     'http://lifestutor.local:8083/api/v1/books/upload',
        baseUrl:                baseurl
    });    

    /**
     * Authentication Events.
     */
    app.constant('AUTH_EVENTS', {
        loginSuccess:     'auth-login-success',
        loginFailed:      'auth-login-failed',
        logoutSuccess:    'auth-logout-success',
        sessionTimeout:   'auth-session-timeout',
        notAuthenticated: 'auth-not-authenticated',
        notAuthorized:    'auth-not-authorized'
    });

    /**
     * User Roles
     */
    app.constant('USER_ROLES', {
        all:    '*',
        admin:  'ROLE_ADMIN',
        member: 'ROLE_USER',
        guest:  'ROLE_GUEST'
    });

    /**
     * oAuth credentials
     */
    app.constant('OAUTH_CREDENTIALS', {
        oAuthUrl:          'http://lifestutor.local:8083/oauth/v2/token',
        oAuthGrantType:    'password',
        /*oAuthClientId:     '548acc47d54835e10c8b4567_5x62w5chn00sk8c80oowo044k0ko0404g0kss4gsgk4kock8cs',
        oAuthClientSecret: '2ja6ankanf40w8osgkok04488k0cww08os4cgokcc4k4o0go0o'*/
        oAuthClientId:     '54e05435d54835b30b8b4567_4dqn5vanivi8g8w0os080ccs0gw0k0ssog8k80ggwo8o0wsw88',
        oAuthClientSecret: '59bldh43o0cookg08so8o04kso08wocwk44cckw4s884wwkwwk'
    });
})();