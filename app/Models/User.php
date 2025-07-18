<?php

namespace App\Models;

use App\Enums\BinaryPlaceEnum;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use JsonException;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Throwable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use Loggable;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use softDeletes, CascadeSoftDeletes;
    use HasRecursiveRelationships;

    protected $with = ['profile'];

    protected array $cascadeDeletes = ['ranks'];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'phone_verified_at', 'super_parent_id', 'parent_id', 'username', 'position', 'suspended_at',
        'left_points_balance', 'right_points_balance'
    ];

    public function sendEmailVerificationNotification(): void
    {
        // Check if the last OTP request time is stored in the session
        $lastOTPRequestTime = session("{$this->id}_send_email_verification_notification_last_otp_requested_at");

        if ($lastOTPRequestTime && now()->diffInMinutes($lastOTPRequestTime) < 5) {
            // Calculate the remaining time until they can request a new OTP
            $remainingTime = 5 - now()->diffInMinutes($lastOTPRequestTime);

            // Add an error with the remaining time
            session()->flash('error', "We have sent the email verification link to your email address. " .
                "If you do not receive the email, kindly wait for {$remainingTime} minutes. " .
                "Please refrain from resending verification emails until the specified time has passed.");
            return;
        }
        $this->notify(new VerifyEmail);
        session()->flash('message', __('A new verification link has been sent to the email address you provided in your profile settings.'));
        session(["{$this->id}_send_email_verification_notification_last_otp_requested_at" => now()]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    public array $exclude = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'two_factor_confirmed_at',
        'current_team_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        /*'depth',
        'highest_rank',*/
        'profile_photo_url',
        'referral_link',
        'profile_info'
    ];

    public function getProfileInfoAttribute()
    {
        $profile = $this->profile;
        return $this->profile_info = $profile->toArray();
    }

    public function getAddressAttribute()
    {

        return $this->address = ($this->profile->address . ', ') . ($this->profile->state . ', ') . $this->profile->zip_code;
    }

    public function getProfileIsCompleteAttribute(): bool
    {
        $required = ['street', 'state', 'address', 'zip_code', 'home_phone', 'recover_email', 'gender', 'dob'];
        $is_complete = true;
        foreach ($required as $iValue) {
            if ($this->profile[$iValue] === null) {
                $is_complete = false;
            }
        }
        return $is_complete;
    }

    public function getIsSuspendedAttribute(): bool
    {
        return $this->suspended_at !== null;
    }

    public function getIsMobileVerifiedAttribute(): bool
    {
        return $this->phone_verified_at !== null;
    }

    public function getReferralLinkAttribute(): string
    {
        return $this->referral_link = route('register', ['ref' => $this->username]);
    }

    protected function leftReferralLink(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => route('register', ['ref' => $this->username, 'position' => BinaryPlaceEnum::LEFT]),
        );
    }

    protected function rightReferralLink(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => route('register', ['ref' => $this->username, 'position' => BinaryPlaceEnum::RIGHT]),
        );
    }

    public function getActiveDateAttribute(): string|null
    {
        $firstPackage = $this->purchasedPackages()->orderBy('created_at')->firstOrNew()->created_at;
        if ($firstPackage) {
            return $firstPackage->format('Y-m-d');
        }
        return null;
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->purchasedPackages()->activePackages()->count() >= 1;
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(self::class, 'super_parent_id', 'id')->withDefault();
    }

    public function directSales(): HasMany
    {
        return $this->hasMany(self::class, 'super_parent_id', 'id')->whereNotNull('parent_id');
    }

    public function directSalesWithInactive(): HasMany
    {
        return $this->hasMany(self::class, 'super_parent_id', 'id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id')->withDefault(new Wallet);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault(new Profile);
    }

    public function purchasedPackages(): HasMany
    {
        return $this->hasMany(PurchasedPackage::class, 'user_id', 'id');
    }

    public function activePackages(): HasMany
    {
        return $this->purchasedPackages()
            ->activePackages()
            ->orderByDesc('invested_amount') // highest first
            ->oldest();  // older first if same amount
    }

    public function highestInvestedPackage(): HasMany
    {
        return $this->purchasedPackages()
            ->activePackages()
            ->orderByDesc('invested_amount')
            ->oldest()
            ->limit(1);
    }

    public function getEffectiveDailyMaxOutLimitAttribute(): float
    {
        $highest = $this->highestInvestedPackage()->first();

        return $highest?->daily_max_out_limit
            ?? $highest?->packageRef?->daily_max_out_limit
            ?? 0;
    }

    public function maxedOutBvPoints(): HasMany
    {
        return $this->hasMany(MaxedOutBvPoint::class, 'user_id', 'id');
    }

    public function descendantPackages(): \Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\HasManyOfDescendants
    {
        return $this->hasManyOfDescendants(PurchasedPackage::class, 'user_id', 'id');
    }

    public function descendantActivePackages(): \Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\HasManyOfDescendants
    {
        return $this->descendantPackages()->activePackages();
    }

    public function earnings(): HasMany
    {
        return $this->hasMany(Earning::class, 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function totalInvestment(): HasMany
    {
        return $this->purchasedPackages()->totalInvestment($this);
    }

    public function bvPointEarnings(): HasMany
    {
        return $this->hasMany(BvPointEarning::class, 'user_id');
    }

    public function bvPointRewards(): HasMany
    {
        return $this->hasMany(BvPointReward::class, 'user_id');
    }

    public function getDepthAttribute()
    {
        $depth = DB::selectOne(
            "WITH RECURSIVE user_tree AS (
                      SELECT id, parent_id, 1 as depth
                      FROM users
                      WHERE parent_id IS NULL -- Find the root node(s) of the tree
                      UNION ALL
                      SELECT u.id, u.parent_id, t.depth + 1 as depth
                      FROM users u
                      JOIN user_tree t ON u.parent_id = t.id
                   )
                   SELECT depth FROM user_tree WHERE id = :id",
            ['id' => $this->id]
        );

        return optional($depth)->depth;
    }

    public static function findAvailableSubLevel($nodeId)
    {
        return DB::selectOne("
                WITH RECURSIVE ancestor_nodes AS
                (
                    (SELECT *, 1 as path FROM users WHERE id = :node_id)
                    UNION ALL
                    (SELECT n.*, an.path + 1 as path FROM users n INNER JOIN ancestor_nodes an ON an.id = n.parent_id)
                )

                SELECT
                    cte_an.id,
                    cte_an.path,
                    cte_an.parent_id,
                    (SELECT `position` FROM users WHERE id = cte_an.parent_id) AS parent_node_position,
                    cte_an.`position`,
                    (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id) AS children_count
                FROM
                    ancestor_nodes cte_an
                WHERE
                    (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id) < 5
                ORDER BY
                    path ASC,
                    parent_node_position  ASC ,
                    cte_an.`parent_id` ASC ,
                    cte_an.`position` ASC  LIMIT 1",
            ['node_id' => $nodeId]);
    }

    public static function findAvailableBinaryPlacement($nodeId, BinaryPlaceEnum $position)
    {
        return DB::selectOne("
                WITH RECURSIVE ancestor_nodes AS
                (
                    SELECT  *, 1 AS path  FROM  users  WHERE  id = :selected_super_parent
                    UNION ALL
                    SELECT  n.*,  an.path + 1 AS path FROM users n INNER JOIN ancestor_nodes an ON an.id = n.parent_id WHERE n.position = :prioritize_position
                )

                SELECT
                    cte_an.id,
                    cte_an.path,
                    cte_an.parent_id,
                    (SELECT `position` FROM users WHERE id = cte_an.parent_id) AS parent_node_position,
                    cte_an.`position`,
                    (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id) AS children_count,
                    :available_position AS available_position -- Dynamic selected position (1 for left, 2 for right)
                FROM
                    ancestor_nodes cte_an
                WHERE
                    -- Ensure the parent has fewer than 2 children (binary tree constraint)
                    (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id) < :genealogy_children
                     -- Ensure the selected position is available for the parent
                    AND (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id AND position = :selected_position) = 0
                ORDER BY
                    -- Prioritize parents with the shortest path (closest to the super parent)
                    path ASC
                LIMIT 1;",
            [
                'selected_super_parent' => $nodeId,
                'prioritize_position' => $position->value,
                'available_position' => $position->value,
                'genealogy_children' => config('genealogy.children', 2),
                'selected_position' => $position->value,
            ]);
    }

    public function ranks(): HasMany
    {
        return $this->hasMany(Rank::class, 'user_id');
    }

    public function rank($rank): HasOne
    {
        return $this->hasOne(Rank::class, 'user_id')->where('rank', $rank);
    }

    public function rankGifts(): HasMany
    {
        return $this->hasMany(RankGift::class, 'user_id');
    }

    public function currentRank(): HasOne
    {
        return $this->hasOne(Rank::class, 'user_id')
            ->whereNotNull('activated_at')
            ->orderBy('rank', 'desc')
            ->withDefault(new Rank);
    }

    public function getMonthlyTotalTeamInvestmentAttribute()
    {
        $validator = \Validator::make(request()?->all(), [
            'month' => 'required|date_format:Y-m',
        ]);
        if ($validator->fails()) {
            $month = \Carbon::now();
        } else {
            $validated = $validator->validated();
            $month = \Carbon::parse($validated['month']);
        }
        $first_of_month = $month->firstOfMonth()->format('Y-m-d H:i:s');
        $last_of_month = $month->lastOfMonth()->format('Y-m-d H:i:s');

        if (!$month->isFuture() || $month::today()) {
            return PurchasedPackage::totalMonthlyTeamInvestment($this, $first_of_month, $last_of_month)
                ->sum('invested_amount');
        }
        return 0;
    }

    public function getTotalTeamInvestmentAttribute()
    {
        return PurchasedPackage::totalTeamInvestment($this)->sum('invested_amount');
    }

    public function getHighestRankAttribute(): int
    {
        $rank = $this->ranks()->whereNotNull('activated_at')->orderBy('rank', 'desc')->first();
        return $rank->rank ?? 0;
    }

    /**
     * @throws JsonException
     */
    public static function getUpgradeRequirements()
    {
        $strategy = Strategy::where('name', 'rank_package_requirement')
            ->firstOr(fn() => new Strategy(['value' => '{"3":{"active_investment":1000,"total_team_investment":5000},"4":{"active_investment":2500,"total_team_investment":10000},"5":{"active_investment":5000,"total_team_investment":25000},"6":{"active_investment":10000,"total_team_investment":50000},"7":{"active_investment":25000,"total_team_investment":100000}}']));
        return json_decode($strategy->value, false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws Throwable
     */
    public static function upgradeAncestorsRank(self $user, $rank, $position, $is_active = false): void
    {
        if ($rank > config('rank-system.rank_level_count', 10)) {
            return;
        }

        DB::transaction(function () use ($rank, $user, $is_active, $position) {

            if ($rank === 1) {

                $user_rank = Rank::firstOrCreate(
                    ['user_id' => $user->id, 'rank' => $rank],
                    ['eligibility' => 0, 'total_rankers' => 0]
                );

                $children_positions = $user->children()->select('position')->get()->pluck('position')->toArray();
                $current_eligibility_positions = $user_rank->eligibility_positions ? json_decode($user_rank->eligibility_positions, true, 512, JSON_THROW_ON_ERROR) : [];


                $eligibility = count($children_positions);
                $eligibility_positions = json_encode($children_positions, JSON_THROW_ON_ERROR);
                $is_active = $eligibility >= config('rank-system.rank_eligibility_activate_at', 3);
                $activated_at = $is_active ? now() : null;

                if (!$user_rank->is_active) {
                    $user_rank->update(compact('eligibility', 'eligibility_positions', 'activated_at'));

                    if ($is_active && (count(array_diff($children_positions, $current_eligibility_positions)) !== 0)) {
                        $user->ancestors()->chunk(10, function ($ancestors) use ($rank) {
                            foreach ($ancestors as $parent) {
                                $parent->ranks()->where('rank', 1)->increment('total_rankers');
                            }
                        });
                    }
                    $rank = 2;
                    $position = $user->position;
                    if ($is_active) {
                        self::upgradeGenealogyAncestorsRank($user, $rank, $position, true);
                    }
                }
            }

        });
    }

    /**
     * @throws JsonException
     */
    public static function upgradeGenealogyAncestorsRank(self $user, int $rank, $position, $is_active = false): void
    {
        // logger("line: 304 -" . $user->id);
        if ($rank > config('rank-system.rank_level_count', 10)) {
            return;
        }
        if ($is_active && !empty($user->parent_id)) {
            $parent = $user->parent;
            // logger("line: 310 -" . $parent->id);

            if ($parent->currentRank->rank === (int)$rank) {
                return;
            }

            //dispatch(function () use ($parent, $rank, $position, $is_active) {
            do { // upgrade every parent rank
                $user_rank = Rank::firstOrCreate(
                    ['user_id' => $parent->id, 'rank' => $rank],
                    ['eligibility' => 0, 'total_rankers' => 0]
                );

                $synced_eligibility_positions = $user_rank->eligibility_positions ? json_decode($user_rank->eligibility_positions, true, 512, JSON_THROW_ON_ERROR) : [];
                $current_eligibility_positions = $synced_eligibility_positions;

                if (in_array($position, $synced_eligibility_positions, true)) {
                    break;
                }

                $synced_eligibility_positions[] = $position;

                $eligibility = count($synced_eligibility_positions);
                $eligibility_positions = json_encode($synced_eligibility_positions, JSON_THROW_ON_ERROR);
                $is_active = $eligibility >= config('rank-system.rank_eligibility_activate_at', 3);
                $activated_at = $is_active ? now() : null;

                if (!$user_rank->is_active) {
                    $user_rank->update(compact('eligibility', 'eligibility_positions', 'activated_at'));
                    if ($is_active && (count(array_diff($synced_eligibility_positions, $current_eligibility_positions)) !== 0)) {
                        foreach ($parent->ancestors()->get() as $ancestor) {
                            $ancestor->ranks()->where('rank', $rank)->increment('total_rankers');
                        }
                    }
                    $position = $parent->position;
                    if ($is_active) { // level up every parent rank by one
                        self::upgradeGenealogyAncestorsRank($parent, $rank + 1, $position, true);
                    }
                }

                // logger("line: 348 -" . $parent->id);
                if ($parent->parent_id === null) {
                    break;
                }
                $parent = $parent->parent;
                // logger("line: 353 -" . $parent->id);
            } while ($parent->id !== null);
            //})->afterCommit()->onConnection('sync');
        }
    }
}
