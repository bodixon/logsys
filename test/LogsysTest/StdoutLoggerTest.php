<?php
/**
 * @todo
 */
namespace LogsysTest;

use Logsys\StdoutLogger;

class StdoutLoggerTest extends \PHPUnit_Framework_TestCase {
    public function testWrite() {
        $log = new StdoutLogger(array(
            'format' => "{{call|sprintf('test')}}-{{message}}"
        ));
        ob_start();
        $log->write('test');
        $line = ob_get_clean();

        $this->assertEquals('test-test'.PHP_EOL, $line);
    }
}