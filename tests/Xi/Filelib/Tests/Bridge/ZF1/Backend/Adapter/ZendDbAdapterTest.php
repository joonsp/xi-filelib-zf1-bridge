<?php

namespace Xi\Filelib\Tests\Backend\Adapter;

use Xi\Filelib\Bridge\ZF1\Backend\Adapter\ZendDbBackendAdapter;
use Xi\Filelib\Backend\Adapter\DoctrineDbalBackendAdapter;
use Zend_Db;
use Xi\Filelib\Tests\Backend\Adapter\RelationalDbTestCase;

require_once __DIR__ . '/../../../../../../../../vendor/xi/filelib/tests/Xi/Filelib/Tests/Backend/Adapter/ArrayDataSet.php';
require_once __DIR__ . '/../../../../../../../../vendor/xi/filelib/tests/Xi/Filelib/Tests/PHPUnit/Extensions/Database/Operation/MySQL55Truncate.php';
require_once __DIR__ . '/../../../../../../../../vendor/xi/filelib/tests/Xi/Filelib/Tests/Backend/Adapter/AbstractBackendAdapterTestCase.php';
require_once __DIR__ . '/../../../../../../../../vendor/xi/filelib/tests/Xi/Filelib/Tests/Backend/Adapter/RelationalDbTestCase.php';

/**
 * @group backend
 */
class DoctrineDbalBackendAdapterTest extends RelationalDbTestCase
{

    /**
     * @return ZendDbBackendAdapter
     */
    protected function setUpBackend()
    {
        $db = Zend_Db::factory(
            'Pdo_Mysql',
            [
                'host'     => PDO_HOST,
                'username' => PDO_USERNAME,
                'password' => PDO_PASSWORD,
                'dbname'   => PDO_DBNAME
            ]
        );

        return new ZendDbBackendAdapter($db);
    }

    /**
     * @test
     */
    public function failsWhenPlatformIsNotSupported()
    {
        $this->setExpectedException('RuntimeException');

        $conn = $this->getMockBuilder('Doctrine\DBAL\Connection')->disableOriginalConstructor()->getMock();
        $platform = $this->getMockBuilder('Doctrine\DBAL\Platforms\AbstractPlatform')->getMockForAbstractClass();

        $conn->expects($this->any())->method('getDatabasePlatform')->will($this->returnValue($platform));

        $p = new DoctrineDbalBackendAdapter($conn);
    }
}
