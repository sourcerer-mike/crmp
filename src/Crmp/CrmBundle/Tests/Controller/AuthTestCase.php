<?php

namespace Crmp\CrmBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

class AuthTestCase extends WebTestCase
{
    /**
     * @param string $route
     * @param array  $parameters
     */
    public function assertAvailableForUsers($route, $parameters = [])
    {
        $client = $this->createAuthorizedUserClient();
        $uri    = $client->getContainer()->get('router')->generate($route, $parameters);

        $client->request('GET', $uri);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), $response->getStatusCode().' '.$uri);
    }

    protected function createAuthorizedUserClient()
    {
        return $this->createAuthorizedClient('Mike');
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