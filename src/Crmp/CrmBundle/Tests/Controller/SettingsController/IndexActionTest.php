<?php


namespace Crmp\CrmBundle\Tests\Controller\SettingsController;


use AppBundle\Entity\User;
use Crmp\CoreDomain\Settings\SettingRepositoryInterface;
use Crmp\CrmBundle\Controller\SettingsController;
use Crmp\CrmBundle\CoreDomain\Settings\SettingsRepository;
use Crmp\CrmBundle\Entity\Setting;
use Crmp\CrmBundle\Panels\Settings\General;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Twig\PanelGroup;
use Crmp\CrmBundle\Twig\PanelInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see     SettingsController::indexAction()
 *
 * @package Crmp\CrmBundle\Tests\Controller\SettingsController
 */
class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = SettingsController::class;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SettingsController
     */
    protected $controllerMock;

    /**
     * @var SettingRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $settingsRepositoryMock;

    /**
     * @var PanelGroup
     */
    private $panelsStub;

    public function getMockedMethods()
    {
        $mockedMethods = parent::getMockedMethods();

        $mockedMethods[] = 'getUser';

        return $mockedMethods;
    }


    /**
     * Redirect on submit.
     *
     * The user made a valid submit.
     * When the user presses refresh he would be asked to submit again by the browser.
     * To suppress that a redirect is made.
     *
     */
    public function testItRedirectsOnValidSubmits()
    {
        $panelMock = $this->createPanelMock();

        $this->createFormMock($panelMock, ['isSubmitted' => true, 'isValid' => true]);

        $this->expectRedirectToRoute('crmp_crm_settings');

        $this->controllerMock->indexAction(new Request());
    }

    public function testItShowsListOfSettings()
    {
        $this->expectRenderingWith('CrmpCrmBundle:Settings:index.html.twig');

        $this->controllerMock->indexAction(new Request());
    }

    public function testSubmittedSettingsWillBeStored()
    {
        $panelMock = $this->createPanelMock();

        // clone expectations to ignore changes made by reference
        $expectedKey   = $key = uniqid();
        $expectedValue = $value = uniqid();

        $expectedSetting = new Setting();
        $expectedSetting->setName($expectedKey);
        $expectedSetting->setValue($expectedValue);
        $expectedSetting->setUser($expectedUser = new User());

        $expectedUser->setEmail(uniqid('a').'@example.org');

        $this->controllerMock->expects($this->once())
                             ->method('getUser')
                             ->willReturn($expectedUser);

        $this->createFormMock(
            $panelMock,
            [
                'isSubmitted' => true,
                'isValid'     => true,
                'getData'     => [
                    $key => $value,
                ],
            ]
        );

        $this->settingsRepositoryMock->expects($this->once())
                                     ->method('add')
                                     ->with($expectedSetting);

        $this->controllerMock->indexAction(new Request([$key => $value]));
    }

    public function testWrongSubmitsLeadBackToList()
    {
        $panelMock = $this->createPanelMock();

        $this->createFormMock($panelMock, ['isSubmitted' => false, 'isValid' => false]);
        $this->createFormMock($panelMock, ['isSubmitted' => false, 'isValid' => true]);
        $this->createFormMock($panelMock, ['isSubmitted' => true, 'isValid' => true]);

        $this->expectRenderingWith('CrmpCrmBundle:Settings:index.html.twig');

        $this->controllerMock->indexAction(new Request());
    }

    /**
     * Set the form in a panel mock.
     *
     * @param $panelMock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createFormMock($panelMock, $methodToReturnValue)
    {
        $formMock = $this->getMockBuilder(Form::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['getData', 'handleRequest', 'isSubmitted', 'isValid'])
                         ->getMock();

        $panelMock->expects($this->once())
                  ->method('getForm')
                  ->willReturn($formMock);

        foreach ($methodToReturnValue as $method => $returnValue) {
            $formMock->expects($this->any())
                     ->method($method)
                     ->willReturn($returnValue);
        }

        return $formMock;
    }

    protected function createPanelMock($class = General::class)
    {
        $panelMock = $this->getMockBuilder($class)
                          ->setMethods(['getForm'])
                          ->getMock();

        /** @var PanelInterface $panelMock */
        $this->panelsStub->add($panelMock);

        return $panelMock;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->panelsStub = new PanelGroup();
        $this->panelsStub->setContainer(new Container());

        $this->settingsRepositoryMock = $this->getMockBuilder(SettingsRepository::class)
                                             ->disableOriginalConstructor()
                                             ->setMethods(['add', 'flush'])
                                             ->getMock();

        $this->mockService('crmp.setting.repository', $this->settingsRepositoryMock);

        $this->mockService('crmp_crm.settings.panels', $this->panelsStub);
    }
}
