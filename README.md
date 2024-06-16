php artisan vendor:publish --provider="Geekpack\Api\ApiServiceProvider" --force

agregar lineas en databaseseeder:

use Geekpack\Api\Database\Seeders\ApiRoutesSeeder;

funcion run: $this->call(ApiRoutesSeeder::class);

o ejecutar esta linea:

php artisan db:seed --class=Geekpack\Api\Database\Seeders\ApiRoutesSeeder


modelo usuario:

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Geekpack\Api\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail


use HasApiTokens

public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordNotification($token));
}

