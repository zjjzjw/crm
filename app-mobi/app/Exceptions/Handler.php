<?php

namespace Huifang\Mobi\Exceptions;

use Exception;
use Huifang\Exceptions\BaseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }
        /** @var Request $request */
        $request = app('request');
        $this->log->error(
            (string)$e,
            [
                'request' => $request->all(),
                'header'  => $request->header(),
                'url'     => $request->fullUrl(),
                'referer' => $_SERVER['HTTP_REFERER'] ?? '',
            ]
        );
        //return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof BaseException) {
            $data = [];
            $data['code'] = $e->getErrorCode();
            $data['success'] = false;
            $data['msg'] = $e->getPrettyMessage() . $e->getMessage();

            return response()->json($data, $e->getHttpStatusCode());
        }
        return parent::render($request, $e);
    }
}
