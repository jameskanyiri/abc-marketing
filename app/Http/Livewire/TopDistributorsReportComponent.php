<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Collection;

class TopDistributorsReportComponent extends Component
{
    use WithPagination;

    public $rankNumber;
    public $firstName;
    public $lastName;
    public $totalSales;


    protected $queryString = [
        'rankNumber' => ['except' => ''],
        'firstName' => ['except' => ''],
        'lastName' => ['except' => ''],
        'totalSales' => ['except' => ''],
    ];

    public function render()
    {
        // Fetch all distributors who have referred orders
        $distributors = User::whereHas('categories', function ($query) {
                $query->where('name', 'Distributor');
            })
            ->with(['referredOrders.items.product'])
            ->get()
            ->map(function ($distributor) {
                // Calculate total sales for the distributor
                $totalSales = $distributor->referredOrders->sum(function ($order) {
                    return $order->items->sum(function ($item) {
                        return $item->product ? $item->quantity * $item->product->price : 0;
                    });
                });

                return [
                    'id' => $distributor->id,
                    'first_name' => $distributor->first_name,
                    'last_name' => $distributor->last_name,
                    'name' => $distributor->first_name . ' ' . $distributor->last_name,
                    'total_sales' => $totalSales,
                ];
            })
            ->sortByDesc('total_sales')
            ->values();

        // Add rank to distributors
        $rankedDistributors = $this->addRankToDistributors($distributors);

        // Filter to only include the top 200 distributors
        $topRankedDistributors = $rankedDistributors->filter(function ($distributor) {
            return $distributor['rank'] <= 200;
        });

        // Apply filters
        if ($this->rankNumber) {
            $topRankedDistributors = $topRankedDistributors->filter(function ($distributor) {
                return $distributor['rank'] == $this->rankNumber;
            });
        }

        if ($this->firstName) {
            $topRankedDistributors = $topRankedDistributors->filter(function ($distributor) {
                return stripos($distributor['first_name'], $this->firstName) !== false;
            });
        }

        if ($this->lastName) {
            $topRankedDistributors = $topRankedDistributors->filter(function ($distributor) {
                return stripos($distributor['last_name'], $this->lastName) !== false;
            });
        }

        if ($this->totalSales) {
            $topRankedDistributors = $topRankedDistributors->filter(function ($distributor) {
                return $distributor['total_sales'] == $this->totalSales;
            });
        }

        // Paginate the top ranked distributors
        $page = $this->page ?? 1;
        $perPage = 10;
        $paginatedDistributors = $this->paginate($topRankedDistributors, $perPage, $page);

        return view('livewire.top-distributors-report-component', [
            'distributors' => $paginatedDistributors,
        ])->layout('layouts.home');
    }

    private function addRankToDistributors(Collection $distributors)
    {
        $rankedDistributors = collect();
        $currentRank = 1;
        $previousSales = null;
        $offset = 0;

        foreach ($distributors as $index => $distributor) {
            if ($previousSales !== $distributor['total_sales']) {
                $currentRank = $index + 1 - $offset;
            } else {
                $offset++;
            }

            $rankedDistributors->push(array_merge($distributor, ['rank' => $currentRank]));
            $previousSales = $distributor['total_sales'];
        }

        return $rankedDistributors;
    }

    private function paginate(Collection $items, $perPage, $page)
    {
        $offset = ($page - 1) * $perPage;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->slice($offset, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function updated($field)
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['rankNumber', 'firstName', 'lastName', 'totalSales']);
    }
}


   
