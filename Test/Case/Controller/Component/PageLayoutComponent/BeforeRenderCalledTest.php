<?php
/**
 * PageLayoutComponentBeforeRenderCalledTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('PageLayoutComponent', 'Pages.Controller/Component');

/**
 * PageLayoutComponentBeforeRenderCalledTest
 *
 */
class PageLayoutComponentBeforeRenderCalledTest extends CakeTestCase {

/**
 * Page::getPageWithFrame called once test
 *
 * @return void
 */
	public function testGetPageWithFrameOfPageCalledOnce() {
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$Controller = new Controller($CakeRequest, $CakeResponse);

		// PageLayoutComponent::setMeta でこけるので、スルーさせる
		$mockPageComponent = $this->getMock(
				'PageLayoutComponent',
				['setMeta'],
				[$Controller->Components]
				);
		$mockPageComponent
			->expects($this->exactly(2))
			->method('setMeta')
			->will($this->returnValue(true));

		$mockPage = $this->getMockForModel('Pages.Page', ['getPageWithFrame']);
		$mockPage
			->expects($this->exactly(1))
			->method('getPageWithFrame')
			->will($this->returnValue(true));

		$mockPageComponent->beforeRender($Controller);
		$mockPageComponent->beforeRender($Controller);
	}

}
