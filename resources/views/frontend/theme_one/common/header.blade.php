<div class="tsx_header">
    <div class="relative flex w-full items-center justify-between text-neutral-600 dark:text-neutral-300 lg:flex-wrap lg:justify-start"
        style="max-width: 1300px; margin-left: auto; margin-right: auto;">
        <div class="px-6">
            <a class="mt-2 mr-2 flex items-center text-neutral-900 hover:text-neutral-900 focus:text-neutral-900 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400 lg:mt-0"
                href="#">
                <img src="./images/laxmi.png" style="height: 45px" alt="" loading="lazy" /> Laxmi Transportation
            </a>
        </div>
        <div class="ml-auto">
            <nav class="relative flex w-full flex-row-reverse items-center justify-between py-2 text-neutral-600 dark:text-neutral-300 lg:flex-wrap lg:justify-start"
                data-te-navbar-ref>
                <div class="px-6">
                    <button
                        class="border-0 bg-transparent py-3 text-xl leading-none transition-shadow duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:hidden"
                        type="button" data-te-collapse-init data-te-target="#navbarSupportedContentX"
                        aria-controls="navbarSupportedContentX" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="[&>svg]:w-8">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </span>
                    </button>
                    <div class="!visible hidden flex-grow basis-[100%] lg:!flex lg:basis-auto"
                        id="navbarSupportedContentX" data-te-collapse-item>
                        <ul class="mr-auto flex flex-row justify-end" data-te-navbar-nav-ref>
                            <li class="static pr-6" data-te-nav-item-ref data-te-dropdown-ref>
                                <a class="flex items-center whitespace-nowrap py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="/" data-te-ripple-init data-te-ripple-color="light"
                                    aria-expanded="false" data-te-nav-link-ref>Home
                                </a>
                            </li>
                            <li class="pr-6" data-te-nav-item-ref mb-2>
                                <a class="block py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="{{ url('aboutus') }}" data-te-ripple-init data-te-ripple-color="light">About
                                    us</a>
                            </li>
                            <li class="pr-6" data-te-nav-item-ref data-te-dropdown-ref>
                                <a class="flex items-center whitespace-nowrap py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="#" data-te-ripple-init data-te-ripple-color="light" type="button"
                                    id="dropdownMenuButtonX" data-te-dropdown-toggle-ref aria-expanded="false"
                                    data-te-nav-link-ref>Drivers
                                    <span class="ml-2">
                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                    </span>
                                </a>
                                <div class="absolute top-full z-[1000] hidden border-none bg-white bg-clip-padding text-neutral-600 shadow-lg dark:bg-neutral-700 dark:text-neutral-200 [&[data-te-dropdown-show]]:block"
                                    aria-labelledby="dropdownMenuButtonX" data-te-dropdown-menu-ref>
                                    <div>
                                        <div>
                                            <div>
                                                <a href="{{ route('driver.login') }}" aria-current="true"
                                                    class="block w-full border-neutral-200 px-6 py-2 transition duration-150 ease-in-out hover:bg-neutral-50 hover:text-neutral-700 dark:border-neutral-500 dark:hover:bg-neutral-800 dark:hover:text-white">Login</a>

                                                <a href="{{ route('driver.register') }}" aria-current="true"
                                                    class="block w-full border-neutral-200 px-6 py-2 transition duration-150 ease-in-out hover:bg-neutral-50 hover:text-neutral-700 dark:border-neutral-500 dark:hover:bg-neutral-800 dark:hover:text-white">Register</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            {{-- <li class="pr-6" data-te-nav-item-ref data-te-dropdown-ref>
                                <a class="flex items-center whitespace-nowrap py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="#" data-te-ripple-init data-te-ripple-color="light" type="button"
                                    id="dropdownMenuButtonX" data-te-dropdown-toggle-ref aria-expanded="false"
                                    data-te-nav-link-ref>Carrier
                                    <span class="ml-2">
                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                    </span>
                                </a>
                                <div class="absolute top-full z-[1000] hidden border-none bg-white bg-clip-padding text-neutral-600 shadow-lg dark:bg-neutral-700 dark:text-neutral-200 [&[data-te-dropdown-show]]:block"
                                    aria-labelledby="dropdownMenuButtonX" data-te-dropdown-menu-ref>
                                    <div>
                                        <div>
                                            <div>
                                                <a href="#" aria-current="true"
                                                    class="block w-full border-neutral-200 px-6 py-2 transition duration-150 ease-in-out hover:bg-neutral-50 hover:text-neutral-700 dark:border-neutral-500 dark:hover:bg-neutral-800 dark:hover:text-white">Login</a>

                                                <a href="#" aria-current="true"
                                                    class="block w-full border-neutral-200 px-6 py-2 transition duration-150 ease-in-out hover:bg-neutral-50 hover:text-neutral-700 dark:border-neutral-500 dark:hover:bg-neutral-800 dark:hover:text-white">Register</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}

                            <li class="pr-6" data-te-nav-item-ref>
                                <a class="block py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="{{ url('customer') }}" data-te-ripple-init
                                    data-te-ripple-color="light">Customers</a>
                            </li>
                            <li class="pr-6" data-te-nav-item-ref>
                                <a class="block py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="{{ url('safety') }}" data-te-ripple-init
                                    data-te-ripple-color="light">Safety</a>
                            </li>
                            <li class="pr-6" data-te-nav-item-ref>
                                <a class="block py-2 pr-2 transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:px-2"
                                    href="/tracking" data-te-ripple-init data-te-ripple-color="light">Tracking</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
