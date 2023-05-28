<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestResultRequest;
use App\Models\TestResult;
use Illuminate\Http\RedirectResponse;

class TestResultController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(TestResultRequest $request): RedirectResponse
	{
		$request->user()->testResults()->create($request->validated());

		return back()->with('success', 'Successfully added result');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(TestResult $testResult)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(TestResultRequest $request, TestResult $testResult): RedirectResponse
	{
		$testResult->update($request->validated());

		return back()->with('success', 'Successfully updated result');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(TestResult $testResult): RedirectResponse
	{
		$testResult->delete();

		return back()->with('success', "Successfully deleted result");
	}
}
