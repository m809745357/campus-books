<?php

namespace App\Policies;

use App\User;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the book.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Book  $book
     * @return mixed
     */
    public function view(User $user, Book $book)
    {
        return $user->id === $book->onwer->id && $book->type === 'EBook';
    }

    /**
     * 是否可以下单预览
     *
     * @param  User   $user [description]
     * @param  Book   $book [description]
     * @return [type]       [description]
     */
    public function preview(User $user, Book $book)
    {
        return $user->id !== $book->onwer->id && $book->status == '1';
    }

    /**
     * 是否可以新增订单
     *
     * @param User $user [description]
     * @param Book $book [description]
     */
    public function addOrder(User $user, Book $book)
    {
        return $book->status == 1;
    }
}
