<div>
    <!-- Contact Us -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="max-w-2xl lg:max-w-5xl mx-auto">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
            Isugid Mo!
            </h1>
            <p class="mt-1 text-gray-600 dark:text-neutral-400">
            We'd love to help. report any incidents or issues
            </p>
        </div>

        <div class="pt-10 lg:pt-14">
            <!-- Features -->
            <div class="max-w-6xl mx-auto">
                <div id="hs-pin-leaflet" class="h-[430px] hs-leaflet z-10 rounded-[1rem] ring-1 ring-neutral-600 dark:ring-neutral-500"></div>
            </div>
            <!-- End Features -->
        </div>

        <div class="mt-12 grid items-center lg:grid-cols-2 gap-6 lg:gap-16">
            <!-- Card -->
            <div class="flex flex-col border border-gray-200 rounded-xl p-4 sm:p-6 lg:p-8 dark:border-neutral-700">
            <h2 class="mb-8 text-xl font-semibold text-gray-800 dark:text-neutral-200">
                Fill in the form
            </h2>

            <form>
                <div class="grid gap-4">
                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                    <label for="hs-firstname-contacts-1" class="sr-only">First Name</label>
                    <input type="text" name="hs-firstname-contacts-1" id="hs-firstname-contacts-1" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="First Name">
                    </div>

                    <div>
                    <label for="hs-lastname-contacts-1" class="sr-only">Last Name</label>
                    <input type="text" name="hs-lastname-contacts-1" id="hs-lastname-contacts-1" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Last Name">
                    </div>
                </div>
                <!-- End Grid -->

                <div>
                    <label for="hs-email-contacts-1" class="sr-only">Email</label>
                    <input type="email" name="hs-email-contacts-1" id="hs-email-contacts-1" autocomplete="email" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Email">
                </div>

                <div>
                    <label for="hs-phone-number-1" class="sr-only">Phone Number</label>
                    <input type="text" name="hs-phone-number-1" id="hs-phone-number-1" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Phone Number">
                </div>

                <div>
                    <label for="hs-about-contacts-1" class="sr-only">Details</label>
                    <textarea id="hs-about-contacts-1" name="hs-about-contacts-1" rows="4" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Details"></textarea>
                </div>
                </div>
                <!-- End Grid -->

                <div class="mt-4 grid">
                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">Send inquiry</button>
                </div>


            </form>
            </div>
            <!-- End Card -->

            <div class="divide-y divide-gray-200 dark:divide-neutral-800">

            </div>
        </div>
        </div>
    </div>
    <!-- End Contact Us -->

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                (function () {

                    // var littleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.'),
                    //     denver    = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.'),
                    //     aurora    = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.'),
                    //     golden    = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.');

                    const map = L.map('hs-pin-leaflet', {
                        center: [10.885, 123.075],
                        zoom: 13,
                        // maxBounds: [
                        //     [10.83, 122.98], // Slightly more southwest
                        //     [10.94, 123.17]  // Slightly more northeast
                        // ],
                        // maxBoundsViscosity: 0.4
                    });

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        minZoom: 2,
                        attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(map);

                    // Define a variable to hold the single marker
                    let singleMarker;

                    // Add marker on click, and update it if it already exists
                    map.on('click', function (e) {
                        const { lat, lng } = e.latlng;

                        if (singleMarker) {
                            // If marker exists, just move and update the popup
                            singleMarker.setLatLng([lat, lng])
                                .setPopupContent(`You clicked at:<br><strong>${lat.toFixed(5)}, ${lng.toFixed(5)}</strong>`)
                                .openPopup();
                        } else {
                            // If no marker yet, create a new one
                            singleMarker = L.marker([lat, lng])
                                .addTo(map)
                                .bindPopup(`You clicked at:<br><strong>${lat.toFixed(5)}, ${lng.toFixed(5)}</strong>`)
                                .openPopup();
                        }
                    });

                })();
            });
        </script>
    @endpush
</div>
