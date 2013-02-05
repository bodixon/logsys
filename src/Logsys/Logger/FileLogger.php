<?php

namespace Logsys;

class FileLogger extends StdoutLogger {

    protected $file_path;
    
    public function __construct($options) {
        if (!$options['file_path']) {
            throw new Exception(__CLASS__ . "::__construct(): 'file_path' is empty");
        }
        $this->file_path = $options['file_path'];
        parent::__construct($options);
    }
    
    /**
     * @see AbstractLogger::write()
     */
    public function write($data) {
        ob_start();
        parent::write($data);
        $log_line = ob_get_clean();
        
        return (bool) file_put_contents($this->file_path, $log_line, FILE_APPEND);
    }
}