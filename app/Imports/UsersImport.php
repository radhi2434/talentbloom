<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class UsersImport implements ToCollection, WithHeadingRow
{
    public int $created = 0;
    public int $updated = 0;
    public int $skipped = 0;

    public function __construct(private string $role)
    {
        // role: 'student' / 'teacher'
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $rowData = array_values($row->toArray());

            // Common fields
            $name        = trim((string)($rowData[0] ?? ''));
            $email       = strtolower(trim((string)($rowData[1] ?? '')));
            $gender      = ucfirst(strtolower(trim((string)($rowData[2] ?? ''))));
            $date_joined = $rowData[5] ?? null;

            if ($name === '' || $email === '') {
                $this->skipped++;
                continue;
            }

            $updateData = [
                'name'        => $name,
                'email'       => $email,
                'role'        => $this->role,
                'gender'      => $gender,
                'date_joined' => $date_joined ? Carbon::parse($date_joined) : null,
            ];

            // Role-specific
            if ($this->role === 'teacher') {
                $phone    = preg_replace('/[^0-9]/', '', $rowData[3] ?? '');
                $position = trim((string)($rowData[4] ?? ''));

                $updateData['phone']    = $phone;
                $updateData['position'] = $position;

            } else { // student
                $form          = trim((string)($rowData[3] ?? ''));
                $class_name    = trim((string)($rowData[4] ?? ''));

                $updateData['form']       = $form;
                $updateData['class_name'] = $class_name; // ✅ assign ke class_name
            }

            // Check existing user
            $existing = User::where('email', $email)->first();

            if ($existing) {
                if ($existing->role === 'admin') {
                    $this->skipped++;
                    continue;
                }

                $existing->update($updateData);
                $this->updated++;
                continue;
            }

            // Create new user
            $createData = array_merge($updateData, ['password' => Hash::make('abc123')]);
            User::create($createData);
            $this->created++;
        }
    }
}