<?php
namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class CommissionReportComponent extends Component
{
    use WithPagination;

    public $orderItems = null;
    public $distributor = '';
    public $fromDate = null;
    public $toDate = null;

    protected $queryString = [
        'distributor' => ['except' => ''],
        'fromDate' => ['except' => null],
        'toDate' => ['except' => null],
    ];

    public function render()
    {
        // Eager load relationships: customer, customer's referrer, referrer's categories, and items with products
        $query = Order::with(['customer', 'customer.referrer', 'customer.referrer.categories', 'items.product']);

        // Apply filters
        if ($this->distributor) {
            $query->whereHas('customer.referrer', function ($q) {
                $q->where('first_name', 'like', '%' . $this->distributor . '%')
                  ->orWhere('last_name', 'like', '%' . $this->distributor . '%')
                  ->orWhere('id', $this->distributor);
            });
        }

        if ($this->fromDate) {
            $query->whereDate('order_date', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query->whereDate('order_date', '<=', $this->toDate);
        }

        $orders = $query->paginate(10)
            ->through(function ($order) {
                $customer = $order->customer;
                $referrer = $order->customer->referrer;

                // Initialize variables
                $referrerDistributorsCount = 0;
                $commissionPercentage = 0;
                $distributorName = '';

                // Check if the customer is a valid customer
                $isCustomer = $customer->categories->contains('name', 'Customer');

                // Check if the referrer exists and is a distributor
                if ($isCustomer && $referrer) {
                    $isDistributor = $referrer->categories->contains('name', 'Distributor');
                    if ($isDistributor) {
                        $distributorName = $referrer->first_name . ' ' . $referrer->last_name;
                        $referrerDistributorsCount = $referrer->referredDistributors()
                            ->whereHas('categories', function ($query) {
                                $query->where('name', 'Distributor');
                            })
                            ->where('enrolled_date', '<=', $order->order_date)
                            ->count();

                        $commissionPercentage = $this->calculateCommissionPercentage($referrerDistributorsCount);
                    }
                }

                $orderTotal = $order->items->sum(function ($item) {
                    return $item->product ? $item->quantity * $item->product->price : 0;
                });

                $commission = $commissionPercentage * $orderTotal / 100;

                return [
                    'id' => $order->id,
                    'invoice_number' => $order->invoice_number,
                    'purchaser' => $order->customer->first_name . ' ' . $order->customer->last_name,
                    'distributor' => $distributorName,
                    'referred_distributors' => $referrerDistributorsCount,
                    'order_date' => $order->order_date,
                    'commission_percentage' => $commissionPercentage,
                    'order_total' => $orderTotal,
                    'commission' => $commission,
                ];
            });

        return view('livewire.commission-report-component', [
            'orders' => $orders
        ])->layout('layouts.home');
    }

    private function calculateCommissionPercentage($referrerDistributorsCount)
    {
        if ($referrerDistributorsCount >= 30) {
            return 30;
        } elseif ($referrerDistributorsCount >= 21) {
            return 20;
        } elseif ($referrerDistributorsCount >= 11) {
            return 15;
        } elseif ($referrerDistributorsCount >= 5) {
            return 10;
        } else {
            return 5;
        }
    }

    public function showOrderItems($id)
    {
        // Load the order with its items and their associated products
        $this->orderItems = Order::with('items.product')->where('id', $id)->first();
        
    }

    public function closeOrderItems()
    {
        $this->orderItems = null;
    }

    public function updated($propertyName)
    {
        $this->resetPage();
    }

     // Method to clear filters
     public function clearFilters()
     {
         $this->reset(['distributor', 'fromDate', 'toDate']);
     }
}
