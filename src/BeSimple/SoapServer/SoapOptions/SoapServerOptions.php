<?php

namespace BeSimple\SoapServer\SoapOptions;

use Exception;

class SoapServerOptions
{
    const SOAP_SERVER_PERSISTENCE_NONE = 0;
    const SOAP_SERVER_PERSISTENCE_REQUEST = \SOAP_PERSISTENCE_REQUEST;
    const SOAP_SERVER_PERSISTENCE_SESSION = \SOAP_PERSISTENCE_SESSION;
    const SOAP_SERVER_KEEP_ALIVE_ON = true;
    const SOAP_SERVER_KEEP_ALIVE_OFF = false;
    const SOAP_SERVER_ERROR_REPORTING_ON = true;
    const SOAP_SERVER_ERROR_REPORTING_OFF = false;
    const SOAP_SERVER_EXCEPTIONS_ON = true;
    const SOAP_SERVER_EXCEPTIONS_OFF = false;


    private $handlerClass;
    private $handlerObject;
    private $keepAlive;
    private $errorReporting;
    private $exceptions;
    private $persistence;

    /**
     * @param mixed $handlerClassOrObject
     * @param bool $keepAlive = SoapServerOptions::SOAP_SERVER_KEEP_ALIVE_ON|SoapServerOptions::SOAP_SERVER_KEEP_ALIVE_OFF
     * @param bool $errorReporting = SoapServerOptions::SOAP_SERVER_ERROR_REPORTING_ON|SoapServerOptions::SOAP_SERVER_ERROR_REPORTING_OFF
     * @param bool $exceptions = SoapServerOptions::SOAP_SERVER_EXCEPTIONS_ON|SoapServerOptions::SOAP_SERVER_EXCEPTIONS_OFF
     * @param int $persistence = SoapServerOptions::SOAP_SERVER_PERSISTENCE_NONE|SoapServerOptions::SOAP_SERVER_PERSISTENCE_REQUEST|SoapServerOptions::SOAP_SERVER_PERSISTENCE_SESSION
     */
    public function __construct(
        $handlerClassOrObject,
        $keepAlive,
        $errorReporting,
        $exceptions,
        $persistence
    ) {
        $this->handlerClass = $this->resolveHandlerClass($handlerClassOrObject);
        $this->handlerObject = $this->resolveHandlerObject($handlerClassOrObject);
        $this->keepAlive = $keepAlive;
        $this->errorReporting = $errorReporting;
        $this->exceptions = $exceptions;
        $this->persistence = $persistence;
    }

    public function getHandler()
    {
        if ($this->hasHandlerObject() && $this->hasHandlerClass()) {

            throw new Exception('Both HandlerClass and HandlerObject set: please specify only one');
        }
        if ($this->hasHandlerObject()) {

            return $this->getHandlerObject();
        }
        if ($this->hasHandlerClass()) {

            return $this->getHandlerClass();
        }

        throw new Exception('No HandlerClass or HandlerObject set');
    }

    public function getHandlerInstance()
    {
        if ($this->hasHandlerClass()) {
            $handlerClassName = $this->handlerClass;

            return new $handlerClassName;
        }

        return $this->getHandler();
    }

    public function hasHandlerClass()
    {
        return $this->handlerClass !== null;
    }

    public function getHandlerClass()
    {
        return $this->handlerClass;
    }

    public function hasHandlerObject()
    {
        return $this->handlerObject !== null;
    }

    public function getHandlerObject()
    {
        return $this->handlerObject;
    }

    public function hasPersistence()
    {
        return $this->persistence !== self::SOAP_SERVER_PERSISTENCE_NONE;
    }

    public function getPersistence()
    {
        return $this->persistence;
    }

    public function isErrorReporting()
    {
        return $this->errorReporting;
    }

    public function isExceptions()
    {
        return $this->exceptions;
    }

    public function isKeepAlive()
    {
        return $this->keepAlive;
    }

    public function toArray()
    {
        $optionsAsArray = [
            'keep_alive' => $this->isKeepAlive(),
            'exceptions' => $this->isExceptions(),
        ];

        return $optionsAsArray;
    }

    /**
     * @param mixed $handler
     * @return mixed|null
     */
    private function resolveHandlerObject($handler)
    {
        if (is_string($handler) && class_exists($handler)) {

            return null;
        }
        if (is_object($handler)) {

            return $handler;
        }

        throw new \InvalidArgumentException('The handler has to be a class name or an object');
    }

    /**
     * @param mixed $handler
     * @return mixed|null
     */
    private function resolveHandlerClass($handler)
    {
        if (is_string($handler) && class_exists($handler)) {

            return $handler;
        }
        if (is_object($handler)) {

            return null;
        }

        throw new \InvalidArgumentException('The handler has to be a class name or an object');
    }
}
