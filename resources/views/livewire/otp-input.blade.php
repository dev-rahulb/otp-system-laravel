<?php

use Livewire\Volt\Component;
use App\Models\OTP;

new class extends Component {
    public $generatedOtp;
    public $message;
    public $otpError;
    public $code = '';

    public function generateOTP()
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OTP::create([
            'user_id' => auth()->id() ?? 1,
            'code' => $code,
            'type' => 'email',
            'expires_at' => now()->addMinutes(15),
        ]);

        $this->generatedOtp = $code;
        $this->message = 'OTP generated successfully!';
        $this->otpError = null;
    }

    public function updatedCode($value)
    {
        if (strlen($value) !== 6 || !ctype_digit($value)) {
            $this->otpError = 'OTP must be 6 digits.';
            $this->message = null;
            return;
        }

        $otp = OTP::where('user_id', auth()->id() ?? 1)
            ->where('code', $value)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            $this->otpError = 'Invalid or expired OTP.';
            $this->message = null;
            return;
        }

        $otp->update(['verified_at' => now()]);
        $this->message = '✅ OTP Verified!';
        $this->otpError = null;
    }
};
?>

<div class="flex flex-col items-center justify-center min-h-screen p-4 bg-gray-100">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm p-6 space-y-6">
        
        <!-- ✅ Button updated to dispatch event to clear inputs -->
        <button 
            wire:click="generateOTP"
            x-on:click="$dispatch('clear-otp')"
            class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all"
        >
            Generate OTP
        </button>

        @if ($generatedOtp)
            <div class="text-center text-gray-800 text-sm font-medium">
                <strong>Generated OTP:</strong> {{ $generatedOtp }}
            </div>
        @endif

  <div 
    x-data="{
        otp: Array(6).fill(''),
        refs: [],
        code: @entangle('code').defer,
        generatedOtp: @entangle('generatedOtp'),
        init() {
            this.$watch('otp', value => {
                const joined = this.otp.join('');
                if (joined.length === 6) {
                    this.code = joined;
                    $wire.set('code', joined); // 🔁 Explicitly trigger Livewire
                }
            });

            this.$watch('generatedOtp', () => {
                this.otp = Array(6).fill('');
                this.refs[0]?.focus();
            });
        },
        onPaste(e) {
            const paste = e.clipboardData.getData('text').trim();
            if (paste.length === 6 && /^\d+$/.test(paste)) {
                this.otp = [...paste];
                this.code = paste;
                $wire.set('code', paste); // 🔁 Ensure Livewire sync
            }
        },
        onInput(index, event) {
            this.otp[index] = event.target.value;
            if (event.target.value && index < 5) {
                setTimeout(() => {
                    this.refs[index + 1]?.focus();
                }, 10);
            }
        }
    }"
    x-init="init"
    @paste="onPaste"
    class="flex flex-col items-center space-y-4"
>


            <div class="flex justify-center space-x-2">
                <template x-for="(digit, index) in otp" :key="index">
                    <input
                        type="text"
                        maxlength="1"
                        x-model="otp[index]"
                        x-init="refs[index] = $el"
                        @input="onInput(index, $event)"
                        class="w-10 h-12 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none text-lg transition-all"
                    />
                </template>
            </div>

            <div class="text-sm text-center">
                @if ($otpError)
                    <div class="text-red-600 font-medium">{{ $otpError }}</div>
                @endif

                @if ($message)
                    <div class="text-green-600 font-medium">{{ $message }}</div>
                @endif
            </div>

            <div wire:loading class="text-gray-500 text-sm">Processing...</div>
        </div>
    </div>
</div>
