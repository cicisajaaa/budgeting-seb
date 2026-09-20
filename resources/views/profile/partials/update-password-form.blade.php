<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>


    <form
        method="post"
        action="{{ route('password.update') }}"
        class="mt-6 space-y-6">

        @csrf
        @method('put')


        {{-- CURRENT PASSWORD --}}
        <div>
            <x-input-label
                for="update_password_current_password"
                :value="__('Current Password')" />

            <div class="profile-password-wrapper">

                <x-text-input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password" />

                <button
                    type="button"
                    class="profile-password-toggle"
                    data-target="update_password_current_password"
                    aria-label="Tampilkan password">

                    <svg class="eye-open" viewBox="0 0 24 24">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>

                    <svg class="eye-closed" viewBox="0 0 24 24">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 3.9"></path>
                        <path d="M6.6 6.6C3.6 8.4 2 12 2 12s3.5 7 10 7a10.8 10.8 0 0 0 4.2-.8"></path>
                    </svg>

                </button>

            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2" />
        </div>


        {{-- NEW PASSWORD --}}
        <div>
            <x-input-label
                for="update_password_password"
                :value="__('New Password')" />

            <div class="profile-password-wrapper">

                <x-text-input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password" />

                <button
                    type="button"
                    class="profile-password-toggle"
                    data-target="update_password_password"
                    aria-label="Tampilkan password">

                    <svg class="eye-open" viewBox="0 0 24 24">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>

                    <svg class="eye-closed" viewBox="0 0 24 24">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 3.9"></path>
                        <path d="M6.6 6.6C3.6 8.4 2 12 2 12s3.5 7 10 7a10.8 10.8 0 0 0 4.2-.8"></path>
                    </svg>

                </button>

            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2" />
        </div>


        {{-- CONFIRM PASSWORD --}}
        <div>
            <x-input-label
                for="update_password_password_confirmation"
                :value="__('Confirm Password')" />

            <div class="profile-password-wrapper">

                <x-text-input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password" />

                <button
                    type="button"
                    class="profile-password-toggle"
                    data-target="update_password_password_confirmation"
                    aria-label="Tampilkan password">

                    <svg class="eye-open" viewBox="0 0 24 24">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>

                    <svg class="eye-closed" viewBox="0 0 24 24">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 3.9"></path>
                        <path d="M6.6 6.6C3.6 8.4 2 12 2 12s3.5 7 10 7a10.8 10.8 0 0 0 4.2-.8"></path>
                    </svg>

                </button>

            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2" />
        </div>


        {{-- BUTTON --}}
        <div class="flex items-center gap-4">

            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">

                    {{ __('Saved.') }}

                </p>

            @endif

        </div>

    </form>


    <style>

        .profile-password-wrapper {
            position: relative;
            width: 100%;
        }

        .profile-password-wrapper input {
            width: 100% !important;
            padding-right: 50px !important;
        }

        .profile-password-wrapper input::-webkit-credentials-auto-fill-button {
    display: none !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

.profile-password-wrapper input::-webkit-textfield-decoration-container {
    display: none !important;
}
        .profile-password-toggle {
            position: absolute;

            top: 50%;
            right: 12px;

            transform: translateY(-50%);

            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0;
            margin: 0;

            border: none;
            background: transparent;

            color: #64748b;

            cursor: pointer;

            z-index: 20;
        }

        .profile-password-toggle:hover {
            color: #1e293b;
        }

        .profile-password-toggle:focus {
            outline: none;
        }

        .profile-password-toggle svg {
            width: 18px;
            height: 18px;

            fill: none;
            stroke: currentColor;

            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;

            pointer-events: none;
        }

        .profile-password-toggle .eye-closed {
            display: none;
        }

        .profile-password-toggle.active .eye-open {
            display: none;
        }

        .profile-password-toggle.active .eye-closed {
            display: block;
        }

    </style>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const buttons =
                document.querySelectorAll('.profile-password-toggle');

            buttons.forEach(function (button) {

                button.addEventListener('click', function () {

                    const target =
                        document.getElementById(this.dataset.target);

                    if (!target) {
                        return;
                    }

                    if (target.type === 'password') {

                        target.type = 'text';

                        this.classList.add('active');

                        this.setAttribute(
                            'aria-label',
                            'Sembunyikan password'
                        );

                    } else {

                        target.type = 'password';

                        this.classList.remove('active');

                        this.setAttribute(
                            'aria-label',
                            'Tampilkan password'
                        );

                    }

                });

            });

        });

    </script>

</section>