<?php

namespace Huifang\Bootstrap;

use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\Writer;

class ConfigureLogging extends BaseConfigure
{
    protected function configureSyslogHandler(Application $app, Writer $log)
    {
        $name = $app['config']['app.log_syslog_ident'];
        $log->useSyslog($name);
    }
}
