<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class PageController
 *
 * @package   App\Http\Controllers
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 24, 2020
 * @project   reloop
 */
class PageController extends Controller
{
    /**
     * Method: thankyou
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thankyou()
    {
        return view('pages.thankyou');
    }

    /**
     * Method: tokenExpired
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tokenExpired()
    {
        return view('pages.expired');
    }
}
