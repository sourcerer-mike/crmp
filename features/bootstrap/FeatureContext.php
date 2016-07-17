<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements SnippetAcceptingContext
{
    use Behat\Symfony2Extension\Context\KernelDictionary;

    /**
     * FeatureContext constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        // $session is your Symfony2 @session
    }

    /**
     * @Given /^I click on "([^"]*)"$/
     */
    public function iClickOn($title)
    {
        $link = $this->fixStepArgument($title);
        $page = $this->getSession()->getPage();

        $link = $page->find('named', array('link_or_button', $title));

        if (null === $link) {
            throw new \DomainException('ElementNotFound '.$title);
        }

        $link->click();
    }

    /**
     * @Given I am logged in as :arg1
     */
    public function iAmLoggedInAs($username)
    {
        $container = $this->getContainer();
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

        $this->getSession()->setCookie($session->getName(), $session->getId());
        $this->getSession()->getDriver()->setCookie($session->getName(), $session->getId());
    }
}
