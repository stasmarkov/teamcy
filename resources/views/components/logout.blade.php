<form action="{{ route('logout') }}" method="POST">
  @csrf
  @method('POST')
  <button class="text-sm font-semibold leading-6 text-gray-900">Logout</button>
</form>
