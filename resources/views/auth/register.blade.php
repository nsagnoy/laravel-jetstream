<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="country" value="{{ __('Country') }}" />
                {{--<x-jet-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required/>--}}
                <select name="country" id="country" class="block mt-1 w-full">
                    @foreach(array_keys($countries) as $country)
                        <option value="{{$country}} @if ($country == 'Afghanistan') selected @endif">{{$country}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="city" value="{{ __('City') }}" />
                {{--<x-jet-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required/>--}}
                <select name="city" id="city" class="block mt-1 w-full">
                    @foreach($countries['Afghanistan'] as $city)
                        <option value="{{$city}}" @if ($city == 'Herat') selected @endif">{{$city}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="address" value="{{ __('Address') }}" />
                <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="zip" value="{{ __('Zip') }}" />
                <x-jet-input id="zip" class="block mt-1 w-full" type="number" name="zip" :value="old('zip')" required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="birth_date" value="{{ __('Birth Date') }}" />
                <x-jet-input id="birth_date" class="block mt-1 w-full" type="text" name="birth_date" :value="old('birth_date')" placeholder="yyyy-mm-dd" pattern="\d{4}-\d{2}-\d{2}"  required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="phone_no" value="{{ __('Phone No') }}" />
                <x-jet-input id="phone_no" class="block mt-1 w-full" type="number" name="phone_no" :value="old('phone_no')" required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <select name="role" class="block mt-1 w-full">
                    <option value="1">Admin</option>
                    <option value="2" @if (old('role') == 2) selected @endif>User</option>
                </select>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<script type="text/javascript">
    var countries = <?php echo json_encode($countries) ?>;


    $(document).ready(function (){
        $('#country').change(function (){
            $('#city').empty()

            var selectedCountry =  $('#country').find(":selected").text();
            var cities = countries[selectedCountry];

           $.each(cities, function (i, city){
               $('#city').append('<option value='+city+'>'+city+'</option>')
           })
        })
    })
</script>


