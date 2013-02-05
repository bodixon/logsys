<?php

namespace Logsys;

abstract class AbstractLogger {
    /**
     * Write log
     * @param mixed $data
     * @return bool
     */
    abstract public function write($data);
}