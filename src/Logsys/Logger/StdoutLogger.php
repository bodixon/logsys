<?php
namespace Fusion;

class StdoutLogger extends AbstractLogger {

    protected $format = null;
    protected $allow_functions = array('date', 'time', 'microtime', 'gethostname', 'basename', 'sprintf');
    protected $allow_functions_regexp;
    protected $default_placeholder = "{{message}}";
    
    const FUNC_PREFIX = 'func';
    
    public function __construct($options = array()) {
        $format = $options['format'] ? $options['format'] : "{{func|date('Y-m-d H:i:s')}}: ". $this->default_placeholder;
        $this->allow_functions_regexp = join("|", $this->allow_functions);
        $this->format = function($data) use ($format) {
            $ret = $format;
        };
    }
    
    /**
     * @see AbstractLogger::write()
     */
    public function write($data) {
        $ret = $this->format;
        
        //Replace functions
        if (preg_match_all("/\{\{". self::FUNC_PREFIX ."\|(". $this->allow_functions_regexp .")([^\}]+)\}\}/i", $ret, $matches)) {
            foreach ($matches[0] as $i => $match) {
                eval('$res=' . $matches[1][$i] . $matches[2][$i] . ';');
                $ret = str_replace($match, $res, $ret);
            }
        }
        
        //Replace fields
        if (is_array($data)) {
            $from = array_map(
                array_keys($data),
                function($val) { return "{{{$val}}}"; }
            );
            $to = array_values($data);
        } else {
            $from = array($this->default_placeholder);
            $to = array($data);
        }
        echo str_replace($from, $to, $ret) . PHP_EOL;
        
        return true;
    }
}