<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Constants\AppConstants;
use App\Http\Requests\User\BorrowBook\InfoUserRequest;
use App\Models\BorrowedBook;
use Illuminate\Support\Carbon;



class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $isSearchSubmitted = !empty($search); // Kiểm tra xem đã submit search chưa

        $books = Book::query()
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('code', 'LIKE', '%' . $search . '%');
                });
            })
            ->paginate(AppConstants::PAGE);

        $currentPage = $books->currentPage();
        $startIndex = ($currentPage - 1) * AppConstants::PAGE;

        if (!is_numeric($currentPage) || $currentPage < 1 || $currentPage > $books->lastPage()) {
            return redirect()->back();
        }

        $countBooks = $books->total();

        return view('user.bookBorrowing.index', compact(
            'books',
            'startIndex',
            'countBooks',
            'search',
            'isSearchSubmitted' 
        ));
    }

    public function borrow($bookId)
    {
        $book = Book::findOrFail($bookId);
        $availableQuantity = $book->getAvailableQuantity();

        if ($availableQuantity >= 1) {
            return view('user.bookBorrowing.user_info', compact('bookId'));
        } else {
            return redirect()->route('borrow.index')->with('msg', 'Books not available. Please borrow it again another day!');
        }
    }

    public function infoUser(InfoUserRequest $request)
    {
        $bookId = $request->input('bookId');
        $borrowerName = $request->input('name');
        $email = $request->input('email');
        $citizenId = $request->input('code');
        $returnDate = $request->input('returnDate');

        // Tạo user nếu chưa tồn tại
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $borrowerName,
                'email' => $email,
                'code' => $citizenId,
                'role' => 'user',
            ]);
        } else {
            $user->code = $citizenId;
            $user->save();
        }
        
        // Lưu thông tin mượn sách
        $borrowing = new BorrowedBook();
        $borrowing->book_id = $bookId;
        $borrowing->borrow_date = new Carbon();
        $borrowing->return_date = $returnDate;
        $borrowing->user()->associate($user);
        $borrowing->save();
        $borrowing->code = 'B-' . $borrowing->id;
        $borrowing->status='Chưa duyệt';
        $borrowing->save();

        $book = Book::findOrFail($bookId);
        $book->borrowBook();
        return redirect()->route('borrow.index')->with('msg', 'Borrowing a successful book! The code to borrow a book is ' . $borrowing->code);
    }
}
