<?php

use App\Http\Livewire\CommissionReportComponent;
use App\Http\Livewire\TopDistributorsReportComponent;
use Illuminate\Support\Facades\Route;





Route::get('/', CommissionReportComponent::class)->name('commission.report');


Route::get('/top-distributor', TopDistributorsReportComponent::class)->name('top.distributor');


