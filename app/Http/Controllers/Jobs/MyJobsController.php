<?php

namespace App\Http\Controllers\Jobs;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\JobsRequest;
use App\Http\Resources\Jobs\JobsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MyJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $keyword = $request->query('q');

        $jobs = Job::search($keyword)
            ->where('user_id', auth()->user()->id)
            ->latest()->paginate();

        return JobsResource::collection($jobs);
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(JobsRequest $request): JsonResponse
    {
        $user = $request->user();

        $job = $user->jobs()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Job Successfully Created!',
            'data' => new JobsResource($job)
        ], 201);
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job): JobsResource
    {
        $this->authorize('view', $job);

        return new JobsResource($job);
    }

    /**
     * Update the specified job in storage.
     */
    public function update(JobsRequest $request, Job $job): JsonResponse
    {
        $data = array_merge($request->validated(), ['user_id' => $request->user()->id]);

        $job->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Job Successfully Updated!',
            'data' => new JobsResource($job)
        ], 200);
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(Job $job): JsonResponse
    {
        $this->authorize('delete', $job);

        $job->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Job Successfully Deleted!',
        ]);
    }
}
