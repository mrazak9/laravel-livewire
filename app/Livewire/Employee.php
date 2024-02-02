<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $employee_id;
    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;

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
        $this->clear();
        session()->flash('message', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->employee_id = $id;
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;
        $this->updateData = true;
    }


    public function update()
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
        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validated);
        $this->clear();
        session()->flash('message', 'Data berhasil diubah');
    }

    public function clear()
    {
        $this->employee_id = '';
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';
        $this->updateData = false;
    }

    public function render()
    {
        $data = ModelsEmployee::orderBy('nama', 'asc')->paginate(10);
        return view('livewire.employee', ['dataEmployees' => $data]);
    }
}
