<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use App\Traits\BelongsToTanet;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable {

  use HasFactory, Notifiable, BelongsToTanet;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $guarded = [];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function avatarUrl() {
    if ($this->photo) {
      return Storage::disk('s3')->url($this->photo);
    }

    return 'https://api.dicebear.com/9.x/pixel-art/svg';
  }

  public static function search($query) {
    return empty($query) ? static::query()
      : static::where('name', 'like', '%' . $query . '%')
        ->orWhere('email', 'like', '%' . $query . '%');
  }

  public function isAdmin() {
    return strtolower($this->role) === 'admin' || strtolower($this->role) === 'super_admin';
  }

  public function isHR() {
    return strtolower($this->role) == 'Human_Resources';
  }

  public function applicationUrl() {
    if ($this->application()) {
      return url('/documents/' . $this->id . '/' . $this->application()->filename);
    }

    return '#';
  }

  public function application() {
    return $this->documents()->where('type', 'application')->first();
  }

  public function documents() {
    return $this->hasMany(Document::class);
  }

}
