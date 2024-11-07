<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /**
     * Display a specific skill.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        return response()->json($skill, 200);
    }

    /**
     * Store a newly created skill.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TitleSkills' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $skill = Skill::create([
            'TitleSkills' => $request->TitleSkills,
        ]);

        return response()->json([
            'success' => true,
            'data' => $skill,
            'message' => 'Skill created successfully',
        ], 201);
    }

    /**
     * Update an existing skill.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'TitleSkills' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $skill->update([
            'TitleSkills' => $request->TitleSkills,
        ]);

        return response()->json([
            'success' => true,
            'data' => $skill,
            'message' => 'Skill updated successfully',
        ], 200);
    }

    /**
     * Delete a skill.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully'
        ], 200);
    }
}
