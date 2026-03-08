<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()->load('student'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $studentNumber = $validated['student_number'] ?? null;
        unset($validated['student_number']);

        $user = $request->user();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (! $user->isAdmin()) {
            $existingStudent = $user->student;

            if ($studentNumber) {
                Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $user->name,
                        'student_number' => $studentNumber,
                        'course' => $existingStudent?->course ?? 'N/A',
                        'email' => $user->email,
                    ]
                );
            } elseif ($existingStudent) {
                // Keep student profile aligned when only name/email is updated.
                $existingStudent->update([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
