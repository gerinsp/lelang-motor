<?php

namespace App\Livewire\Forms;

use App\Models\TransaksiSaldoUser;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TopupForm extends Form
{
    public ?TransaksiSaldoUser $topup;

    #[Validate('required|string|max:255')]
    public string $keterangan = '';

    #[Validate('required|in:pemasukan,pengeluaran')]
    public string $arus_transaksi = 'pemasukan';

    #[Validate('required|in:pending,validated,rejected')]
    public string $status = 'pending';

    #[Validate('required|numeric|min:0')]
    public int $nominal = 0;

    // bukti transaksi
    #[Validate]
    public $bukti_transaksi;

    public function rules()
    {
        $rules = [];
        if (isset($this->topup->bukti_transaksi) && $this->topup->bukti_transaksi === $this->bukti_transaksi) {
            $rules['bukti_transaksi'] = 'nullable';
        } else {
            $rules['bukti_transaksi'] = 'required|image|mimes:jpeg,png,jpg,svg,gif,bmp,webp|max:2048';
        }
        return $rules;
    }

    public function setData(TransaksiSaldoUser $topup)
    {
        $this->topup = $topup;
        if ($topup->id) {
            $this->keterangan = $topup->keterangan;
            $this->arus_transaksi = $topup->arus_transaksi;
            $this->nominal = $topup->nominal;
            $this->bukti_transaksi = $topup->bukti_transaksi;
        }
    }

    public function store()
    {
        $this->validate();
        $data = $this->except('topup');

        $fileName = time() . '_' . $this->bukti_transaksi->getClientOriginalName();
        $path = $this->bukti_transaksi->storeAs('bukti_topup', $fileName, 'public');
        $data['bukti_transaksi'] = $path;

        $data['id_user'] = auth()->user()->id;
        $data['arus_transaksi'] = 'pemasukan';

        TransaksiSaldoUser::create($data);
    }

    public function update()
    {
        $this->validate();

        if ($this->bukti_transaksi === $this->topup->bukti_transaksi) {
            $data = collect($this->except('bukti_transaksi', 'topup'));
        } else {
            $data = collect($this->except('topup'));
            $fileName = time() . '_' . $this->bukti_transaksi->getClientOriginalName();
            $path = $this->bukti_transaksi->storeAs('avatars', $fileName, 'public');
            $data['bukti_transaksi'] = $path;
        }

        $this->topup->update($data->toArray());
    }
}
