<?php

namespace App\Http\Controllers;

use App\Enums\BinaryPlaceEnum;
use App\Http\Resources\Select2UserResource;
use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        $sponsor = new User;

        $position = null;

        if ($request->get('ref', false)) {

            $request->validate([
                'position' => ['required', new Enum(BinaryPlaceEnum::class)],
            ]);

            $position = $request->enum('position', BinaryPlaceEnum::class);
            // abort_if(!$request->hasValidSignature(), Response::HTTP_UNAUTHORIZED, 'Invalid referral link!');
            $parent = $request->get('ref', null);
            $sponsor = User::whereUsername($parent)
                ->whereRelation('roles', 'name', 'user')
                ->where(function ($q) {
                    $q->where(function ($q) {
                        $q->where('username', '<>', config('fortify.super_parent_username'))
                            ->whereNotNull('position')->whereNotNull('parent_id');
                    })->orWhere('username', config('fortify.super_parent_username'));
                })
                ->whereHas('purchasedPackages')
                ->firstOrFail();
        }

        return view('auth.register', compact('sponsor', 'position'));
    }

    public function findUsers($search_text): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            ->whereRelation('roles', 'name', 'user')
            ->where(function ($q) {
                $q->where(function ($q) {
                    $q->where('id', '<>', config('fortify.super_parent_id'))
                        ->whereNotNull('super_parent_id');
                })->orWhere('id', config('fortify.super_parent_id'));
            })
            ->whereHas('purchasedPackages')
            ->get();
        return Select2UserResource::collection($users);
    }

    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
        abort(Response::HTTP_SERVICE_UNAVAILABLE);

        event(new Registered($user = $creator->create($request->all())));
        Auth::login($user);
        return app(RegisterResponse::class);
    }
}
