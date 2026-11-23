<?php

namespace App\Http\Controllers;

use App\Models\PortfolioContent;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __invoke(): View
    {
        return view('portfolio.show', ['content' => PortfolioContent::current()]);
    }
}
