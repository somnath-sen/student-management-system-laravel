<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Self-healing migration: normalizes the roles table to have guaranteed
 * canonical IDs (admin=1, teacher=2, student=3, parent=4) and repairs
 * any users.role_id values that point to the wrong role due to historical
 * seeder/migration ordering differences between environments.
 */
return new class extends Migration
{
    /**
     * Canonical role definitions: name → fixed ID
     */
    private array $canonical = [
        'admin'   => 1,
        'teacher' => 2,
        'student' => 3,
        'parent'  => 4,
    ];

    public function up(): void
    {
        // ── Step 1: Read current roles ────────────────────────────────────────
        $currentRoles = DB::table('roles')->get()->keyBy('name');

        // Build map: old_id → new_canonical_id  (only for roles that need moving)
        $remaps = []; // [ old_id => new_id ]
        foreach ($this->canonical as $name => $newId) {
            if ($currentRoles->has($name)) {
                $oldId = (int) $currentRoles[$name]->id;
                if ($oldId !== $newId) {
                    $remaps[$oldId] = $newId;
                }
            }
        }

        if (empty($remaps)) {
            // Already correct — just ensure all 4 roles exist
            $this->ensureAllRolesExist();
            return;
        }

        // ── Step 2: Disable FK checks ─────────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ── Step 3: Move users to temp IDs (9000+) to avoid collision ─────────
        $tempBase = 9000;
        foreach ($remaps as $oldId => $newId) {
            DB::table('users')
                ->where('role_id', $oldId)
                ->update(['role_id' => $tempBase + $oldId]);
        }

        // ── Step 4: Move temp IDs to canonical IDs ────────────────────────────
        foreach ($remaps as $oldId => $newId) {
            DB::table('users')
                ->where('role_id', $tempBase + $oldId)
                ->update(['role_id' => $newId]);
        }

        // ── Step 5: Rebuild roles table with canonical IDs ────────────────────
        DB::table('roles')->delete();

        $now = now();
        foreach ($this->canonical as $name => $id) {
            DB::table('roles')->insert([
                'id'         => $id,
                'name'       => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ── Step 6: Re-enable FK checks ───────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Ensure all 4 canonical roles exist (used when IDs are already correct).
     */
    private function ensureAllRolesExist(): void
    {
        $now = now();
        foreach ($this->canonical as $name => $id) {
            if (!DB::table('roles')->where('id', $id)->exists()) {
                DB::table('roles')->insert([
                    'id'         => $id,
                    'name'       => $name,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Non-reversible data migration — intentionally left as no-op.
    }
};
