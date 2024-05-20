<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Chờ xác nhận'],
            ['name' => 'Đã xác nhận'],
            ['name' => 'Đang xử lý'],
            ['name' => 'Đang giao hàng'],
            ['name' => 'Đã giao hàng'],
            ['name' => 'Hoàn thành'],
            ['name' => 'Đã huỷ'],
        ];

        Status::insert($statuses);
    }
}
