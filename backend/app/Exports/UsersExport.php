<?php

namespace App\Exports;

use App\Models\TestingUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $users = TestingUser::all();

        return $users->map(function ($user) {
            return [
                'ID'          => $user->id,
                'Name'        => $user->name,
                'Email'       => $user->email,
                'Phone'       => $user->phone_number,
                'Status'      => $user->status,
                'Created At'  => $user->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Phone', 'Status', 'Created At'];
    }
}
