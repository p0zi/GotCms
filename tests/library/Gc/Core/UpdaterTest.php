<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  Library
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Gc\Core;

use Gc\View\Stream;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:11.
 *
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class UpdaterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Execute scripts file
     *
     * @var string
     */
    protected $fileName;

    /**
     * @var Updater
     *
     * @return void
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object   = new Updater;
        $this->fileName = GC_APPLICATION_PATH . '/tests/library/Gc/Core/_files/test.php';
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::init
     * @covers Gc\Version::getLatest
     *
     * @return void
     */
    public function testInit()
    {
        $this->assertNull($this->object->init());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::load
     *
     * @return void
     */
    public function testLoad()
    {
        $this->assertTrue($this->object->load('git'));
        $this->assertFalse($this->object->load('ssh'));
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::update
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->object->load('git');
        $this->assertTrue($this->object->update());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::update
     *
     * @return void
     */
    public function testUpdateWithoutAdapter()
    {
        $this->assertFalse($this->object->update());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::upgrade
     *
     * @return void
     */
    public function testUpgrade()
    {
        $this->object->load('git');
        $this->assertTrue($this->object->upgrade());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::rollback
     *
     * @return void
     */
    public function testRollback()
    {
        $this->object->load('git');
        $this->assertTrue($this->object->rollback('version'));
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::rollback
     *
     * @return void
     */
    public function testRollbackWithoutAdapter()
    {
        $this->assertFalse($this->object->rollback('version'));
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::upgrade
     *
     * @return void
     */
    public function testUpgradeWithoutAdapter()
    {
        $this->assertFalse($this->object->upgrade());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::updateDatabase
     *
     * @return void
     */
    public function testUpdateDatabase()
    {
        Stream::register();

        file_put_contents(
            'zend.view://test-updater',
            'INSERT INTO core_config_data (identifier, value) VALUES (1, 1);' .
            'INSERT INTO core_config_data (identifier, value) VALUES (2, 2);'
        );
        $this->object->load('git');
        $this->assertTrue($this->object->updateDatabase());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::updateDatabase
     *
     * @return void
     */
    public function testUpdateDatabaseWithEmptyFiles()
    {
        Stream::register();
        file_put_contents('zend.view://test-updater', ' ');

        $this->object->load('git');
        $this->assertTrue($this->object->updateDatabase());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::updateDatabase
     *
     * @return void
     */
    public function testUpdateDatabaseWithSqlError()
    {
        Stream::register();
        file_put_contents('zend.view://test-updater', 'SELECT FROM core_config_data');

        $this->object->load('git');
        $this->assertFalse($this->object->updateDatabase());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::updateDatabase
     *
     * @return void
     */
    public function testUpdateDatabaseWithoutAdapter()
    {
        $this->assertFalse($this->object->updateDatabase());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::getMessages
     *
     * @return void
     */
    public function testGetMessages()
    {
        $this->object->load('git');
        $this->assertInternalType('array', $this->object->getMessages());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::executeScripts
     *
     * @return void
     */
    public function testExecuteScriptsWithoutAdapter()
    {
        $this->assertFalse($this->object->executeScripts());
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::executeScripts
     *
     * @return void
     */
    public function testExecuteScriptsWithEmptyFiles()
    {
        file_put_contents($this->fileName, '');
        $this->object->load('git');
        $this->assertTrue($this->object->executeScripts());
        unlink($this->fileName);
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::executeScripts
     *
     * @return void
     */
    public function testExecuteScriptsWithError()
    {
        file_put_contents($this->fileName, '<?php echo $test->test;');
        $this->object->load('git');
        $this->assertTrue($this->object->executeScripts());
        unlink($this->fileName);
    }

    /**
     * Test
     *
     * @covers Gc\Core\Updater::executeScripts
     *
     * @return void
     */
    public function testExecuteScripts()
    {
        file_put_contents($this->fileName, '<?php echo "test";');
        $this->object->load('git');
        $this->assertTrue($this->object->executeScripts());
        unlink($this->fileName);
    }
}
