<?php
namespace Gc\Component;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:09.
 */
class TabsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Tabs
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new Tabs(array());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->_object);
    }

    /**
     * @covers Gc\Component\Tabs::render
     */
    public function testRenderWithParams()
    {
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->render(array('string')));
    }

    /**
     * @covers Gc\Component\Tabs::render
     */
    public function testRenderWithoutParams()
    {
        $this->_object->setData(array('string'));
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->render());
    }

    /**
     * @covers Gc\Component\Tabs::__toString
     */
    public function test__toStringWithEmptyData()
    {
        $this->_object->setData(array());
        $this->assertFalse($this->_object->__toString());
    }

    /**
     * @covers Gc\Component\Tabs::__toString
     */
    public function test__toStringWithoutEmptyData()
    {
        $this->_object->setData(array('string'));
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->__toString());
    }
}
