<?php

namespace Huifang\Site\Http\Controllers;

use Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LarvalBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends LarvalBaseController
{
    use DispatchesJobs, ValidatesRequests;

}