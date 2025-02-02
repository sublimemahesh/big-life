@php
    $params = request()->has('filter-user') ? ['filter-user' => request()->input('filter-user')] : [];
    $level = 0;
@endphp
<div class="row">
    <div class="col-sm-12 ">
        @if (!empty($user->parent_id) && config('fortify.super_parent_id') !== $user->id && request()->input('filter-user') !== $user->username)
            <div class="d-flex justify-content-center mb-md-2 mb-sm-5">
                @php
                    $params['user'] = $user->parent
                @endphp
                <a href="{{ URL::signedRoute('admin.genealogy', $params) }}" class="next-genealogy head-arrow">
                    <i class="fas fa-arrow-up fs-2"></i>
                </a>
            </div>
        @endif
    </div>
</div>

<div class="row mobile-margine">
    <div class="col-sm-12 add-tree">
        <div class="tree">
            <ul class="">
                <li class="">
                    <a href="javascript:void(0)" class="add-tree-2" class="next-genealogy">
                        @include('backend.user.genealogy.includes.genealogy-card', compact('user'))
                    </a>
                    @include('backend.admin.genealogy.includes.genealogy-tree-ul', compact('descendants','params', 'level'))
                </li>
            </ul>
        </div>
    </div>
</div>
