<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogError extends Model
{
    public $table      = 'logs_error';

    protected $guarded = [];

    protected $casts = [
      'trace'       => 'array',
      'params'      => 'array',
      'header'      => 'array',
  ];
}
