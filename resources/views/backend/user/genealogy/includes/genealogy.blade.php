@php
    $level = 0;
@endphp
<div class="row">
    <div class="col-sm-12 ">
        @if (!empty($user->parent_id) && Auth::user()->id !== $user->id)
            <div class="d-flex justify-content-center mb-md-2 mb-sm-5">
                <a href="{{ route('user.genealogy', $user->parent) }}" class="next-genealogy head-arrow">
                    <i class="fas fa-arrow-up fs-2"></i>
                </a>
            </div>
        @endif
    </div>
</div>
<div>
    <div class="col-sm-12 add-tree">
        <br><br>
        <div class="tree">
            <ul>
                <li>
                    <a href="javascript:void(0)" class="add-tree-2">
                        @include('backend.user.genealogy.includes.genealogy-card', compact('user'))
                    </a>
                    @include('backend.user.genealogy.includes.genealogy-tree-ul', compact('descendants', 'level'))
                </li>
            </ul>
        </div>
    </div>
</div>

