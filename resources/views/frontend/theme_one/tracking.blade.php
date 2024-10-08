@extends('frontend.theme_one.common.layout')

@section('content')
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-danger-100 py-5 px-6 text-base text-danger-700" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="mx-auto table mt-10 mb-12 tracker_form mb-4" id="tracker_form">
        <div class="block max-w-lg rounded-lg bg-white p-6 shadow-lg dark:bg-neutral-700 border-t-8">
            <form method="get" action="" novalidate="novalidate">
                <div class="relative mb-6" data-te-input-wrapper-init>
                    <input type="text" name="work_id"
                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleInput7" placeholder="Name" />
                    <label for="exampleInput7"
                        class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Shipment
                        Code
                    </label>
                </div>

                <button type="submit" id="track_btn" style="background-color: blue"
                    class=" track_btn w-full rounded bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                    data-te-ripple-init data-te-ripple-color="light">
                    Track
                </button>
            </form>
        </div>
    </div>


    @if (isset($tracker_data) && count($tracker_data) > 0)
        @foreach ($tracker_data as $tracker)
            <div class="flex flex-col m-14 track_order tracking_list_tbl" id="tracking_list_tbl">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <!-- <button type="submit new_track_btn" id="new_track_btn"
                                            class="float-right rounded bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                                            data-te-ripple-init data-te-ripple-color="light">
                                            Track
                                        </button> -->
                            <table class="min-w-full text-left text-sm font-light border-zinc-500 border-2">
                                <thead
                                    class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Date</th>
                                        <th scope="col" class="px-6 py-4">Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $tracker->date }}
                                            {{ $tracker->time }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $tracker->location }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
