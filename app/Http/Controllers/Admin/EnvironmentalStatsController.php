<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\EnvironmentalStatsDescriptionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class EnvironmentalStatsController
 *
 * @package   App\Http\Controllers\Admin
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 14, 2020
 * @project   reloop
 */
class EnvironmentalStatsController extends Controller
{
    /**
     * Property: environmentalStatsDescriptionService
     *
     * @var EnvironmentalStatsDescriptionService
     */
    private $environmentalStatsDescriptionService;

    public function __construct(EnvironmentalStatsDescriptionService $environmentalStatsDescriptionService)
    {
        $this->environmentalStatsDescriptionService = $environmentalStatsDescriptionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $environmentalStatsDescriptions = $this->environmentalStatsDescriptionService->all() ?? null;
        return view('environmentalStatsDescriptions.index', compact('environmentalStatsDescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $environmentalStatsDescription = $this->environmentalStatsDescriptionService->findById($id);
        if ($environmentalStatsDescription) {
            return view('environmentalStatsDescriptions.edit', compact('environmentalStatsDescription'));
        } else {
            return view('environmentalStatsDescriptions.edit')->with('error', 'No Information Founded !');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $environmentalStatsDescription = $this->environmentalStatsDescriptionService->update($id, $data);

        if ($environmentalStatsDescription) {
            return redirect()->back()->with('success', Config::get('constants.PAGE_UPDATE_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.PAGE_UPDATE_ERROR'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
