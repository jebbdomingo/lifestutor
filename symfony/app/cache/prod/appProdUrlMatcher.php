<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/api/v1')) {
            // api_1_items
            if (preg_match('#^/api/v1/(?P<id>[^/]++)/items(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'PATCH') {
                    $allow[] = 'PATCH';
                    goto not_api_1_items;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_1_items')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::itemsAction',  '_format' => NULL,));
            }
            not_api_1_items:

            // api_1_get_user
            if (0 === strpos($pathinfo, '/api/v1/users') && preg_match('#^/api/v1/users/(?P<id>[^/\\.]++)(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_api_1_get_user;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_1_get_user')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::getUserAction',  '_format' => NULL,));
            }
            not_api_1_get_user:

            // api_1_get_loggedinuser
            if (0 === strpos($pathinfo, '/api/v1/loggedinuser') && preg_match('#^/api/v1/loggedinuser(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_api_1_get_loggedinuser;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_1_get_loggedinuser')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::getLoggedinuserAction',  '_format' => NULL,));
            }
            not_api_1_get_loggedinuser:

            if (0 === strpos($pathinfo, '/api/v1/users')) {
                // api_1_post_user
                if (preg_match('#^/api/v1/users(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_1_post_user;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_1_post_user')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::postUserAction',  '_format' => NULL,));
                }
                not_api_1_post_user:

                // api_1_options_users
                if (preg_match('#^/api/v1/users(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'OPTIONS') {
                        $allow[] = 'OPTIONS';
                        goto not_api_1_options_users;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_1_options_users')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::optionsUsersAction',  '_format' => NULL,));
                }
                not_api_1_options_users:

            }

            // api_1_options_loggedinuser
            if (0 === strpos($pathinfo, '/api/v1/loggedinuser') && preg_match('#^/api/v1/loggedinuser(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'OPTIONS') {
                    $allow[] = 'OPTIONS';
                    goto not_api_1_options_loggedinuser;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_1_options_loggedinuser')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::optionsLoggedinuserAction',  '_format' => NULL,));
            }
            not_api_1_options_loggedinuser:

            if (0 === strpos($pathinfo, '/api/v1/shops')) {
                // lifestutor_store_shop_all
                if (preg_match('#^/api/v1/shops(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_lifestutor_store_shop_all;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'lifestutor_store_shop_all')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\ShopController::allAction',  '_format' => NULL,));
                }
                not_lifestutor_store_shop_all:

                // lifestutor_store_shop_options
                if (preg_match('#^/api/v1/shops(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'OPTIONS') {
                        $allow[] = 'OPTIONS';
                        goto not_lifestutor_store_shop_options;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'lifestutor_store_shop_options')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\ShopController::optionsAction',  '_format' => NULL,));
                }
                not_lifestutor_store_shop_options:

            }

            if (0 === strpos($pathinfo, '/api/v1/items')) {
                // lifestutor_store_item_all
                if (preg_match('#^/api/v1/items(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_lifestutor_store_item_all;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'lifestutor_store_item_all')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UseritemController::allAction',  '_format' => NULL,));
                }
                not_lifestutor_store_item_all:

                // lifestutor_store_item_options
                if (preg_match('#^/api/v1/items(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'OPTIONS') {
                        $allow[] = 'OPTIONS';
                        goto not_lifestutor_store_item_options;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'lifestutor_store_item_options')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UseritemController::optionsAction',  '_format' => NULL,));
                }
                not_lifestutor_store_item_options:

            }

            // lifestutor_store_user_items_all
            if (0 === strpos($pathinfo, '/api/v1/user') && preg_match('#^/api/v1/user/(?P<id>[^/]++)/items(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_lifestutor_store_user_items_all;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'lifestutor_store_user_items_all')), array (  '_controller' => 'Lifestutor\\StoreBundle\\Controller\\UserController::itemsAction',  '_format' => NULL,));
            }
            not_lifestutor_store_user_items_all:

        }

        if (0 === strpos($pathinfo, '/oauth')) {
            if (0 === strpos($pathinfo, '/oauthserver/v1/signups')) {
                // oauthserver_1_post_signup
                if (preg_match('#^/oauthserver/v1/signups(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_oauthserver_1_post_signup;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'oauthserver_1_post_signup')), array (  '_controller' => 'Lifestutor\\OAuthServerBundle\\Controller\\SignupController::postSignupAction',  '_format' => NULL,));
                }
                not_oauthserver_1_post_signup:

                // oauthserver_1_options_signups
                if (preg_match('#^/oauthserver/v1/signups(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'OPTIONS') {
                        $allow[] = 'OPTIONS';
                        goto not_oauthserver_1_options_signups;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'oauthserver_1_options_signups')), array (  '_controller' => 'Lifestutor\\OAuthServerBundle\\Controller\\SignupController::optionsSignupsAction',  '_format' => NULL,));
                }
                not_oauthserver_1_options_signups:

            }

            if (0 === strpos($pathinfo, '/oauth/v2')) {
                if (0 === strpos($pathinfo, '/oauth/v2/token')) {
                    // fos_oauth_server_token
                    if ($pathinfo === '/oauth/v2/token') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_fos_oauth_server_token;
                        }

                        return array (  '_controller' => 'fos_oauth_server.controller.token:tokenAction',  '_route' => 'fos_oauth_server_token',);
                    }
                    not_fos_oauth_server_token:

                    // fos_oauth_server_token_options
                    if ($pathinfo === '/oauth/v2/token') {
                        if ($this->context->getMethod() != 'OPTIONS') {
                            $allow[] = 'OPTIONS';
                            goto not_fos_oauth_server_token_options;
                        }

                        return array (  '_controller' => 'fos_oauth_server.controller.token:tokenoptionsAction',  '_route' => 'fos_oauth_server_token_options',);
                    }
                    not_fos_oauth_server_token_options:

                }

                // fos_oauth_server_authorize
                if ($pathinfo === '/oauth/v2/auth') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_oauth_server_authorize;
                    }

                    return array (  '_controller' => 'FOS\\OAuthServerBundle\\Controller\\AuthorizeController::authorizeAction',  '_route' => 'fos_oauth_server_authorize',);
                }
                not_fos_oauth_server_authorize:

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
