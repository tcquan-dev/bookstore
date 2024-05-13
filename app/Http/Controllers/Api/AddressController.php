<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Address;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;

class AddressController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->user = JWTAuth::parseToken($request->bearerToken())->authenticate();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AddressCollection::collection($this->user->addresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'phone_number' => 'required|numeric|min:10',
                'address' => 'required|string'
            ]);

            if ($request->post('default') == 1) {
                $default = Address::where('default', 1)->first();
                if ($default) {
                    $default->update([
                        'default' => false
                    ]);
                }
            }

            $address = Address::create([
                'user_id' => $this->user->id,
                'name' => $request->post('name'),
                'phone_number' => $request->post('phone_number'),
                'address' => $request->post('address'),
                'default' => $request->post('default')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm địa chỉ giao hàng thành công!',
                'data' => new AddressCollection($address)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $address = $this->user->addresses->find($id);
        if ($address) {
            return new AddressCollection($address);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy địa chỉ giao hàng!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string',
                'phone_number' => 'numeric|min:10',
                'address' => 'string'
            ]);

            $address = $this->user->addresses->find($id);

            if ($request->post('default') == 1) {
                $default = Address::where('default', 1)->first();
                if ($default) {
                    $default->update([
                        'default' => false
                    ]);
                }
            }

            $addressData = [
                'name' => $request->post('name'),
                'phone_number' => $request->post('phone_number'),
                'address' => $request->post('address'),
                'default' => $request->post('default')
            ];

            $addressData = array_filter($addressData, function ($value) {
                return $value !== null;
            });

            if (!empty($addressData)) {
                $address->update($addressData);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin người dùng thành công!',
                'data' => new AddressCollection($address)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $address = $this->user->addresses->find($id);
        if ($address) {
            $address->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xoá địa chỉ giao hàng thành công!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy địa chỉ giao hàng!'
            ], 404);
        }
    }
}
