<?php
class Enterprise_Log_Firebug extends Zend_Log
{
    protected $_defaultPriority;

    protected $_displayError = false;

    public function __construct($displayError = false)
    {
        $this->_defaultPriority = Zend_Log::DEBUG;
        $this->_displayError = $displayError;

        parent::__construct(new Zend_Log_Writer_Firebug());
    }

    public function getDefaultPriority()
    {
        return $this->_defaultPriority;
    }

    public function setDefaultPriority($priority = Zend_Log::DEBUG)
    {
        if(intval($priority, 10) <= Zend_Log::DEBUG)
        {
            $this->_defaultPriority = intval($priority, 10);
        }
    }

    public function getDisplayError()
    {
        return $this->_displayError;
    }

    public function setDisplayError($displayError = false)
    {
        if(is_bool($displayError)) {
            $this->_displayError = $displayError;
        }
    }

    public function write($message = '')
    {
        if($this->_displayError)
        {
            parent::log($message, $this->_defaultPriority);
        }
    }

    public function log($message, $priority)
    {
        if($this->_displayError)
        {
            if(intval($priority, 10) > Zend_Log::DEBUG)
            {
                $priority = $this->_defaultPriority;
            }

            parent::log($message, $priority);
        }
    }
}