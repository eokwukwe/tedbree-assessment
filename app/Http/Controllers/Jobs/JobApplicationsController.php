<?php

namespace App\Http\Controllers\Jobs;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Jobs\JobApplicationsRequest;
use App\Http\Resources\Jobs\JobApplicationsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobApplicationsController extends Controller
{
    /**
     * Display a listing of the applications for the specified job.
     */
    public function index(Job $job): AnonymousResourceCollection
    {
        $this->authorize('viewAny', $job);

        $applications = JobApplication::where('job_id', $job->id)->paginate();

        return JobApplicationsResource::collection($applications);
    }

    /**
     * Store a newly created job application in storage.
     */
    public function store(JobApplicationsRequest $request, Job $job): JsonResponse
    {
        $file = $request->file('cv');

        $filename = time() . '-' . $file->getClientOriginalName();

        // save to storage/app/public/cvs as the new $filename
        $file->storeAs('cvs', $filename);

        $job->applications()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'cv' => Storage::url($filename),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Application Successfully Submitted!'
        ], 201);
    }
}
