<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestingSeriesRequest;
use App\Http\Resources\FormatResource;
use App\Http\Resources\TestingSeriesResource;
use App\Models\TestingSeries;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class TestingSeriesController extends Controller
{
	private const HOME_URL = 'testing_series.index';

	public function __construct()
	{
		$this->authorizeResource(TestingSeries::class);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): Response|ResponseFactory
	{
		$series = $request->user()->testingSeries()->with([ 'format' ])->get();
		return inertia('TestingSeries/SeriesIndex', [
			'series'  => TestingSeriesResource::collection($series)->toArray($request),
			'formats' => FormatResource::generateKeyValueList()->toArray($request),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(TestingSeriesRequest $request): RedirectResponse
	{
		$testingSeries = $request->user()->testingSeries()->create($request->validated());

		return to_route(static::HOME_URL)->with('success', "Successfully created series $testingSeries->name!");
	}

	/**
	 * Display the specified resource.
	 */
	public function show(TestingSeries $testingSeries)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(TestingSeriesRequest $request, TestingSeries $testingSeries): RedirectResponse
	{
		$testingSeries->update($request->validated());

		return to_route(static::HOME_URL)->with('success', "Successfully updated series $testingSeries->name!");
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(TestingSeries $testingSeries): RedirectResponse
	{
		$testingSeries->delete();

		return to_route(static::HOME_URL)->with('success', "Successfully deleted series $testingSeries->name!");
	}
}
