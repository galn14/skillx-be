<?php

// app/Services/FirebaseService.php
namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected $database;
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials'))
            ->withDatabaseUri(config('services.firebase.database_url'));

        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
    }

    public function setData($path, $data)
    {
        return $this->database->getReference($path)->set($data);
    }

    public function getData($path)
    {
        return $this->database->getReference($path)->getValue();
    }

    public function verifyGoogleToken($idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken;
        } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
            throw new \Exception('The token is invalid: ' . $e->getMessage());
        }
    }
}
