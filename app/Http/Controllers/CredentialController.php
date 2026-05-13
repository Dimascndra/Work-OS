<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCredentialRequest;
use App\Http\Requests\UpdateCredentialRequest;
use App\Models\Credential;
use App\Services\CredentialService;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    protected $credentialService;

    public function __construct(CredentialService $credentialService)
    {
        $this->credentialService = $credentialService;
    }

    public function index()
    {
        $credentials = $this->credentialService->getAll();

        return view('pages.credentials.index', compact('credentials'));
    }

    public function create()
    {
        return view('pages.credentials.create');
    }

    public function edit(Credential $credential)
    {
        return view('pages.credentials.edit', compact('credential'));
    }

    public function getCredentials()
    {
        $credentials = $this->credentialService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Credentials retrieved successfully',
            'data' => $credentials
        ]);
    }

    public function store(StoreCredentialRequest $request)
    {
        $credential = $this->credentialService->create($request->validated());

        if (! $request->expectsJson()) {
            return redirect()
                ->route('credentials.index')
                ->with('success', 'Credential created successfully');
        }

        return response()->json([
            'success' => true,
            'message' => 'Credential created successfully',
            'data' => $credential
        ], 201);
    }

    public function update(UpdateCredentialRequest $request, Credential $credential)
    {
        $credential = $this->credentialService->update($credential, $request->validated());

        if (! $request->expectsJson()) {
            return redirect()
                ->route('credentials.index')
                ->with('success', 'Credential updated successfully');
        }

        return response()->json([
            'success' => true,
            'message' => 'Credential updated successfully',
            'data' => $credential
        ]);
    }

    public function destroy(Credential $credential)
    {
        $this->credentialService->delete($credential);

        if (! request()->expectsJson()) {
            return redirect()
                ->route('credentials.index')
                ->with('success', 'Credential deleted successfully');
        }

        return response()->json([
            'success' => true,
            'message' => 'Credential deleted successfully',
            'data' => null
        ]);
    }
}
