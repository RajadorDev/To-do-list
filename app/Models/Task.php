<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
    const DESCRIPTION_LEN = 400;

    const TITLE_LEN = 14;

    protected $fillable = ['title', 'description', 'user_id'];

    public function getIcon() : string 
    {
        $iconId = $this->is_completed ? 'img/check.png' : 'img/unchecked.png';
        return asset($iconId);
    }

    public function getLimitedDescription(int $max) : string 
    {
        $description = $this->description;
        $len = strlen($description);
        if ($len > $max) {
            $description = substr($description, 0, $max) . '...';
        }
        return $description;
    }

    public function canBeEdited() : bool 
    {
        return !$this->is_completed;
    }

    public function canBeChecked() : bool 
    {
        return $this->canBeEdited();
    }

    
}
