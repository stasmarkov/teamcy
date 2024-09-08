<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class ClearTenantIdFromSession {

  /**
   * Handle the event.
   *
   * @param object $event
   *
   * @return void
   */
  public function handle(Logout $event) {
    session()->forget('tenant_id');
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param \Illuminate\Events\Dispatcher $events
   *   Events list.
   */
  public function subscribe(Dispatcher $events): void {
    $events->listen(
      Logout::class,
      [__CLASS__, 'handle']
    );
  }

}
