<?php

namespace Fixtures;

class DummyServiceHandler
{
    /**
     * @param DummyServiceRequest
     * @return DummyServiceResponse
     */
    public function handle(DummyServiceRequest $request)
    {
        $response = new DummyServiceResponse();
        $response->status = true;

        return $response;
    }
}
