@section('title', 'Create a new account')

<div>
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <a href="{{ route('home') }}">
      <x-logo class="w-auto h-16 mx-auto text-indigo-600"/>
    </a>

    <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
      Start your free trial
    </h2>

    <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
      Or
      <a href="{{ route('login') }}"
         class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
        sign in to your account
      </a>
    </p>
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
      <form wire:submit.prevent="register">
        <x-form_elements.text-input
          label="Name"
          type="text"
          required="true"
          placeholder="Enter a name"
          wire:model="name"
        />

        <x-form_elements.text-input
          label="Company Name"
          type="text"
          required="true"
          placeholder="Enter a Company Name"
          class="mt-6"
          wire:model="companyName"
        />

        <x-form_elements.text-input
          label="Email"
          type="email"
          required="true"
          placeholder="Enter an email address"
          class="mt-6"
          wire:model="email"
        />
        <x-form_elements.text-input
          label="Password"
          type="password"
          required="true"
          class="mt-6"
          wire:model="password"
        />
        <div class="mt-6">
          <span class="block w-full rounded-md shadow-sm">
              <button type="submit"
                      class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                  Register
              </button>
          </span>
        </div>
      </form>
    </div>
  </div>
</div>
