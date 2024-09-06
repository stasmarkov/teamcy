<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\Tenant;

trait BelongsToTanet {

  /**
   * {@inheritdoc}
   */
  protected static function bootBelongsToTanet() {
    static::addGlobalScope(new TenantScope);

    static::creating(function (self $model) {
      if (session()->has('tenant_id')) {
        $model->tenant_id = session()->get('tenant_id');
      }
    });
  }

  /**
   * Belongs to tentant.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   *   The Tenant model query builder.
   */
  public function tenant() {
    return $this->belongsTo(Tenant::class);
  }

}
