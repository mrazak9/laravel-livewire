<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama;
    public $email;
    public $alamat;

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];
        $pesan = [
            'nama.required' => 'Nama Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'email.email' => 'Format Email tidak sesuai',
            'alamat.required' => 'Alamat Wajib diisi',
        ];
        $validated = $this->validate($rules, $pesan);

        ModelsEmployee::create($validated);
        session()->flash('message', 'Data berhasil disimpan');
    }

    public function render()
    {
        $data = ModelsEmployee::orderBy('nama', 'asc')->paginate(10);
        return view('livewire.employee', ['dataEmployees' => $data]);
    }
}
