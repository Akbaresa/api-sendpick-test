<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetJobOrderRequest;
use App\Models\JobOrder;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Services\DistanceAndCostService;
class JobOrderController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/job-orders",
     *     summary="Get Job Orders (search, sort, pagination)",
     *     description="Menampilkan daftar Job Orders dengan fitur search, sort, dan pagination",
     *     tags={"Job Orders"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan job number atau customer name",
     *         required=false,
     *         @OA\Schema(type="string", example="JO-001")
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Kolom untuk sorting",
     *         required=false,
     *         @OA\Schema(type="string", example="created_at")
     *     ),
     *     @OA\Parameter(
     *         name="sort_dir",
     *         in="query",
     *         description="Arah sorting (asc|desc)",
     *         required=false,
     *         @OA\Schema(type="string", example="desc")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Jumlah data per halaman",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daftar job orders berhasil diambil"
     *     )
     * )
     */
    public function index(GetJobOrderRequest $request)
    {
        try {
            $validated = $request->validated();

            $search   = $validated['search'] ?? null;
            $sortBy   = $validated['sort_by'] ?? 'job_orders.created_at';
            $sortDir  = $validated['sort_dir'] ?? 'desc';
            $perPage  = $validated['per_page'] ?? 10;

            $query = DB::table('job_orders')
                ->select([
                    'job_orders.id_job_order',
                    'job_orders.job_number',
                    'job_orders.customer_name',
                    'job_orders.created_at',
                    'status_job_orders.status_job_order_name as status_name',
                    'users.name as driver_name',
                    'vehicles.plate_number as vehicle_plate',
                ])
                ->leftJoin('status_job_orders', 'status_job_orders.id_status_job_order', '=', 'job_orders.status_job_order_id')
                ->leftJoin('users', 'users.id_user', '=', 'job_orders.driver_id')
                ->leftJoin('vehicles', 'vehicles.id_vehicle', '=', 'job_orders.vehicle_id')
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($q) use ($search) {
                        $q->where('job_orders.job_number', 'like', "%{$search}%")
                        ->orWhere('job_orders.customer_name', 'like', "%{$search}%")
                        ->orWhere('users.name', 'like', "%{$search}%");
                    });
                })
                ->orderBy($sortBy, $sortDir);

            $jobOrders = $query->paginate($perPage);

            return $this->success($jobOrders, 'Job Order Terkirim');
        } catch (\Throwable $e) {
            return $this->error('Job Gagal Terkirim', 500);
        }
    }

    public function show($id)
    {
        try {
            $jobOrder = DB::table('job_orders')
                ->select([
                    'job_orders.id_job_order',
                    'job_orders.job_number',
                    'job_orders.customer_name',
                    'job_orders.pickup_address',
                    'job_orders.destination_address',
                    'job_orders.total_weight',
                    'job_orders.total_volume',
                    'job_orders.created_at',
                    'status_job_orders.status_job_order_name as status_name',
                    'users.name as driver_name',
                    'vehicles.plate_number as vehicle_plate',
                ])
                ->leftJoin('status_job_orders', 'status_job_orders.id_status_job_order', '=', 'job_orders.status_job_order_id')
                ->leftJoin('users', 'users.id_user', '=', 'job_orders.driver_id')
                ->leftJoin('vehicles', 'vehicles.id_vehicle', '=', 'job_orders.vehicle_id')
                ->where('job_orders.id_job_order', $id)
                ->first();

            if (!$jobOrder) {
                return $this->error('Job Order tidak ditemukan', 404);
            }

            $manifests = DB::table('manifests')
                ->select([
                    'id_manifest',
                    'item_name',
                    'quantity',
                    'weight',
                    'volume',
                    'notes',
                    'created_at'
                ])
                ->where('job_order_id', $id)
                ->get();

            $locations = DB::table('locations')
                ->select([
                    'id_location',
                    'type',
                    'address',
                    'lat',
                    'lng',
                    'city',
                    'province',
                    'city_id',
                    'province_id',
                    'created_at'
                ])
                ->where('job_order_id', $id)
                ->get();

            $data = [
                'job_order' => $jobOrder,
                'manifests' => $manifests,
                'locations' => $locations,
            ];

            return $this->success($data, 'Detail Job Order berhasil diambil');
        } catch (\Throwable $e) {
            return $this->error('Gagal mengambil detail Job Order: ' . $e->getMessage(), 500);
        }
    }

    public function showDistanceAndCost($id){
        try {
            $service = new DistanceAndCostService();
            $result = $service->calculateForJobOrder($id);

            return $this->success($result, 'Berhasil menampilkan jarak dan ongkir');
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }


}
