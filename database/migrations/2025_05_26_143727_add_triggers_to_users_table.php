<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop triggers if they exist to avoid errors on re-running migrations
        DB::unprepared('DROP TRIGGER IF EXISTS set_department_on_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS set_department_on_update');

        // Create trigger for INSERT
        DB::unprepared("
            CREATE TRIGGER set_department_on_insert
            BEFORE INSERT ON users
            FOR EACH ROW
            BEGIN
                IF NEW.department IS NULL AND NEW.nidn IS NOT NULL THEN
                    SET NEW.department = CASE 
                        WHEN LEFT(NEW.nidn, 2) = '11' THEN 'Teknik Informatika'
                        WHEN LEFT(NEW.nidn, 2) = '12' THEN 'Sistem Informasi'
                        ELSE NULL 
                    END;
                END IF;
            END;
        ");

        // Create trigger for UPDATE
        DB::unprepared("
            CREATE TRIGGER set_department_on_update
            BEFORE UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF NEW.department IS NULL AND NEW.nidn IS NOT NULL THEN
                    SET NEW.department = CASE 
                        WHEN LEFT(NEW.nidn, 2) = '11' THEN 'Teknik Informatika'
                        WHEN LEFT(NEW.nidn, 2) = '12' THEN 'Sistem Informasi'
                        ELSE NULL 
                    END;
                END IF;
            END;
        ");
    }

    public function down(): void
    {
        // Drop triggers in the down method
        DB::unprepared('DROP TRIGGER IF EXISTS set_department_on_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS set_department_on_update');
    }
};