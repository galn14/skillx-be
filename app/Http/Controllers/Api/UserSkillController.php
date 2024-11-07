<?php

namespace App\Http\Controllers\Api;

use App\Models\UserSkill;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserSkillController extends Controller
{
    /**
     * Display the user's skills.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userId = Auth::id();
        $userSkills = UserSkill::where('UserId', $userId)->with('skill')->get();

        return response()->json($userSkills, 200);
    }

    /**
     * Store a newly chosen skill for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdSkill' => 'required|exists:skills,IdSkill',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();
        $skillId = $request->IdSkill;

        // Check if the skill is already added for the user
        $existingSkill = UserSkill::where('UserId', $userId)
                                   ->where('IdSkill', $skillId)
                                   ->first();

        if ($existingSkill) {
            return response()->json([
                'success' => false,
                'message' => 'Skill already added to user.'
            ], 409);
        }

        // Create the user skill record
        $userSkill = UserSkill::create([
            'UserId' => $userId,
            'IdSkill' => $skillId,
        ]);

        return response()->json([
            'success' => true,
            'data' => $userSkill,
            'message' => 'Skill added to user successfully.',
        ], 201);
    }

    /**
     * Remove a skill from the user's skill set.
     *
     * @param  int  $skillId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($skillId)
    {
        $userId = Auth::id();

        $userSkill = UserSkill::where('UserId', $userId)
                              ->where('IdSkill', $skillId)
                              ->first();

        if (!$userSkill) {
            return response()->json(['message' => 'Skill not found for this user.'], 404);
        }

        $userSkill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill removed from user successfully.',
        ], 200);
    }
}
