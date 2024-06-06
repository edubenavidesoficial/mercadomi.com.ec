<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Libraries\AppLibrary;
use App\Services\ProductService;
use App\Services\DashboardService;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrderSummaryResource;
use App\Http\Resources\SalesSummaryResource;
use App\Http\Resources\SimpleProductResource;
use App\Http\Resources\CustomerStatesResource;
use App\Http\Resources\OrderStatisticsResource;

class DashboardController extends AdminController
{
    private DashboardService $dashboardService;
    private ProductService $productService;

    public function __construct(DashboardService $dashboardService, ProductService $productService)
    {
        parent::__construct();
        $this->dashboardService = $dashboardService;
        $this->productService      = $productService;
        $this->middleware(['permission:dashboard'])->only(
            'orderStatistics',
            'orderSummary',
            'featuredItems',
            'topCustomers',
            'totalSales',
            'salesSummary',
            'customerStates',
            'totalOrders',
            'totalCustomers',
            'totalProducts'
        );
    }

    public function totalSales(): \Illuminate\Http\Response | array | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ['data' => ['total_sales' => AppLibrary::currencyAmountFormat($this->dashboardService->totalSales())]];
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function totalOrders(): \Illuminate\Http\Response | array | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ['data' => ['total_orders' => $this->dashboardService->totalOrders()]];
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function totalCustomers(): \Illuminate\Http\Response | array | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ['data' => ['total_customers' => $this->dashboardService->totalCustomers()]];
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function totalProducts(): \Illuminate\Http\Response | array | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ['data' => ['total_products' => $this->dashboardService->totalProducts()]];
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function orderStatistics(
        Request $request
    ): \Illuminate\Http\Response | OrderStatisticsResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory {
        try {
            return new OrderStatisticsResource($this->dashboardService->orderStatistics($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function salesSummary(
        Request $request
    ): \Illuminate\Http\Response | SalesSummaryResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory {
        try {
            return new SalesSummaryResource($this->dashboardService->salesSummary($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function orderSummary(
        Request $request
    ): \Illuminate\Http\Response | OrderSummaryResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory {
        try {
            return new OrderSummaryResource($this->dashboardService->orderSummary($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function customerStates(
        Request $request
    ): \Illuminate\Http\Response | CustomerStatesResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory {
        try {
            return new CustomerStatesResource($this->dashboardService->customerStates($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function topCustomers(): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return UserResource::collection($this->dashboardService->topCustomers());
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function topProducts(): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return SimpleProductResource::collection($this->productService->topProducts());
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}