<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BanksoalDetail
 *
 * @property string $id
 * @property string|null $banksoal_id
 * @property string|null $label
 * @property string|null $isi
 * @property bool|null $is_correct
 * @property int|null $urutan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Banksoal|null $banksoal
 *
 * @package App\Models
 */
class BanksoalDetail extends Model
{
    use HasUlids;

    protected $table = 'banksoal_detail';
    public $incrementing = false;

    protected $casts = [
        'is_correct' => 'bool',
        'urutan' => 'int'
    ];

    protected $fillable = [
        'banksoal_id',
        'label',
        'isi',
        'is_correct',
        'urutan'
    ];

    public function banksoal()
    {
        return $this->belongsTo(Banksoal::class);
    }
}
