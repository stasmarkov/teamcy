<form action="{{ route('logout') }}" method="POST">
  @csrf
  @method('POST')
  <button class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Logout</button>
</form>
