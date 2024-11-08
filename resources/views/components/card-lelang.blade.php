@props([
'lelang',
])

<div class="w-full overflow-hidden bg-white rounded-lg shadow-lg dark:bg-slate-800 dark:text-slate-300">
    <img src="{{ asset('storage/' . $lelang->motor->fotoMotor->first()->src) }}" alt="{{ $lelang->motor->nama }}"
        class="object-cover w-full h-48 rounded-t-lg">
    <div class="p-6">
        <h2 class="mb-2 text-2xl font-bold text-gray-800 dark:text-slate-300">{{ $lelang->motor->nama }}</h2>
        <p class="mb-4 text-gray-600 dark:text-slate-400">{{ $lelang->motor->keterangan }}</p>

        <div class="flex flex-wrap items-center justify-between mb-4">
            <span class="text-xl font-semibold text-blue-600 dark:text-blue-400">Rp {{
                $lelang->harga_awal_ribuan }}</span>
            <span class="text-sm text-gray-500">{{ $lelang->waktu_mulai_lelang->format('H:i') }}
                WIB</span>
        </div>

        <div class="flex items-center mb-4">
            <span
                class="bg-green-100 capitalize text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-600 dark:text-green-100">{{
                $lelang->status_lelang }}</span>
            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $lelang->waktu_mulai_lelang->isToday()
                ?'Hari ini' : $lelang->waktu_mulai_lelang->format('d-m-Y')}}</span>
        </div>

        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="flex items-center">
                <svg class="mr-2 size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM15.8329 7.33748C16.0697 7.17128 16.3916 7.19926 16.5962 7.40381C16.8002 7.60784 16.8267 7.92955 16.6587 8.16418C14.479 11.2095 13.2796 12.8417 13.0607 13.0607C12.4749 13.6464 11.5251 13.6464 10.9393 13.0607C10.3536 12.4749 10.3536 11.5251 10.9393 10.9393C11.3126 10.5661 12.9438 9.36549 15.8329 7.33748ZM17.5 11C18.0523 11 18.5 11.4477 18.5 12C18.5 12.5523 18.0523 13 17.5 13C16.9477 13 16.5 12.5523 16.5 12C16.5 11.4477 16.9477 11 17.5 11ZM6.5 11C7.05228 11 7.5 11.4477 7.5 12C7.5 12.5523 7.05228 13 6.5 13C5.94772 13 5.5 12.5523 5.5 12C5.5 11.4477 5.94772 11 6.5 11ZM8.81802 7.40381C9.20854 7.79433 9.20854 8.4275 8.81802 8.81802C8.4275 9.20854 7.79433 9.20854 7.40381 8.81802C7.01328 8.4275 7.01328 7.79433 7.40381 7.40381C7.79433 7.01328 8.4275 7.01328 8.81802 7.40381ZM12 5.5C12.5523 5.5 13 5.94772 13 6.5C13 7.05228 12.5523 7.5 12 7.5C11.4477 7.5 11 7.05228 11 6.5C11 5.94772 11.4477 5.5 12 5.5Z">
                    </path>
                </svg>
                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $lelang->motor->odometer }}
                    KM</span>
            </div>
            <div class="flex items-center">
                <svg class="mr-2 size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                    </path>
                </svg>
                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $lelang->motor->tahun_pembuatan
                    }}</span>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6 gap-x-2">
            @if ($lelang->waktu_mulai_lelang->diffInMinutes(now()) >= -10 &&
            $lelang->waktu_mulai_lelang->diffInMinutes(now()) <= 0) <a
                href="{{ route('users.lelang.join', $lelang->id) }}" wire:navigate
                class="flex-1 px-4 py-2 text-white transition duration-200 bg-blue-500 rounded-lg hover:bg-blue-600">
                Ikut Lelang
                </a>
                @else
                <div class="inline-flex items-center flex-1 gap-1">
                    <svg class="size-5 animate-slow-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 2C12.5523 2 13 2.44772 13 3V6C13 6.55228 12.5523 7 12 7C11.4477 7 11 6.55228 11 6V3C11 2.44772 11.4477 2 12 2ZM12 17C12.5523 17 13 17.4477 13 18V21C13 21.5523 12.5523 22 12 22C11.4477 22 11 21.5523 11 21V18C11 17.4477 11.4477 17 12 17ZM22 12C22 12.5523 21.5523 13 21 13H18C17.4477 13 17 12.5523 17 12C17 11.4477 17.4477 11 18 11H21C21.5523 11 22 11.4477 22 12ZM7 12C7 12.5523 6.55228 13 6 13H3C2.44772 13 2 12.5523 2 12C2 11.4477 2.44772 11 3 11H6C6.55228 11 7 11.4477 7 12ZM19.0711 19.0711C18.6805 19.4616 18.0474 19.4616 17.6569 19.0711L15.5355 16.9497C15.145 16.5592 15.145 15.9261 15.5355 15.5355C15.9261 15.145 16.5592 15.145 16.9497 15.5355L19.0711 17.6569C19.4616 18.0474 19.4616 18.6805 19.0711 19.0711ZM8.46447 8.46447C8.07394 8.85499 7.44078 8.85499 7.05025 8.46447L4.92893 6.34315C4.53841 5.95262 4.53841 5.31946 4.92893 4.92893C5.31946 4.53841 5.95262 4.53841 6.34315 4.92893L8.46447 7.05025C8.85499 7.44078 8.85499 8.07394 8.46447 8.46447ZM4.92893 19.0711C4.53841 18.6805 4.53841 18.0474 4.92893 17.6569L7.05025 15.5355C7.44078 15.145 8.07394 15.145 8.46447 15.5355C8.85499 15.9261 8.85499 16.5592 8.46447 16.9497L6.34315 19.0711C5.95262 19.4616 5.31946 19.4616 4.92893 19.0711ZM15.5355 8.46447C15.145 8.07394 15.145 7.44078 15.5355 7.05025L17.6569 4.92893C18.0474 4.53841 18.6805 4.53841 19.0711 4.92893C19.4616 5.31946 19.4616 5.95262 19.0711 6.34315L16.9497 8.46447C16.5592 8.85499 15.9261 8.85499 15.5355 8.46447Z">
                        </path>
                    </svg>
                    <span>{{ abs(floor($lelang->waktu_mulai_lelang->diffInMinutes(now()))) }} menit</span>
                </div>
                @endif
                <a href="{{ route('users.lelang.detail', $lelang->id) }}" wire:navigate
                    class="flex-1 px-4 py-2 text-center transition duration-200 rounded-lg text-slate-700 bg-slate-300 hover:bg-slate-400">
                    Lihat Detail
                </a>
        </div>
    </div>
</div>