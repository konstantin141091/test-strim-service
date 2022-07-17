<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class StreamPassword extends Model
{
    use HasFactory;

    protected $table = 'stream_passwords';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'stream_id',
        'password',
    ];

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword($password) {
        if (Hash::check($password, $this->password)) {
            $this->status = true;
            $this->save();
            return true;
        }
        return false;
    }
}
