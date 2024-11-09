    <div class="relative bg-cover bg-center"
        style="background-image: url({{ asset('vendor/assets/images/bg-auth-2.jpg') }})">
        <div class="absolute inset-0 dark:bg-black/80"></div>
        <div class="relative flex flex-col items-center justify-start py-20 h-screen">
            <div class="flex justify-center pt-10">
                <div class="max-w-lg px-4 mx-auto">
                    <div class="card overflow-hidden bg-white">
                        <div class="p-9">
                            <div class="text-center mx-auto w-full flex items-center justify-center flex-col mb-2">
                                <img src="{{ asset('logo-blue.png') }}" alt="logo" width="100" height="100"
                                    class="h-auto">
                                <h4 class="text-center text-primary text-lg uppercase font-bold mb-8">Sign In</h4>
                            </div>
                            @if (session('status'))
                                <div class="bg-white/10 text-white border border-white/20 rounded py-3 px-5"
                                    role="alert">
                                    <span class="font-bold">Error</span> {{ session('status') }}
                                </div>
                            @endif
                            <form wire:submit="save" class="sm:w-80">
                                <div class="mb-6 space-y-2">
                                    <label for="emailaddress" class="font-medium text-primary">Email/Username</label>
                                    <input
                                        class="form-input placeholder:text-gray-400 text-gray-400"wire:model="email_or_username"
                                        id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="mb-6 space-y-2">
                                    <label for="password" class="font-medium text-primary">Password</label>
                                    <input type="password" wire:model="password" id="password"
                                        class="form-input placeholder:text-gray-400 text-gray-400"
                                        placeholder="Enter your password">
                                </div>

                                <div class="text-center mb-6">
                                    <button class="btn bg-primary w-full text-white" type="submit">
                                        <span wire:loading.class="hidden">Log In</span>
                                        <span wire:loading.class.remove="hidden" class="hidden">Loading...</span>
                                    </button>
                                </div>
                            </form> <!-- form end -->
                        </div>
                    </div>
                </div>
            </div> <!-- flex end -->
        </div> <!-- flex end -->
    </div>
