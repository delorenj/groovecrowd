<?php

namespace GC\UserBundle;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest()) {
            // Handle XHR here
        } else {
            // If the user tried to access a protected resource and was forced to login
            // redirect him back to that resource
            if ($targetPath = $request->getSession()->get('_security.target_path')) {
                $url = $targetPath;
            } else {
                // Otherwise, redirect him to wherever you want
                $url = $this->router->generate('dashboard_index');              
                // $url = $this->router->generate('dashboard_index', array(
                //     'username' => $token->getUser()->getUsername()
                // ));
            }

            return new RedirectResponse($url);
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            // Handle XHR here
        } else {
            // Create a flash message with the authentication error message
            $request->getSession()->setFlash('error', $exception->getMessage());
            $url = $this->router->generate('fos_user_security_login');

            return new RedirectResponse($url);
        }
    }
}