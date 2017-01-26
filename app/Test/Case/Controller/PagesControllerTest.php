<?php
App::uses('PagesController', 'Controller');
App::uses('Home', 'View');

class PagesControllerTest extends ControllerTestCase {
  public function setUp() {
    parent::setUp();
    $PagesController = new PagesController();
    $HomeView = new View($PagesController);
  }

  public function testHomePageContents() {
    $result = $this->testAction('/',
      array('method' => 'get', 'return' => 'contents')
    );

    $this->assertContains('Welcome to your CakePHP application on OpenShift',$result);
  }
}
