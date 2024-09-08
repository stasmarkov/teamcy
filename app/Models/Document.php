<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\TenantScope;
use App\Traits\BelongsToTanet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model {

  use HasFactory, BelongsToTanet;

  protected $guarded = [];

  /**
   * Belongs to 1 user.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   *   The user.
   */
  public function user() {
    return $this->belongsTo(User::class);
  }

  public function privateUrl() {
    return url('/documents/' . $this->user_id . '/' . $this->filename);
  }

}
