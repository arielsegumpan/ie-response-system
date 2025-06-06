<div>
    <!-- Contact Us -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

        <div class="max-w-xl mx-auto">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
                    {{ __(' Contact us') }}
                </h1>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">
                    {{ __('Have a question or need assistance? We are here to help!') }}
                </p>
            </div>
        </div>

        <div class="mt-12 max-w-lg mx-auto">
        <!-- Card -->
        <div class="flex flex-col border border-gray-200 rounded-xl p-4 sm:p-6 lg:p-8 dark:border-neutral-700">

            @if (session()->has('success'))
                <div class="space-y-5">
                    <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                        <div class="flex">
                        <div class="shrink-0">
                            <!-- Icon -->
                            <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                            </span>
                            <!-- End Icon -->
                        </div>
                        <div class="ms-3">
                            <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
                                {{ __('Success!') }}
                            </h3>
                            <p class="text-sm text-gray-700 dark:text-neutral-400">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <h2 class="mb-8 text-xl font-semibold text-gray-800 dark:text-neutral-200">
                {{ __('Get in touch with us') }}
            </h2>

            <form wire:submit.prevent="submitContactForm" class="space-y-6">
                <div class="grid gap-4 lg:gap-6">
                    <div>
                        <label for="hs-subject-contacts-1" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">{{ __('Subject') }}</label>
                        <input wire:model.blur="subject" type="text" name="hs-subject-contacts-1" id="hs-subject-contacts-1" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-red-500 border focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                        @error('subject')
                            <span class="text-xs text-red-500 mt-2">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label for="hs-firstname-contacts-1" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">{{ __('First Name') }}</label>
                            <input wire:model.blur="first_name" type="text" name="hs-firstname-contacts-1" id="hs-firstname-contacts-1" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-red-500 border focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                            @error('first_name')
                                <span class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="hs-lastname-contacts-1" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">{{ __('Last Name') }}</label>
                            <input wire:model.blur="last_name" type="text" name="hs-lastname-contacts-1" id="hs-lastname-contacts-1" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                            @error('last_name')
                                <span class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- End Grid -->

                    <!-- Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label for="hs-email-contacts-1" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">{{ __('Email') }}</label>
                            <input wire:model.blur="email" type="email" name="hs-email-contacts-1" id="hs-email-contacts-1" autocomplete="email" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                            @error('email')
                                <span class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="hs-phone-number-1" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">{{ __('Phone Number') }}</label>
                            <input wire:model.blur="phone" type="text" name="hs-phone-number-1" id="hs-phone-number-1" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

                            @error('phone')
                                <span class="text-xs text-red-500 mt-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- End Grid -->

                    <div>
                    <label for="hs-about-contacts-1" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">{{ __('Details') }}</label>
                    <textarea wire:model.blur="message" id="hs-about-contacts-1" name="hs-about-contacts-1" rows="4" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"></textarea>

                    @error('message')
                        <span class="text-xs text-red-500 mt-2">
                            {{ $message }}
                        </span>
                    @enderror
                    </div>
                </div>
                <!-- End Grid -->

                <div class="mt-6 grid">
                    <button wire:loading.attr="disabled" type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">{{ __('Send inquiry') }}</button>
                </div>

                <div class="mt-3 text-center">
                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                        {{ __('We will get back to you as soon as possible. Thank you for reaching out!') }}
                    </p>
                </div>
            </form>
        </div>
        <!-- End Card -->
        </div>

        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 items-center gap-4 lg:gap-8">
        <!-- Icon Block -->
        <a class="group flex flex-col h-full text-center rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 p-4 sm:p-6 dark:hover:bg-neutral-500/10 dark:focus:bg-neutral-500/10" href="#">
            <svg class="size-9 text-gray-800 mx-auto dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
            <div class="mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Knowledgebase</h3>
            <p class="mt-1 text-gray-500 dark:text-neutral-500">We're here to help with any questions or code.</p>
            <p class="mt-5 inline-flex items-center gap-x-1 font-medium text-red-600 dark:text-red-500">
                Contact support
                <svg class="shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </p>
            </div>
        </a>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <a class="group flex flex-col h-full text-center rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 p-4 sm:p-6 dark:hover:bg-neutral-500/10 dark:focus:bg-neutral-500/10" href="#">
            <svg class="size-9 text-gray-800 mx-auto dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
            <div class="mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">FAQ</h3>
            <p class="mt-1 text-gray-500 dark:text-neutral-500">Search our FAQ for answers to anything you might ask.</p>
            <p class="mt-5 inline-flex items-center gap-x-1 font-medium text-red-600 dark:text-red-500">
                Visit FAQ
                <svg class="shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </p>
            </div>
        </a>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <a class="group flex flex-col h-full text-center rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 p-4 sm:p-6 dark:hover:bg-neutral-500/10 dark:focus:bg-neutral-500/10" href="#">
            <svg class="size-9 text-gray-800 mx-auto dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 11 2-2-2-2"/><path d="M11 13h4"/><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/></svg>
            <div class="mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Developer APIs</h3>
            <p class="mt-1 text-gray-500 dark:text-neutral-500">Check out our development quickstart guide.</p>
            <p class="mt-5 inline-flex items-center gap-x-1 font-medium text-red-600 dark:text-red-500">
                Contact sales
                <svg class="shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </p>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>
    </div>
    <!-- End Contact Us -->
</div>
