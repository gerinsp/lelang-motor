<?php
use Illuminate\Support\Facades\Cache;
use function Livewire\Volt\{mount, state, title};
use App\Models\Lelang;

title('Lelang');

mount(function (Lelang $lelang) {
    if (now() > $lelang->waktu_selesai_lelang || $lelang->status_lelang === 'selesai') {
        return abort(404);
    }
    $lelang->load(['motor.fotoMotor','penawaranLelang']);
    $this->lelang = $lelang;
});

state([
    'lelang',
    'tawaran',
]);

$buatTawaran = function () {
    if(now() > $this->lelang->waktu_selesai_lelang){
        $this->dispatch('notify', variant: 'danger', title: 'Gagal', message: 'Lelang sudah selesai');
        return;
    }
    if ($this->lelang->penawaran_akhir <  $this->tawaran) {
        $this->lelang->penawaranLelang()->attach(auth()->user()->id, ['penawaran' => $this->tawaran]);
        $this->lelang->penawaran_akhir = $this->tawaran;
        $this->lelang->id_pemenang = auth()->user()->id;
        $this->lelang->waktu_selesai_lelang = now()->addMinutes(1);
        $this->lelang->save();
        $this->dispatch('notify', variant: 'success', title: 'Berhasil', message: 'Penawaranmu Disetujui');
    } else {
        $this->dispatch('notify', variant: 'danger', title: 'Gagal', message: 'Penawaranmu Harus lebih besar dari ' . $this->lelang->penawaran_akhir);
    }
};

$selesaikanLelang = function () {
    if (now() > $this->lelang->waktu_selesai_lelang && $this->lelang->status_lelang !== 'selesai') {
        $lock = Cache::lock('foo', 10);
        if ($lock->get()) {
            $this->lelang->status_lelang = 'selesai';
            $this->lelang->save();
            $lock->release();
        }
    }
};


with(fn () => [
    'lelang' => $this->lelang,
]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between" id="lelang-title">
        <h1>Lelang</h1>
    </div>
    <div class="flex flex-wrap items-center justify-between gap-4 mt-4" wire:poll.1s="selesaikanLelang">
        <div class="flex-1 mx-auto ">
            <div class="max-w-sm mx-auto overflow-hidden rounded-lg shadow-md dark:bg-slate-800">
                <img src="{{ 'storage/' .$lelang->motor->fotoMotor->first()->src) }}" alt="{{ $lelang->motor->nama }}"
                    class="object-cover w-full h-48">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-rose-600 dark:text-rose-500">{{ $lelang->motor->nama }}</h2>
                    <p class="mt-2 text-sm text-gray-400">Harga saat ini <span
                            class="font-bold text-rose-600 dark:text-rose-500">Rp
                            {{$lelang->penawaran_akhir_ribuan }}</span></p>
                    <form wire:submit='buatTawaran' class="flex items-center mt-4">
                        <input type="number" wire:model.live="tawaran" name="tawaran" id="tawaran"
                            class="w-2/3 px-3 py-2 mr-2 border rounded-md bg-slate-100 dark:bg-slate-700 border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-600"
                            placeholder="Masukkan harga tawaran">
                        <button wire:loading.attr="disabled"
                            class="w-1/3 px-4 py-2 text-white rounded-md bg-rose-600 hover:bg-rose-700">Tawar</button>
                    </form>
                    @if ($lelang->waktu_selesai_lelang < now()) <div class="my-2 text-sm text-rose-600">Lelang sudah
                        selesai
                </div>
                @else
                <div class="my-2 text-sm">
                    {{ $lelang->waktu_selesai_lelang->diffForHumans() }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="flex-1 mx-auto">
        <div class="max-w-md p-6 mx-auto bg-white rounded-lg shadow-md dark:bg-slate-800 ">
            <h2 class="mb-4 text-xl font-bold text-slate-800 dark:text-white">Penawaran Pengguna</h2>
            <ul class="max-h-[50vh] overflow-y-auto no-scrollbar">
                @foreach ($lelang->penawaranLelang as $penawaran)
                <li class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-slate-700">
                    <div>
                        <p class="font-semibold text-slate-800 dark:text-white">{{ $penawaran->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Rp {{
                            number_format($penawaran->pivot->penawaran, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-sm text-slate-500 dark:text-slate-400">{{
                        $penawaran->pivot->created_at->diffForHumans() }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>