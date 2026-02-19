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
        return view('pages.credentials.index');
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

        return response()->json([
            'success' => true,
            'message' => 'Credential created successfully',
            'data' => $credential
        ], 201);
    }

    public function update(UpdateCredentialRequest $request, Credential $credential)
    {
        $credential = $this->credentialService->update($credential, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Credential updated successfully',
            'data' => $credential
        ]);
    }

    public function destroy(Credential $credential)
    {
        $this->credentialService->delete($credential);

        return response()->json([
            'success' => true,
            'message' => 'Credential deleted successfully',
            'data' => null
        ]);
    }
}
