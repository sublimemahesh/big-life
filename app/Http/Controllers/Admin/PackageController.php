<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class PackageController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Package::class);
        $packages = Package::latest()->get();
        return view('backend.admin.packages.index', compact('packages'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', Package::class);

        $data = $request->all();
        $data['is_active'] = $request->get('is_active') === 'on';

        $validated = Validator::make($data, [
            'name' => 'required|max:250|unique:packages,name',
            'amount' => 'required|numeric|min:0',
            'gas_fee' => 'nullable|numeric|min:0',
            'bv_points' => 'nullable|numeric|min:0',
            'daily_max_out_limit' => 'nullable|numeric|min:0',
            'month_of_period' => 'required|integer',
            'daily_leverage' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ])->validate();

        Package::create($validated);

        $json['status'] = true;
        $json['message'] = 'New Package created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);

    }


    public function edit(Package $package)
    {
        $this->authorize('update', $package);

        return view('backend.admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $this->authorize('update', $package);

        $data = $request->all();
        $data['is_active'] = $request->get('is_active') === 'on';

        $validated = Validator::make($data, [
            'name' => ['required', 'max:250', Rule::unique('packages', 'name')->ignore($package->id)],
            'amount' => 'required|numeric|min:0',
            'gas_fee' => 'nullable|numeric|min:0',
            'bv_points' => 'nullable|numeric|min:0',
            'daily_max_out_limit' => 'nullable|numeric|min:0',
            'month_of_period' => 'required|integer',
            'daily_leverage' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ])->validate();

        $package->update($validated);

        $json['status'] = true;
        $json['message'] = 'Package updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(Package $package)
    {
        $this->authorize('delete', $package);

        $package->delete();

        $json['status'] = true;
        $json['message'] = 'Package deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $package;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function sort()
    {
        $this->authorize('update', Package::class);
        $packages = Package::orderBy('order')->get();
        return view('backend.admin.packages.arrange', compact('packages'));
    }

    public function storeSort(Request $request)
    {
        $this->authorize('update', Package::class);
        if ($request->has('ids')) {
            foreach ($request->get('ids') as $sortOrder => $id) {
                Package::find($id)->update([
                    "order" => $sortOrder
                ]);
            }
            return ['status' => true, 'message' => 'Arrange success', "icon" => 'success'];
        }
        return response()->json(['status' => false, 'message' => 'Something went wrong', "icon" => 'danger']);
    }
    /*public function buypackage()
    {
        $packages = Package::activePackages()->get();
        return view('backend.admin.packages.buy_package', compact('packages'));
    }*/

}
