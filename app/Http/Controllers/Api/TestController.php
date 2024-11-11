<?php

// app/Http/Controllers/Api/TestController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function testFirebase(): JsonResponse
    {
        // Test data
        $testData = [
            'name' => 'Laravel Firebase Test',
            'timestamp' => now()->toDateTimeString(),
        ];

        // Set data in Firebase
        $this->firebase->setData('test/path', $testData);

        // Retrieve data from Firebase
        $retrievedData = $this->firebase->getData('test/path');

        return response()->json([
            'status' => 'success',
            'set_data' => $testData,
            'retrieved_data' => $retrievedData,
        ]);
    }
}
