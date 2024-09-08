<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordLogin {

  /**
   * Create the event listener.
   */
  public function __construct() {
  }

  /**
   * Handle the event.
   */
  public function handle($event) {
    if ($event->user->tenant_id) {
      Login::create([
        'user_id' => $event->user->id,
        'tenant_id' => $event->user->tenant_id,
      ]);
    }
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
