<ul class="">
    @php
        $level++
    @endphp
    @for ($i = 1; $i <= config('genealogy.children', 2); $i++)
        <li class="position-{{ $i }}">
            @php
                unset($descendant);
                if ($level > 1){
                    $descendant = $descendants->firstWhere('position', $i);
                }elseif (isset($descendants[$i])){
                    $descendant = $descendants[$i];
                }
            @endphp
            @if (isset($descendant))
                @php
                    if(!isset($descendant->active_packages_count)){
                        $descendant->active_packages_count = $descendant->activePackages()->count(); // TODO: not an efficient way
                    }
                    $params['user'] = $descendant;
                @endphp
                <a href="{{ $level === 3 ? URL::signedRoute('admin.genealogy', $params) : 'javascript:void(0)' }}" @class(["next-genealogy" => $level === 3])>
                    @include('backend.user.genealogy.includes.genealogy-card', ['user' => $descendant])
                </a>
                @if($level <= 2)
                    @include('backend.admin.genealogy.includes.genealogy-tree-ul', ['descendants' => $descendant->children ,'params' => $params, 'level' => $level])
                @endif
            @else

                <a href="javascript:void(0)">
                    <div class="genealogy item">
                        <div class="card">
                            <div class="card-img-empty">
                                <img class="card-img2  card-img2-mob" src="{{ asset('assets/backend/images/user-icon.jpg') }}" alt="">
                            </div>
                            <div class="card-info info-empty">
                                <h5 class="text-title">Empty</h5><br>
                                <p class="text-body">Add your new member</p>
                            </div>
                        </div>
                    </div>
                </a>

            @endif
        </li>
    @endfor

</ul>
