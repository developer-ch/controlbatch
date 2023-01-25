<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function address(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value
        );
    }

    public function productCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value
        );
    }

    public function productDescription(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value
        );
    }

    public function process(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value
        );
    }

    public function batch(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value
        );
    }

    public function netWeight(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_replace(',', '.', $value)
        );
    }

    public function expedition(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => $value
        );
    }

    public static function listExpedition()
    {
        return self::where('expedition','<>','')->orderByDesc('updated_at')->get(['expedition'])->unique('expedition');
    }

    public static function listProcessNotExpedition()
    {
        return self::where('expedition','')->orderBy('process')->get(['process'])->unique('process');
    }

    public static function listProductNotExpedition(string $process = "")
    {
        if($process)
            return self::where('expedition','')->whereProcess($process)->orderBy('product_code')->get(['product_code'])->unique('product_code');
        return self::where('expedition','')->orderBy('product_code')->get(['product_code'])->unique('product_code');
        
    }
}
