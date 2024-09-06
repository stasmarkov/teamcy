<div>
  <input wire:model="name" type="text" color="important:text-black light:text-black">
  <button wire:click="submit">Submit</button>
  @if ($success)
    <div>Saved</div>
  @endif
</div>
