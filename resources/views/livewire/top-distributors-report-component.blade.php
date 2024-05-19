<div>



    <div class="relative overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption
                class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Top 200 Distributors
                <div class="border rounded-md px-4 py-2 mt-4">
                    <p class="text-left font-semibold">Filter</p>
                    <form wire:submit.prevent="render" class="flex flex-row items-center  my-4 gap-4">
                        <div class="relative w-full text-left">
                            <label for="rankNumber" class="text-sm font-light text-left">Rank Number</label>
                            <input type="number" id="rankNumber" wire:model="rankNumber"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter Rank Number">
                        </div>
                        <div class="relative w-full text-left">
                            <label for="firstName" class="text-sm font-light text-left">First Name</label>
                            <input type="text" id="firstName" wire:model="firstName"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter First Name">
                        </div>
                        <div class="relative w-full text-left">
                            <label for="lastName" class="text-sm font-light text-left">Last Name</label>
                            <input type="text" id="lastName" wire:model="lastName"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter Last Name">
                        </div>
                        <div class="relative w-full text-left">
                            <label for="totalSales" class="text-sm font-light text-left">Total Sales</label>
                            <input type="number" id="totalSales" wire:model="totalSales"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter Total Sales">
                        </div>
                        <a href="#" wire:click.prevent='clearFilters'
                            class="flex items-center w-80 mt-3 py-2.5 px-3 ml-2  text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Clear
                        </a>
                    </form>
                </div>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Top
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Distributor's Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Sales
                    </th>

                </tr>
            </thead>
            <tbody>

                @foreach ($distributors as $distributor)
                    @if ($distributor)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $distributor['rank'] }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $distributor['name'] }}
                            </td>
                            <td class="px-6 py-4">
                                ${{ number_format($distributor['total_sales'], 2) }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                No found
                            </td>
                        </tr>
                    @endif
                @endforeach

            </tbody>

        </table>
        <div class="bg-white py-4 flex justify-center">
            {{ $distributors->links() }}
        </div>


    </div>



</div>
