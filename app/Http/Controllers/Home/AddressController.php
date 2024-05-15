<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;
use App\Models\Address;
use Exception;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = backpack_auth()->user();

            if ($request->post('default') == 1) {
                $default = Address::where('default', 1)->first();
                if ($default) {
                    $default->update([
                        'default' => 0
                    ]);
                }
            }

            $addressData = [
                'user_id' => $user->id,
                'name' => $request->post('name'),
                'phone_number' => $request->post('phone_number'),
                'address' => $request->post('address'),
                'default' => $request->post('default')
            ];

            Address::create($addressData);

            $addresses = $user->addresses;

            return response()->json([
                'success' => true,
                'html' => view('forms.address.list_address', [
                    'addresses' => $addresses
                ])->render(),
                'message' => 'Tạo địa chỉ giao hàng thành công!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $address = Address::findOrFail($id);
            return response()->json([
                'success' => true,
                'form' => view('forms.address.update_form', compact('address'))->render()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = backpack_auth()->user();

            $address = Address::findOrFail($id);

            if ($request->post('default') == 1) {
                $default = Address::where('default', 1)->first();
                if ($default) {
                    $default->update([
                        'default' => 0
                    ]);
                }
            }

            $address->update($request->all());

            $addresses = $user->addresses;

            return response()->json([
                'success' => true,
                'html' => view('forms.address.list_address', [
                    'addresses' => $addresses
                ])->render(),
                'message' => 'Cập nhật địa chỉ giao hàng thành công!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $address = Address::find($id);
            if ($address) {
                $address->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Xoá địa chỉ giao hàng thành công!'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
