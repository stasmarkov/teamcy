<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Scopes\TenantScope;
use App\Traits\BelongsToTanet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model {
  use HasFactory, BelongsToTanet;

  protected $guarded = [];
}
