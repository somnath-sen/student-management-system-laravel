use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

public function run(): void
{
    Role::insert([
        ['id' => 1, 'name' => 'admin'],
        ['id' => 2, 'name' => 'teacher'],
        ['id' => 3, 'name' => 'student'],
    ]);

    User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('admin123'),
        'role_id' => 1,
    ]);
}
