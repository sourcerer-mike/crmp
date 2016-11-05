<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
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
     * @Given /^fill in "([^"]*)" with some email$/
     */
    public function fillInWithSomeEmail($field)
    {
        /** @var \Faker\Generator $faker */
        $faker = $this->getContainer()->get('hautelook_alice.faker');

        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument(uniqid('behat').$faker->email);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @Given /I am logged in as "(?P<username>[^"]+)"/
     */
    public function iAmLoggedInAs($username)
    {
        $container = $this->getContainer();
        $session   = $container->get('session');

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
     * @Given /^text for "([^"]*)" should be:$/
     */
    public function textForShouldBe($field, \Behat\Gherkin\Node\PyStringNode $string)
    {
        $this->assertFieldContains($field, $string->getRaw());
    }

    /**
     * @Given /the choice "([^"]*)" should be checked/
     */
    public function theCheckboxForShouldBeSelected($checkboxLabel)
    {
        $field = $this->getSession()->getPage()->findField($checkboxLabel);

        if (! $field->isChecked()) {
            throw new Exception('Checkbox with label '.$checkboxLabel.' is not checked');
        }
    }

    /**
     * Check a select and option pair by label.
     *
     * @Given /^the "([^"]*)" option is set to "([^"]*)"$/
     */
    public function theOptionFromShouldBeSelected($select, $option)
    {
        $selectField = $this->getSession()->getPage()->findField($select);
        if (null === $selectField) {
            throw new ElementNotFoundException($this->getSession(), 'select field', 'id|name|label|value', $select);
        }

        $optionField = $selectField->find(
            'named',
            array(
                'option',
                $option,
            )
        );

        if (null === $optionField) {
            throw new ElementNotFoundException(
                $this->getSession(),
                'select option field',
                'id|name|label|value',
                $option
            );
        }

        if (! $optionField->isSelected()) {
            throw new ExpectationException(
                'Select option field with value|text "'.$option.'" is not selected in the select "'.$select.'"',
                $this->getSession()
            );
        }
    }
}
