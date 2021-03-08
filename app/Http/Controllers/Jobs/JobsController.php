<?php

namespace App\Http\Controllers\Jobs;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Jobs\JobsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobsController extends Controller
{
    /**
     * Display a listing of jobs.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $keyword = $request->query('q');

        return JobsResource::collection(
            Job::search($keyword)->latest()->paginate()
        );
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job): JobsResource
    {
        return new JobsResource($job);
    }
}
