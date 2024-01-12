<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('プロフィール編集') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("プロフィールの情報を編集できます。") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="icon" :value="__('アイコン')" />
            <div class="flex items-center">
                <div id="iconWrapper" class="inline-flex justify-center items-center">
                    @if($user->icon)
                        <x-icons.icon src="{{ $user->id.'/'.$user->icon }}" alt="{{ $user->name }}" class="w-10 h-10" />
                    @else
                        <x-icons.person-circle class="w-10 h-10 text-xl">{{ $user->name }}</x-icons.person-circle>
                    @endif
                </div>
                <input type="file" id="icon" name="icon" accept="image/jpeg, image/png">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('icon')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('氏名')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('ログイン用メールアドレス')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

{{--            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())--}}
            @if (! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('メールアドレスが認証されていません。') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('認証用メールを再送信する場合はここをクリックしてください。') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="belong_to" :value="__('所属')" />
            <x-select-input id="belong_to" name="belong_to" class="mt-1 block w-full" required>
                <option value="" class="hidden">所属を選択してください。</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @if($department->id === $user->belong_to) selected @endif>{{ $department->name }}</option>
                @endforeach
            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('belongTo')" />
        </div>

        <div>
            <x-input-label for="post" :value="__('役職')" />
            <x-text-input id="post" name="post" type="text" class="mt-1 block w-full" :value="old('post', $user->post)" required autocomplete="post" />
            <x-input-error class="mt-2" :messages="$errors->get('post')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
