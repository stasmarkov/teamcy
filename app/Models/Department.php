<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([TenantScope::class])]
class Department extends Model {
  use HasFactory;

  protected $guarded = [];

  /**
   * {@inheritdoc}
   */
  protected static function boot() {
    parent::boot();

    static::creating(function (self $model) {
      if (session()->has('tenant_id')) {
        $model->tenant_id = session()->get('tenant_id');
      }
    });
  }

}
