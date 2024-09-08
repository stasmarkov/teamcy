<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller {

  /**
   * @param \App\Models\User $user
   * @param string $filename
   *
   * @return void
   */
  public function show(User $user, string $filename) {
    // Find the document.
    $doc = $user->documents()->where('filename', $filename)->get()->first();

    if (!$doc) {
      abort(404);
    }

    // Auth the user.
    if (!Auth::user()->isAdmin()) {
      abort(403);
    }

    // Stream file to the user.
    if ($doc?->extension === 'pdf') {
      return response(Storage::disk('s3-private')->get('/documents/' . $user->id . '/' . $filename))
        ->header('Content-Type', 'application/pdf');
    }
  }

}
