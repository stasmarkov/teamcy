<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetTenantIdInSession {

  /**
   * Create the event listener.
   */
  public function __construct() {
  }

  /**
   * Handle the event.
   */
  public function handle(Login $event): void {
    session()->put('tenant_id', $event->user->tenant_id);
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param \Illuminate\Events\Dispatcher $events
   *   Events list.
   */
  public function subscribe(Dispatcher $events): void {
    $events->listen(
      Login::class,
      [__CLASS__, 'handle']
    );
  }


}
