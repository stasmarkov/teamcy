<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Tenant Model.
 */
class Tenant extends Model {

  use HasFactory;

  /**
   * {@inheritdoc}
   */
  protected $fillable = [
    'name',
  ];

}
