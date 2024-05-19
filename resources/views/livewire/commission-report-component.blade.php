<div >



        <table class=" w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

            <caption class="p-5  text-center  text-gray-900 rounded-t-xl  bg-white ">
                <span class="text-xl font-bold">
                    Commission Report
                </span>



                <div class="border rounded-md px-4 py-2 mt-4">

                    <p class="text-left font-semibold">Filter</p>


                    <form wire:submit.prevent="render" class="flex flex-row items-center my-4 gap-4">
                        <div class="relative w-full text-left">
                            <label for="distributor" class="text-sm font-light text-left">Distributor</label>
                            <input type="text" id="distributor" wire:model="distributor"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter ID, First Name, or Last Name">
                        </div>
                        <div class="relative w-full text-left">
                            <label for="fromDate" class="text-sm font-light text-left">From Date</label>
                            <input type="date" id="fromDate" wire:model="fromDate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5">
                        </div>
                        <div class="relative w-full text-left">
                            <label for="toDate" class="text-sm font-light text-left">To Date</label>
                            <input type="date" id="toDate" wire:model="toDate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center mt-3 py-2.5 px-3 ml-2 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>Search
                        </button>
                        <button type="button" wire:click="clearFilters"
                            class="inline-flex w-80 items-center mt-3 py-2.5 px-3 ml-2 text-sm font-medium text-red-700 bg-white-700 rounded-lg border border-red-700 hover:bg-red-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Clear filter
                        </button>

                    </form>
                </div>
            </caption>


            <thead class="text-xs text-white uppercase bg-red-700  ">
                <tr>

                    <th scope="col" class="px-6 py-3">
                        Invoice
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Purchaser
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Distributor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Referred Distributor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Order Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Order Total
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Percentage
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Distributor's Commission
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="">

                @foreach ($orders as $order)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $order['invoice_number'] }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $order['purchaser'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order['distributor'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order['referred_distributors'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order['order_date'] }}
                        </td>
                        <td class="px-6 py-4">
                            ${{ number_format($order['order_total'], 2) }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $order['commission_percentage'] }}%
                        </td>
                        <td class="px-6 py-4">
                            ${{ number_format($order['commission'], 2) }}
                        </td>
                        <td class="px-6 py-4">


                            <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                                wire:click.prevent="showOrderItems({{ $order['id'] }})"
                                class="block text-red-700 bg-white-700 hover:bg-red-700 hover:text-red-700  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                                type="button">
                                View items
                            </button>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-center items-center mt-3">
            {{ $orders->links() }}
        </div>


        <div id="default-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Invoice: @if ($orderItems)
                                {{ $orderItems->invoice_number }}
                            @endif
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            SKU
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Product name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($orderItems)



                                        @foreach ($orderItems->items as $item)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $item->product->sku }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $item->product->name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    ${{ number_format($item->product->price, 2) }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    ${{ number_format($item->quantity * $item->product->price, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                        <button data-modal-hide="default-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                    </div>
                </div>
            </div>
        </div>



</div>
