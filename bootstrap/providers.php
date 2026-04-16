use App\Models\User;
use App\Models\Profile;

public function boot(): void
{
    User::created(function ($user) {
        Profile::create([
            'user_id' => $user->id
        ]);
    });
}