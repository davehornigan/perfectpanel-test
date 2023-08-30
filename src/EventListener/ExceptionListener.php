<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $responseData = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode() === 0 ? 500 : $exception->getCode()
        ];
        if ($exception instanceof HttpException) {
            $responseData['code'] = $exception->getStatusCode();
        }

        $event->setResponse(new JsonResponse($responseData, $responseData['code']));
    }
}