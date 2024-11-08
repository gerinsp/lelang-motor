<?php

namespace App\Livewire\Forms;

use App\Jobs\LelangBerlangsungJob;
use App\Models\FotoMotor;
use App\Models\Lelang;
use App\Models\Motor;
use App\Models\Nasabah;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LelangForm extends Form
{
    public ?Lelang $lelang_model;

    #[Validate]
    public array $motor = [
        'nama',
        'keterangan',
        'tahun_pembuatan',
        'merk',
        'jenis',
        'kapasitas_mesin',
        'bahan_bakar',
        'odometer',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_polisi',
        'warna',
        'stnk',
        'masa_berlaku_stnk',
        'bpkb',
        'faktur',
        'foto_kopi_ktp',
        'kwitansi_blanko',
        'form_a',
    ];

    #[Validate]
    public array $nasabah = [
        'nama',
        'alamat',
        'no_hp',
        'utang',
        'hapus_buku',
        'kredit_lunas',
    ];

    #[Validate]
    public array $lelang = [
        'keterangan',
        'status_lelang',
        'waktu_mulai_lelang',
        'waktu_selesai_lelang',
        'harga_awal',
        'uang_jaminan'
    ];

    #[Validate]
    public array $foto_motor = [];

    public function rules()
    {
        $rules = [
            'motor.keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],
            'motor.tahun_pembuatan' => [
                'required',
                'integer',
                'digits:4',
                'min:2000',
                'max:' . date('Y'),
            ],
            'motor.merk' => [
                'required',
                'string',
                'max:255',
            ],
            'motor.jenis' => [
                'required',
                'string',
                'max:255',
            ],
            'motor.kapasitas_mesin' => [
                'required',
                'integer',
                'min:0',
                'max:1500',
            ],
            'motor.bahan_bakar' => [
                'required',
                'string',
                'max:255',
            ],
            'motor.odometer' => [
                'required',
                'integer',
                'min:0',
            ],
            'motor.nomor_rangka' => [
                'required',
                'string',
                'max:255',
            ],
            'motor.nomor_mesin' => [
                'required',
                'string',
                'max:255',
            ],
            'motor.nomor_polisi' => [
                'required',
                'string',
                'max:255',
            ],
            'motor.warna' => [
                'required',
                'string',
            ],
            'motor.stnk' => [
                'required',
                'boolean',
            ],
            'motor.masa_berlaku_stnk' => [
                'required',
                'date',
                'date_format:Y-m-d',
            ],
            'motor.bpkb' => [
                'required',
                'boolean',
            ],
            'motor.faktur' => [
                'required',
                'boolean',
            ],
            'motor.foto_kopi_ktp' => [
                'required',
                'boolean',
            ],
            'motor.kwitansi_blanko' => [
                'required',
                'boolean',
            ],
            'motor.form_a' => [
                'required',
                'boolean',
            ],

            'nasabah.nama' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'nasabah.alamat' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'nasabah.no_hp' => [
                'required',
                'string',
                'min:9',
                'max:13',
            ],
            'nasabah.utang' => [
                'required',
                'integer',
                'min:0',
            ],

            'lelang.keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],
            'lelang.status_lelang' => [
                'required',
                'string',
                'in:akan datang,berlangsung,selesai',
            ],
            'lelang.waktu_mulai_lelang' => [
                'required',
                'date',
            ],
            'lelang.waktu_selesai_lelang' => [
                'nullable',
                'date',
            ],
            'lelang.harga_awal' => [
                'required',
                'integer',
                'min:0',
            ],
            'lelang.uang_jaminan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'foto_motor' => [
                'required',
                'array',
            ],
            'foto_motor.*' => [
                'image',
                'mimes:jpeg,png,jpg,svg,gif,bmp,webp',
                'max:2048'
            ],
        ];
        if (isset($this->lelang_model) && $this->foto_motor === $this->lelang_model->motor?->fotoMotor->toArray()) {
            $rules['foto_motor.*'] = 'nullable';
        }

        return $rules;
    }

    public function validateMotor()
    {
        $offset = 0;
        $length = 18;
        $dataMotor = array_slice($this->rules(), $offset, $length, true);
        $this->validate($dataMotor);
    }

    public function validateFotoMotor()
    {
        $offset = 28;
        $length = 2;
        $dataFotoMotor = array_slice($this->rules(), $offset, $length, true);
        $this->validate($dataFotoMotor);
    }

    public function validateNasabah()
    {
        $offset = 18;
        $length = 4;
        $dataNasabah = array_slice($this->rules(), $offset, $length, true);
        $this->validate($dataNasabah);
    }
    public function validateLelang()
    {
        $offset = 22;
        $length = 6;
        $dataLelang = array_slice($this->rules(), $offset, $length, true);
        $this->validate($dataLelang);
    }

    public function setData(Lelang $lelang)
    {
        $this->lelang_model = $lelang;
        if ($lelang->id) {
            $this->motor = $lelang->motor->toArray();
            $this->nasabah = $lelang->motor->nasabah->toArray();
            $this->lelang = $lelang->toArray();
            $this->foto_motor = $lelang->motor->fotoMotor->toArray();
            // Ubah format $lelang->waktu_mulai_lelang ke format 'Y-m-d H:i:s'
            $this->lelang['waktu_mulai_lelang'] = date('Y-m-d H:i:s', strtotime($lelang->waktu_mulai_lelang));
            $this->lelang['waktu_selesai_lelang'] = date('Y-m-d H:i:s', strtotime($lelang->waktu_selesai_lelang));
        }
    }

    public function store()
    {
        // Insert motor
        $this->motor['nama'] = $this->motor['merk'] . ' ' . $this->motor['jenis'];
        $motor = Motor::create($this->motor);

        $this->lelang['id_motor'] = $motor->id;
        $this->nasabah['id_motor'] = $motor->id;

        // Insert nasabah
        Nasabah::create($this->nasabah);

        // Insert lelang
        $createdLelang = Lelang::create($this->lelang);

        // Jalankan LelangBerlangsungJob jika status lelang akan datang
        if ($createdLelang->status_lelang === 'akan datang') {
            LelangBerlangsungJob::dispatch($createdLelang)->delay($createdLelang->waktu_mulai_lelang);
        }

        // Insert foto motor
        foreach ($this->foto_motor as $image) {
            $alt = time() . '_' . $image->getClientOriginalName();
            $src = $image->storeAs('motors', $alt, 'public');
            FotoMotor::create(['id_motor' => $motor->id, 'src' => $src, 'alt' => $alt]);
        }
    }

    public function update()
    {
        if ($this->lelang_model->motor->merk !== $this->motor['merk'] || $this->lelang_model->motor->jenis !== $this->motor['jenis']) {
            $this->motor['nama'] = $this->motor['merk'] . ' ' . $this->motor['jenis'];
        }
        $this->lelang_model->motor->update($this->motor);
        $this->lelang_model->motor->nasabah->update($this->nasabah);
        $this->lelang_model->update($this->lelang);
        if ($this->foto_motor !== $this->lelang_model->motor->fotoMotor->toArray()) {
            // Delete foto motor
            foreach ($this->lelang_model->motor->fotoMotor as $fotoMotor) {
                $fotoMotor->delete();
            }
            // Insert foto motor
            foreach ($this->foto_motor as $image) {
                $alt = time() . '_' . $image->getClientOriginalName();
                $src = $image->storeAs('motors', $alt, 'public');
                FotoMotor::create(['id_motor' => $this->lelang_model->motor->id, 'src' => $src, 'alt' => $alt]);
            }
        }
    }
}
