<?php

use DcatAdmin\Echart\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('echart', Controllers\EchartController::class.'@index');