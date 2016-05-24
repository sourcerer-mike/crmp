<?php

namespace Crmp\CrmBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

class AuthTestCase extends WebTestCase
{
    protected function assertResponseOkay(Client $client)
    {
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), $response->getStatusCode().' '.$client->getRequest()->getUri());
    }

    /**
     * @param string $route
     * @param array  $parameters
     */
    public function assertAvailableForUsers($route, $parameters = [])
    {
        $client = $this->createAuthClient('GET', $route, $parameters);

        $this->assertResponseOkay($client);
    }

    protected function createAuthClient($request = 'GET', $route = '', $parameters = [])
    {
        $client = $this->createAuthorizedUserClient();

        if ($route) {
            $uri = $client->getContainer()->get('router')->generate($route, $parameters);

            $client->request($request, $uri);
        }

        return $client;
    }

    protected function createAuthorizedUserClient($method = 'GET', $route = '', $parameters = [])
    {
        $client = $this->createAuthorizedClient('Mike');

        if ($method && $route) {
            $uri = $client->getContainer()->get('router')->generate($route, $parameters);

            $client->request($method, $uri);
        }

        return $client;
    }

    protected function createAuthorizedClient($username)
    {
        $client    = static::createClient();
        $container = $client->getContainer();

        $session = $container->get('session');

        /** @var $userManager \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $container->get('fos_user.user_manager');

        /** @var $loginManager \FOS\UserBundle\Security\LoginManager */
        $loginManager = $container->get('fos_user.security.login_manager');
        $firewallName = $container->getParameter('fos_user.firewall_name');

        $user = $userManager->findUserBy(array('username' => $username));
        $loginManager->loginUser($firewallName, $user);

        // save the login token into the session and put it in a cookie
        $container->get('session')->set(
            '_security_'.$firewallName,
            serialize($container->get('security.token_storage')->getToken())
        );
        $container->get('session')->save();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }
}