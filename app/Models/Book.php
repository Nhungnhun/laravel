<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function borrowBook()
    {
        $this->borrowed_quantity += 1;
        $this->save();
    }

    public function returnBook()
    {
        $this->borrowed_quantity -= 1;
        $this->save();
    }

    public function getAvailableQuantity()
    {
        return $this->quantity;
    }


    public function borrowedBook()
    {
        return $this->hasOne(BorrowedBook::class);
    }
}
