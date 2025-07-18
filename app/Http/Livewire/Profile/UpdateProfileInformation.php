<?php

namespace App\Http\Livewire\Profile;


use App\Mail\ProfileModifyMail;
use App\Services\OTPService;
use App\Traits\MaskCredentials;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Validator;

class UpdateProfileInformation extends Component
{
    use WithFileUploads;
    use MaskCredentials;


    public $state = [];

    public $photo;

    public $binanceQrCode;

    public $verificationLinkSent = false;

    public $otp = null;
    public $otpSent = false;


    public function mount()
    {
        $lastOTPRequestTime = session('update_profile_information_last_otp_requested_at');
        if ($lastOTPRequestTime && now()->diffInMinutes($lastOTPRequestTime) < 5) {
            $this->otpSent = true;
        }
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->state['email'] = self::maskedEmailAddress(auth()->user()->email);
        //$this->state['phone'] = MaskCredentials::maskedPhone(auth()->user()->phone);
    }

    /**
     * @throws Exception
     */
    public function sendOTP(): void
    {
        // Check if the last OTP request time is stored in the session
        $lastOTPRequestTime = session('update_profile_information_last_otp_requested_at');

        $this->resetErrorBag();
        if ($lastOTPRequestTime && now()->diffInMinutes($lastOTPRequestTime) < 5) {
            // Calculate the remaining time until they can request a new OTP
            $remainingTime = 5 - now()->diffInMinutes($lastOTPRequestTime);

            // Add an error with the remaining time
            $this->addError('otp', "Please wait {$remainingTime} minutes before requesting a new OTP.");
            return;
        }
        $res = (new OTPService())->sendOTPCode(auth()->user())->getData();
        try {

            if ($res->status) {
                session()->flash('message', 'OTP Has sent to your Email');
                $this->otpSent = true;
                session(['update_profile_information_last_otp_requested_at' => now()]);
            }
        } catch (Exception $e) {
            $this->otpSent = true;
        }

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $validated = Validator::make(['otp' => $this->otp], [
            'otp' => 'required|digits:6',
        ])->validate();

        $hashed_username = hash("sha512", auth()->user()?->username);
        $hashed_code = hash("sha512", $validated['otp']);
        if (!session()->has($hashed_username) || session()->get($hashed_username) !== $hashed_code) {
            $this->addError('otp', 'Entered OTP code is invalid!');
            return null;
        }

        $old_data = [
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone,
        ];
        $state = $this->state;
        if ($this->photo) {
            $state = [...$state, 'photo' => $this->photo];
        }
        if ($this->binanceQrCode) {
            $state = [...$state, 'profile_info' => [...$state['profile_info'], 'binance_qr_code' => $this->binanceQrCode]];
        }

        $updater->update(Auth::user(), $state);

        session()->forget('update_profile_information_last_otp_requested_at');
        session()->forget($hashed_username);
        $this->otpSent = false;
        $this->otp = null;

        if (auth()->user()->email !== $old_data['email'] || auth()->user()->phone !== $old_data['phone']) {
            Mail::to($old_data['email'])
                ->cc(auth()->user()->email)
                ->send(new ProfileModifyMail(auth()->user(), $old_data));
        }

        if (isset($this->photo) || isset($this->binanceQrCode)) {
            return redirect()->route('profile.show');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
        return null;
    }

    public function deleteProfilePhoto(): void
    {
        Auth::user()->deleteProfilePhoto();

        $this->emit('refresh-navigation-menu');
    }

    public function sendEmailVerification()
    {
        Auth::user()->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information');
    }
}
