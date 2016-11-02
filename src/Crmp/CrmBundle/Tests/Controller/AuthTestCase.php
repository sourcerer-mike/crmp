<?php

namespace Crmp\CrmBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthTestCase extends WebTestCase
{
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

    protected function assertResponseOkay(Client $client)
    {
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), $response->getStatusCode().' '.$client->getRequest()->getUri());
    }

    protected function assertTranslationsFound(Client $client)
    {
        $this->assertInstanceOf(Client::class, $client);

        $translationDataCollector = $client->getContainer()->get('data_collector.translation');
        $this->assertEquals(
            0,
            (int) $translationDataCollector->getCountMissings(),
            'Missing translations on '.$client->getRequest()->getUri()
        );
    }

    protected function assertRoute(Client $client, $route, $routeParameters = [])
    {
        $uri = $client->getContainer()->get('router')->generate($route, $routeParameters);

        $this->assertContains($uri, $client->getRequest()->getUri());
    }

    protected function getRandomEntity($alias)
    {
        $client        = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $query  = $entityManager->getRepository($alias)->createQueryBuilder($alias);
        $result = $query->getQuery()->setMaxResults(5)->getResult();
        $key    = array_rand($result, 1);

        return $result[$key];
    }
}
