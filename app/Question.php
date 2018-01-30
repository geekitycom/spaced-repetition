<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function calculateI($n, $recalc = false)
    {
        if (1 === $n) {
            return 1;
        } elseif (2 === $n) {
            return 6;
        } else {
            if ($recalc) {
                return ceil($this->calculateI($n - 1, $recalc) * $this->ef);
            } else {
                return ceil($this->i * $this->ef);
            }
        }
    }

    public function calculateEf($q)
    {
        // EF':=EF+(0.1-(5-q)*(0.08+(5-q)*0.02))

        $q = max(0, min(5, intval($q)));

        $ef = $this->ef + (0.1 - (5 - $q) * (0.08 + (5 - $q) * 0.02));

        return max(1.3, min(2.5, $ef));
    }

    public function calculateNext($i)
    {
        return Carbon::now()->addDays($i)->format('Y-m-d');
    }
}
