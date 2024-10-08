@extends('frontend.theme_one.common.layout')

@section('content')
    <div>
        <div class="hero-section"
            style="background: linear-gradient(b89abd, b89abd)),
    url('{{ asset('images/bannerman.jpeg') }}');  background-repeat: no-repeat !important;
  background-size: cover !important;">
            <div class="mx-auto flex pt-32" style="max-width: 1080px; margin-bottom: 50px;  position: relative;">
                <div style="width: 50%" class="px-5">
                    <img class="rounded-lg mb-4" width="750" height="422" src="{{ asset('images/screentouch.jpeg') }}"
                        style="width: 750px;height:330px;" alt="" loading="lazy" />
                    <div class="mb-4">
                        <p class="text-white text-4xl font-bold ">Your freight, your control, We deliver</p>
                    </div>
                    <div class="mb-5 text-xl font-semibold">
                        <p class="text-white">
                            We are a leading provider of less than truckload, expedited, full truckload transportation and
                            custom solutions through our network.
                        </p>
                    </div>

                </div>
                <div style="width: 50%" class="px-5">

                    <div class="mb-4">
                        <p class="text-white text-4xl font-bold ">Request a Quote</p>
                    </div>


                    <form id="regForm" style="background-color: #ffffff;padding:20px;"
                        class="border-solid border-solid border-2 shadow-inner rounded-lg w-full shadow-2xl" method="post"
                        action="{{ route('quote.order') }}" novalidate="novalidate">
                        @csrf

                        <!-- One "tab" for each step in the form: -->
                        <div class="tab">
                            <div class="w-full bg-yellow-300 rounded-2xl dark:bg-neutral-600 h-6 mb-8 mt-3">
                                <div class="h-6 pr-3 rounded-2xl bg-[rgb(2,54,77,1)] p-0.5 text-end font-medium text-primary-100 font-sans"
                                    style="width: 25%; font-size: 1.25em; line-height: 1em;">
                                    25%
                                </div>
                            </div>



                            <div class="flex">
                                <div class="relative mb-6 max-w-2xl w-full" data-te-input-wrapper-init>
                                    <input type="text" name="pickup_company_address"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput1" placeholder="Origin" />
                                    <label for="exampleFormControlInput1"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Origin
                                    </label>
                                </div>
                            </div>

                            <div class="columns-2">
                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="pickup_company_city_zip_code"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Origin Zip Code" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Origin
                                            Zip Code
                                        </label>
                                    </div>
                                </div>
                                <div class="relative mb-6 xl:w-[184px]" data-te-datepicker-init data-te-input-wrapper-init>
                                    <input type="text" name="pickup_date"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        placeholder="Date" />
                                    <label for="floatingInput"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Date</label>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="relative mb-6 max-w-2xl w-full" data-te-input-wrapper-init>
                                    <input type="text" name="drop_address"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput1" placeholder="Destination" />
                                    <label for="exampleFormControlInput1"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Destination
                                    </label>
                                </div>
                            </div>

                            <div class="columns-2">
                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="drop_city_zip_code"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Destination Zip Code" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Destination
                                            Zip Code
                                        </label>
                                    </div>
                                </div>

                                <div class="relative mb-6 xl:w-[184px]" data-te-datepicker-init data-te-input-wrapper-init>
                                    <input type="text" name="drop_date"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        placeholder="Date" />
                                    <label for="floatingInput"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Date</label>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="w-full bg-yellow-300 rounded-2xl dark:bg-neutral-600 h-6 mb-8 mt-3">
                                <div class="h-6 pr-3 rounded-2xl bg-[rgb(2,54,77,1)] p-0.5 text-end font-medium text-primary-100 font-sans"
                                    style="width: 50%; font-size: 1.25em; line-height: 1em;">
                                    50%
                                </div>
                            </div>

                            <div class="flex">
                                <div class="relative mb-6 max-w-2xl w-full" data-te-input-wrapper-init>
                                    <input type="text" name="name"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput1" placeholder="Name" />
                                    <label for="exampleFormControlInput1"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Name
                                    </label>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="relative mb-6 max-w-2xl w-full" data-te-input-wrapper-init>
                                    <input type="text" name="email_address"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput1" placeholder="Email Address" />
                                    <label for="exampleFormControlInput1"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Email
                                        Address
                                    </label>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="relative mb-6 max-w-2xl w-full" data-te-input-wrapper-init>
                                    <input type="text" name="phone_number"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput1" placeholder="Phone Number" />
                                    <label for="exampleFormControlInput1"
                                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Phone
                                        Number
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="tab">
                            <div class="w-full bg-yellow-300 rounded-2xl dark:bg-neutral-600 h-6 mb-8 mt-3">
                                <div class="h-6 pr-3 rounded-2xl bg-[rgb(2,54,77,1)] p-0.5 text-end font-medium text-primary-100 font-sans"
                                    style="width: 100%; font-size: 1.25em; line-height: 1em;">
                                    100%
                                </div>
                            </div>
                            <div class="columns-2">
                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="pieces"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Pieces" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                                            Pieces
                                        </label>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="weight"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Weight (lbs)" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                                            Weight (lbs)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="columns-3">
                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="length"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Length (inch)" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                                            Length (inch)
                                        </label>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="width"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Width (inch)" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                                            Width (inch)
                                        </label>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="relative mb-6 xl:w-80" data-te-input-wrapper-init>
                                        <input type="text" name="height"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInput1" placeholder="Height (inch)" />
                                        <label for="exampleFormControlInput1"
                                            class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                                            Height (inch)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="relative mb-3" data-te-input-wrapper-init>
                                <textarea
                                    class="peer block min-h-[120px] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    rows="5" name="description" placeholder="Description"></textarea>
                                <label for="exampleFormControlTextarea1"
                                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Description</label>
                            </div>
                        </div>
                        <div style="overflow:auto;">
                            <div>
                                <button type="button"
                                    class="mr-3 p-3 float-left w-[48%] rounded bg-sky-600 bg-primary px-6 py-2.5 font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                                    id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button"
                                    class=" p-3 w-full rounded bg-sky-600 bg-primary px-6 py-2.5 font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                                    id="nextBtn" onclick="nextPrev(1)">Next</button>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        <div style="text-align:center;margin-top:40px; display:none;">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                    </form>
                    <script>
                        var currentTab = 0; // Current tab is set to be the first tab (0)
                        showTab(currentTab); // Display the current tab

                        function showTab(n) {
                            // This function will display the specified tab of the form...
                            var x = document.getElementsByClassName("tab");
                            x[n].style.display = "block";
                            //... and fix the Previous/Next buttons:
                            if (n == 0) {
                                document.getElementById("prevBtn").style.display = "none";

                            } else {
                                document.getElementById("prevBtn").style.display = "inline";
                                document.getElementById("nextBtn").style.width = '48%';
                            }
                            if (n == (x.length - 1)) {
                                document.getElementById("nextBtn").innerHTML = "Submit";
                            } else {
                                document.getElementById("nextBtn").innerHTML = "Next";
                            }
                            //... and run a function that will display the correct step indicator:
                            fixStepIndicator(n)
                        }

                        function nextPrev(n) {
                            // This function will figure out which tab to display
                            var x = document.getElementsByClassName("tab");
                            // Exit the function if any field in the current tab is invalid:
                            if (n == 1 && !validateForm()) return false;
                            // Hide the current tab:
                            x[currentTab].style.display = "none";
                            // Increase or decrease the current tab by 1:
                            currentTab = currentTab + n;
                            // if you have reached the end of the form...
                            if (currentTab >= x.length) {
                                // ... the form gets submitted:
                                document.getElementById("regForm").submit();
                                return false;
                            }
                            // Otherwise, display the correct tab:
                            showTab(currentTab);
                        }

                        function validateForm() {
                            // This function deals with validation of the form fields
                            var x, y, i, valid = true;
                            x = document.getElementsByClassName("tab");
                            y = x[currentTab].getElementsByTagName("input");
                            // A loop that checks every input field in the current tab:
                            for (i = 0; i < y.length; i++) {
                                // If a field is empty...
                                if (y[i].value == "") {
                                    // add an "invalid" class to the field:
                                    y[i].className += " invalid";
                                    // and set the current valid status to false
                                    valid = false;
                                }
                            }
                            // If the valid status is true, mark the step as finished and valid:
                            if (valid) {
                                document.getElementsByClassName("step")[currentTab].className += " finish";
                            }
                            return valid; // return the valid status
                        }

                        function fixStepIndicator(n) {
                            // This function removes the "active" class of all steps...
                            var i, x = document.getElementsByClassName("step");
                            for (i = 0; i < x.length; i++) {
                                x[i].className = x[i].className.replace(" active", "");
                            }
                            //... and adds the "active" class on the current step:
                            x[n].className += " active";
                        }
                    </script>
                </div>

            </div>

            <div>

            </div>

        </div>

        <div class="service-section bg-gray-200  text-cyan-900 text-center font-sans">
            <p class="pt-24 text-6xl font-bold">Our Services</p>
            <div class="mt-5 px-3 grid grid-cols-4 gap-4 py-28">
                <div class="service1 rounded-lg bg-white">

                    <div class="text-2xl font-bold py-3">
                        <p>24/7 Live support team</p>
                    </div>
                    <div class="text-lg pb-6">
                        <img src="{{ asset('images/support.jpeg') }}" style="padding: 0px 20px;" alt="">
                    </div>
                </div>
                <div class="service2 rounded-lg bg-white">
                    <div class="text-2xl font-bold py-3">
                        <p>GPS Tracking</p>
                    </div>
                    <div class="text-lg pb-6">
                        <img src="{{ asset('images/tracker.jpeg') }}" style="padding: 0px 20px;" alt="">
                    </div>
                </div>
                <div class="service3 rounded-lg bg-white">
                    <div class="text-2xl font-bold py-3">
                        <p>GPS Tracking
                            On time Delivery</p>
                    </div>
                    <div class="text-lg">
                        <img src="{{ asset('images/delivery.jpeg') }}" style="padding: 0px 20px;" alt="">
                    </div>
                </div>
                <div class="service4 rounded-lg bg-white">
                    <div class="text-2xl font-bold py-3">
                        <p>...</p>
                    </div>
                    <div class="text-lg">
                        <img src="https://t3.ftcdn.net/jpg/04/34/72/82/240_F_434728286_OWQQvAFoXZLdGHlObozsolNeuSxhpr84.jpg"
                            style="padding: 0px 20px;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
