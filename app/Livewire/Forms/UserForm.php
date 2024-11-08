<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate]
    public string $email = '';

    #[Validate('required|string|min:6')]
    public string $password = '';

    #[Validate('required|boolean')]
    public bool $is_admin = false;

    #[Validate]
    public $avatar = null;

    public int $saldo = 0;

    public function rules()
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $this->user->id ?? null
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,svg,gif,bmp,webp',
                'max:2048'
            ]
        ];
        if (isset($this->user) && $this->avatar === $this->user?->avatar) {
            $rules['avatar'] = 'nullable';
        }

        return $rules;
    }

    public function setData(User $user)
    {
        $this->user = $user;
        if ($user->id) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->is_admin = $user->is_admin;
            $this->avatar = $user->avatar;
            $this->saldo = $user->saldo;
        }
    }

    public function store()
    {
        $this->validate();

        $data = $this->except('user', 'avatar');

        $path = 'default-avatar.png';
        if ($this->avatar) {
            $fileName = time() . '_' . $this->avatar->getClientOriginalName();
            $path = $this->avatar->storeAs('avatars', $fileName, 'public');
        }
        $data['avatar'] = $path;

        User::create($data);
    }

    public function update()
    {
        $this->validate();

        $isSamePassword = ($this->password === $this->user->password) || (Hash::check($this->password, $this->user->password));
        if ($isSamePassword) {
            $data =  collect($this->except('user', 'password'));
        } else {
            $data = collect($this->except('user'));
        }

        if ($this->avatar !== $this->user?->avatar) {
            $fileName = time() . '_' . $this->avatar->getClientOriginalName();
            $path = $this->avatar->storeAs('avatars', $fileName, 'public');
            $data['avatar'] = $path;
        } else {
            $data = collect($data->except('avatar'));
        }

        $this->user->update($data->toArray());
    }
}
