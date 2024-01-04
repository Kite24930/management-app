<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 部署作成(2024/1月時点)
        Department::create([
            'name' => '本部',
            'parent_department' => 0,
            ]);
        Department::create([
            'name' => '開発部',
            'parent_department' => 0,
            ]);
        Department::create([
            'name' => '広報部',
            'parent_department' => 0,
            ]);
        Department::create([
            'name' => '管理部',
            'parent_department' => 1,
            ]);
        Department::create([
            'name' => '第一開発課',
            'parent_department' => 2,
            ]);
        Department::create([
            'name' => '第二開発課',
            'parent_department' => 2,
            ]);
        Department::create([
            'name' => '企画課',
            'parent_department' => 3,
            ]);
        Department::create([
            'name' => '広報課',
            'parent_department' => 3,
            ]);
    }
}
